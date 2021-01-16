<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OfferStore;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\City;
use App\Order;
use App\OrderItem;
use App\Delivery;
use App\Admin;
use App\Item;
use DB;
use Validator;
use Redirect;
use IMS;
class OrderController extends Controller {

	public $folder  = "admin/order.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
        $res = new Order;

        if (!isset($_GET['status']) )
            return redirect()->to("admin/order?status=0");

		if($_GET['status'] == 0)
		{
			$title = "Nuevas Ordenes";
		}
		elseif($_GET['status'] == 1)
		{
			$title = "Ordenes en proceso";
		}
		elseif($_GET['status'] == 2)
		{
			$title = "Ordenes canceladas";
		}
		elseif($_GET['status'] == 3)
		{
			$title = "Ordenes enviadas";
        }
        elseif($_GET['status'] == 4)
		{
			$title = "Ordenes";
		}
		elseif($_GET['status'] == 6)
		{
			$title = "Ordenes completadas";
        }

		return View($this->folder.'index',[

			'data' 		=> $res->getAll(),
			'link' 		=> env('admin').'/order/',
			'title' 	=> $title,
			'item'		=> new OrderItem,
			'boys'		=> Delivery::where('status',0)->where('store_id',0)->get(),
			'form_url'	=> env('admin').'/order/dispatched',
			'currency'	=> Admin::find(1)->currency,
		]);
    }

    public function assing()
	{
        $res = new Order;
        $title = "Asignar Ordenes";

		return View($this->folder.'assing',[

			'data' 		=> $res->getAll(),
			'link' 		=> env('admin').'/order/',
			'title' 	=> $title,
			'item'		=> new OrderItem,
			'boys'		=> Delivery::where('status',0)->where('store_id',0)->get(),
			'form_url'	=> env('admin').'/order/dispatched',
			'currency'	=> Admin::find(1)->currency
		]);
    }

    public function assingDelivery($id)
	{
        $order = Order::find($id);
        $city = City::all();

		return View($this->folder.'delivery',[

		'data' 		=> $order,
		'city'		=> $city,
		'form_url'	=> env('admin').'/order/assing/delivery/'.$id,
		'users'		=> User::get()


		]);
    }

    public function assingDeliveryStore(Request $request,$id)
	{

        $order = Order::find($id);
        $order->d_boy = $request->delivery_id;
        $order->status = 0;
        $order->save();

		return Redirect::to(env('admin').'/order/assing?status=-1');
	}

	public function orderStatus()
	{
		$res 				= Order::find($_GET['id']);
		$res->status 		= $_GET['status'];
		$res->status_by 	= 1;
		$res->status_time 	= date('d-M-Y').' | '.date('h:i:A');
		$res->save();

		$res->sendSms($_GET['id']);

		return Redirect::back()->with('message','Estado del pedido cambiado correctamente');
	}

	public function dispatched(Request $Request)
	{
		$res 				= Order::find($Request->get('id'));
		$res->status 		= 3;
		$res->status_by 	= 1;
		$res->d_boy 		= $Request->get('d_boy');
		$res->status_time 	= date('d-M-Y').' | '.date('h:i:A');
		$res->save();

		$res->sendSms($Request->get('id'));

		return Redirect::back()->with('message','El estado del pedido se modific�� correctamente');
	}

	public function printBill($id)
	{
		$order = new Order;
		$item  = new OrderItem;

		return View('admin.order.print',[

		'order' 	=> $order->signleOrder($id),
		'items'		=> $item->getItem($id),
		'currency'	=> Admin::find(1)->currency,
		'it'		=> $item

		]);
	}

	public function edit($id)
	{
		$order = Order::find($id);
		$item  = new OrderItem;

		return View($this->folder.'edit',[

		'data' 		=> $order,
		'item'		=> Item::where('store_id',$order->store_id)->get(),
		'detail'	=> $item->detail($id),
		'form_url'	=> env('admin').'/order/edit/'.$id,
		'users'		=> User::get(),
        'store_id' => $order->store_id


		]);
	}

	public function orderItem()
	{
		return View($this->folder.'item',['item' => Item::where('store_id',$_GET['store_id'])->get(),'data' => new Order]);
	}

	public function getUnit($id)
	{
		$order = new Order;

		$html = "<select name='unit[]'' class='form-control' required='required'>";

		foreach($order->getUnit($id) as $u)
		{
			$html .= "<option value='".$u['id']."'>".$u['name']."</option>";
		}

		$html .= "</select>";

		return $html;
	}

	public function _edit(Request $Request,$id)
	{
		$order = new Order;

		$order->editOrder($Request->all(),$id);

		return Redirect(env('admin').'/order?status=1')->with('message','Orden de edici��n exitosa');
	}

	public function add()
	{
		return View($this->folder.'add',[

		'data' 		=> new Order,
		'item'		=> Item::get(),
		'form_url'	=> env('admin').'/order/add',
		'users'		=> User::get(),
        'offers' => null,

		]);
	}

	public function _add(Request $Request)
	{
		$order = new Order;

		$order->editOrder($Request->all(),0);

		return Redirect(env('admin').'/order?status=1')->with('message','Orden agregada exitosamentey');
	}

	public function getUser($phone)
	{
		$user = Order::where('phone',$phone)->first();

		if(isset($user->id))
		{
			$array = ['phone' => $user->phone,'name' => $user->name,'address' => $user->address];
		}
		else
		{
			$array = [];
		}

		return $array;
	}


    public function getAvailableOffers(Request $request){

        $subtotal = 0;
        foreach ($request['items'] as $value){
            $item = Item::find($value['id']);

            switch ($value['size']){
                case 1 :
                    $cost = $item->small_price;
                    break;
                case 2 :
                    $cost = $item->medium_price;
                    break;
                case 3 :
                    $cost = $item->large_price;
                    break;
                default:
                    $cost = 0;
                    break;
            }

            $subtotal += $cost * $value['qty'];
        }

        $offers = OfferStore::join('offer','offer.id','=','offer_store.offer_id')
        ->where('offer_store.store_id', $request['store_id'])
        ->whereRaw("offer.min_cart_value IS NOT NULL AND offer.min_cart_value <= $subtotal")
        ->where('offer.status',0)->get();

        foreach ($offers as $offer){

            $upto = $offer['upto'];

            if ($offer['type'] === 0) // percent discount
                $discount = ($offer['value'] / 100) * $subtotal;

            if ($offer['type'] === 1) // defined discount
                $discount = $offer['value'];

            $offer['discount'] =+ $discount < $upto || $upto == null || $upto < 0 ? $discount: $upto;
        }

        return response()->json(['success'=> true, 'data' => $offers]);

    }
}
