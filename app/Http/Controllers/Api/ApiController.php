<?php namespace App\Http\Controllers\api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\City;
use App\OfferStore;
use App\Offer;
use App\User;
use App\Cart;
use App\CartCoupen;
use App\AppUser;
use App\Order;
use App\Lang;
use App\Rate;
use App\Slider;
use App\Banner;
use App\Address;
use App\Admin;
use App\Page;
use App\Language;
use App\Text;
use App\Delivery;
use Complex\Exception;
use DB;
use Validator;
use Redirect;
use Excel;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Stripe;

class ApiController extends Controller {

    public function configuration()
	{
		return response()->json(['data' => Admin::find(1)]);
	}

	public function welcome()
	{
		$res = new Slider;

		return response()->json(['data' => $res->getAppData()]);
	}

	public function city()
	{
		$city = new City;
        $text = new Text;
        $lid =  isset($_GET['lid']) && $_GET['lid'] > 0 ? $_GET['lid'] : 0;
        $now = Carbon::now()->format("H:m:s");

        if ($id = \request('id')){
            $available_rest = User::where('city_id', $id)->where('open', 0)
                ->whereRaw("STR_TO_DATE(opening_time, '%H:%i') < time(now()) and STR_TO_DATE(closing_time, '%H:%i') > time(now())")
                ->get();

            return response()->json(['data' => $available_rest,'text'		=> $text->getAppData($lid)]);
        }

		return response()->json(['data' => $city->getAll(0),'text'		=> $text->getAppData($lid)]);
	}

	public function lang()
	{
		$res = new Language;

		return response()->json(['data' => $res->getWithEng()]);
	}

	public function homepage($city_id)
	{
		$banner  = new Banner;
		$store   = new User;
		$text    = new Text;
        $lid     =  isset($_GET['lid']) && $_GET['lid'] > 0 ? $_GET['lid'] : 0;
        $l 		 = Language::find($lid);

		$data = [

		'banner'	=> $banner->getAppData($city_id,0),
		'middle'	=> $banner->getAppData($city_id,1),
		'bottom'	=> $banner->getAppData($city_id,2),
        'store_categories' => \DB::table('user_category')->select('id','name')->get(),
		'store' 	=> $store->openStoresData($city_id),
		'trending'	=> $store->getAppData($city_id,true),
		'text'		=> $text->getAppData($lid),
		'app_type'	=> isset($l->id) ? $l->type : 0,
		'admin'		=> Admin::find(1)

        ];

		return response()->json(['data' => $data]);
	}

	public function search($query,$type,$city)
	{
		$user = new User;

		return response()->json(['data' => $user->getUser($query,$type,$city)]);
	}

	public function addToCart(Request $Request)
	{
		$res = new Cart;

		return response()->json(['data' => $res->addNew($Request->all())]);
	}

	public function updateCart($id,$type)
	{
		$res = new Cart;

		return response()->json(['data' => $res->updateCart($id,$type)]);
    }

    public function getCurrentOrder()
	{
        $order = null;

        if(isset($_GET['user_id']) && $_GET['user_id'] > 0)
        {
            $order = Order::where('user_id',$_GET['user_id'])->whereIn('status',[0,1,3,4,5])->first();

        }

        $order->store = User::find($order->store_id)->name;

        return response()->json([
            'data' => array(
                "currency" => "$",
                "data" => $order
            )
        ]);
	}

	public function cartCount($cartNo)
	{
	  if(isset($_GET['user_id']) && $_GET['user_id'] > 0)
	  {
          $order = Order::where('user_id',$_GET['user_id'])->whereIn('status',[0,1,3,4,5])->count();

	  }
	  else
	  {
	  	$order = 0;
	  }

	  $cart = new Cart;

	  return response()->json([

	  	'data'  => Cart::where('cart_no',$cartNo)->count(),
	  	'order' => $order,
	  	'cart'	=> $cart->getItemQty($cartNo)

	  	]);
	}

	public function getCart($cartNo)
	{
		$res = new Cart;

		return response()->json(['data' => $res->getCart($cartNo)]);
	}

