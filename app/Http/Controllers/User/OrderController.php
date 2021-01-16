<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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

	public $folder  = "user.order.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res = new Order;

		if($_GET['status'] == 0)
		{
			$title = "Nuevos pedidos";
		}
		elseif($_GET['status'] == 1)
		{
			$title = "Ordenes en ejecución";
		}
		elseif($_GET['status'] == 2)
		{
			$title = "Órdenes canceladas";
		}
		elseif($_GET['status'] == 3)
		{
			$title = "Dispatched Orders";
		}
		elseif($_GET['status'] == 5)
		{
			$title = "Órdenes completadas ";
		}

		return View($this->folder.'index',[

			'data' 		=> $res->getAll(null,Auth::user()->id),
			'link' 		=> 'order/',
			'title' 	=> $title,
			'item'		=> new OrderItem,
			'boys'		=> Delivery::where('status',0)->where('store_id',0)->get(),
			'form_url'	=> 'order/dispatched',
			'currency'	=> Admin::find(1)->currency
		]);
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

		return Redirect::back()->with('message','Estado del pedido cambiado correctamente');
	}

	public function printBill($id)
	{
		$order = new Order;
		$item  = new OrderItem;

		return View('user.order.print',[

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
		'item'		=> Item::where('store_id',Auth::user()->id)->get(),
		'detail'	=> $item->detail($id),
		'form_url'	=> 'order/edit/'.$id,
		'users'		=> User::get()


		]);
	}

	public function orderItem()
	{
		return View($this->folder.'item',['item' => Item::where('store_id',Auth::user()->id)->get(),'data' => new Order]);
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

		return Redirect('order?status=1')->with('message','Orden de edición exitosa');
	}

	public function add()
	{
		return View($this->folder.'add',[

		'data' 		=> new Order,
		'item'		=> Item::get(),
		'form_url'	=> 'order/add',
		'users'		=> User::get()

		]);
	}

	public function _add(Request $Request)
	{
		$order = new Order;

		$order->editOrder($Request->all(),0);

		return Redirect('order?status=1')->with('message','Orden agregada exitosamente');
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
}