	public function getOffer($cartNo)
	{
		$res = new Offer;

		return response()->json(['data' => $res->getOffer($cartNo)]);
	}

	public function applyCoupen($id,$cartNo)
	{
		$res = new CartCoupen;
        $cart = Cart::where('cart_no',$cartNo)->first();
        $user = User::find($cart->store_id);
        $offer = Offer::find($id);

        if (!isset($user))
            return response()->json(['success' => false, 'message' => 'Uno de los productos seleccionados no esta asociado a un negocio valido.']);

        if (!isset($offer))
            return response()->json(['success' => false, 'message' => 'El cupon solicitado no se encuentra en nuestros registros.']);

		return response()->json($res->addNew($id,$cartNo));
	}

	public function signup(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->addNew($Request->all()));
	}

	public function login(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->login($Request->all()));
	}

	public function forgot(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->forgot($Request->all()));
	}

	public function verify(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->verify($Request->all()));
	}

	public function updatePassword(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->updatePassword($Request->all()));
	}

	public function loginFb(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->loginFb($Request->all()));
	}

	public function getAddress($id)
	{
		$address = new Address;
		$cart 	 = new Cart;

		$data 	 = [

		'address'	 => $address->getAll($id),
		'admin'      => Admin::find(1),
		'total'   	 => $cart->getCart($_GET['cart_no'])['total']

		];

		return response()->json(['data' => $data]);
	}

	public function addAddress(Request $Request)
	{
		$res = new Address;

		return response()->json($res->addNew($Request->all()));
    }

    public function removeAddress($id)
	{
		$res = new Address;

		return response()->json($res->removeNew($id));
	}

	public function order(Request $Request)
	{
		$res = new Order;

		return response()->json($res->addNew($Request->all()));
	}

	public function userinfo($id)
	{
		return response()->json(['data' => AppUser::find($id)]);
	}

	public function updateInfo($id,Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->updateInfo($Request->all(),$id));
	}

	public function cancelOrder($id,$uid)
	{
		$res = new Order;

		return response()->json($res->cancelOrder($id,$uid));
	}

	public function sendChat(Request $Request)
	{
		$user = new AppUser;

		return response()->json($user->sendChat($Request->all()));

	}

	public function rate(Request $Request)
	{
		$rate = new Rate;

		return response()->json($rate->addNew($Request->all()));

	}

	public function pages()
	{
		$res = new Page;

		return response()->json(['data' => $res->getAppData()]);
	}

	public function myOrder($id)
	{
		$res = new Order;

		return response()->json(['data' => $res->history($id)]);
    }

    public function conektaCard() {

        \Conekta\Conekta::setApiVersion("2.0.0");
        \Conekta\Conekta::setLocale('es');
        \Conekta\Conekta::setApiKey(Admin::find(1)->stripe_api_id);

        if(isset($_GET['user_id']) && $_GET['user_id'] > 0) {

            $user = AppUser::find($_GET['user_id']);

            if (isset($user->id_conekta)) {
                $customer = \Conekta\Customer::find($user->id_conekta);
                $data = [];
                foreach($customer->payment_sources as $item) {
                    array_push($data, $item);
                }

                return response()->json(['data' => $data]);

            } else {
                return response()->json(['data' => []]);
            }
        } else {
            return response()->json(['data' => "error"]);
        }
    }

	public function stripe()
	{
        if(isset($_GET['user_id']) && $_GET['user_id'] > 0) {

            $user = AppUser::find($_GET['user_id']);
            $newCard = filter_var($_GET['newCard'], FILTER_VALIDATE_BOOLEAN);

            \Conekta\Conekta::setApiVersion("2.0.0");
            \Conekta\Conekta::setLocale('es');
            \Conekta\Conekta::setApiKey(Admin::find(1)->stripe_api_id);

            if (!isset($user->id_conekta)) {
                /**Creamos el cliente */
                try {
                    /*$customer = \Conekta\Customer::create(
                    [
                        "name" => $_GET['name'],
                        "email" => $user->email,
                        "phone" => $user->phone,
                        "payment_sources" => [
                        [
                            "type" => "card",
                            "token_id" => $_GET['token']
                        ]
                        ]
                    ]);*/

                    $customer = \Conekta\Customer::create(
                        [
                            "name" => $_GET['name'],
                            "email" => $user->email,
                            "phone" => $user->phone
                        ]);

                    $user->id_conekta = $customer->id;

                    $source = $customer->createPaymentSource(
                        [
                            "type" => "card",
                            "token_id" => $_GET['token']
                        ]
                    );

                    $res = new AppUser;

                    $res->updateInfo($user,$user->id);

                } catch (Exception $e) {
                    return response()->json(['data' => "error"]);
                }
            } else if ($newCard) {
                $customer = \Conekta\Customer::find($user->id_conekta);
                $source = $customer->createPaymentSource(
                    [
                        "type" => "card",
                        "token_id" => $_GET['token']
                    ]
                );
            }

            if (!$newCard) {

                $valid_order =
                    [
                        'line_items'=> [
                            [
                                'name'        => 'Comida Rapida',
                                'description' => 'Cobro de comida rapida.',
                                'unit_price'  => $_GET['amount'] * 100,
                                'quantity'    => 1,
                                'sku'         => 'cohb_s1',
                                'category'    => 'food',
                                'tags'        => ['food']
                            ]
                        ],
                        'currency' => 'mxn',
                        "customer_info" => [
                            "customer_id" => $user->id_conekta
                        ],
                        'currency' => 'mxn',
                        'charges' => [
                            [
                            'payment_method' => [
                                "type" => "card",
                                "payment_source_id" => $_GET['token']
                            ]
                            ]
                        ]
                    ];
            } else {
                $valid_order =
                    [
                        'line_items'=> [
                            [
                                'name'        => 'Comida Rapida',
                                'description' => 'Cobro de comida rapida.',
                                'unit_price'  => $_GET['amount'] * 100,
                                'quantity'    => 1,
                                'sku'         => 'cohb_s1',
                                'category'    => 'food',
                                'tags'        => ['food']
                            ]
                        ],
                        'currency' => 'mxn',
                        "customer_info" => [
                            "customer_id" => $user->id_conekta
                        ],
                        'currency' => 'mxn',
                        'charges' => [
                            [
                            'payment_method' => [
                                "type" => "card",
                                "payment_source_id" => $source->id
                            ]
                            ]
                        ]
                    ];
            }

            try {
                //$order = \Conekta\Order::create($validOrder);
                $order = \Conekta\Order::create($valid_order);

                if($order->payment_status === "paid")
                {
                    return response()->json(['data' => "done",'id' => $order->id]);
                }
                else
                {
                    return response()->json(['data' => "error"]);
                }
            } catch (\Conekta\Handler $error) {
                dd($error);
                //Normal object methods
                echo($error->getMessage());
                echo($error->getCode());
                echo($error->getLine());
                echo($error->getTraceAsString());

                //Conekta object
                var_dump($error->getConektaMessage());

                //Conekta object props
                $conektaError = $error->getConektaMessage();
                var_dump($conektaError->type);
                var_dump($conektaError->details);

                //Object iteration
                $conektaError = $error->getConektaMessage();
                foreach ($conektaError->details as $key) {
                echo($key->debug_message);
                }
            } catch (Exception $error) {
                dd($error);
            }
        }
    }

    public function removeCard($id)
	{
            if(isset($_GET['user_id']) && $_GET['user_id'] > 0) {

                $user = AppUser::find($_GET['user_id']);

                \Conekta\Conekta::setApiVersion("2.0.0");
                \Conekta\Conekta::setLocale('es');
                \Conekta\Conekta::setApiKey(Admin::find(1)->stripe_api_id);

                $customer = \Conekta\Customer::find($user->id_conekta);
                foreach($customer->payment_sources as $source) {
                    if ($id == $source->id) {
                        $success = $source->delete();
                        return response()->json(['data' => "done"]);
                    break;
                    }
                }
            }
	}

	public function getStatus($id)
	{
		$order = Order::find($id);
		$dboy  = Delivery::find($order->d_boy);

		return response()->json(['data' => $order,'dboy' => $dboy]);
	}
}
