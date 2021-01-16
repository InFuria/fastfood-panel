<?php namespace App\Http\Controllers\api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Delivery;
use App\Order;
use App\Language;
use App\Text;
use App\User;
use App\Item;
use DB;
use Validator;
use Redirect;
use Excel;
use Stripe;
class StoreController extends Controller {

	public function homepage()
	{
		$res 	 = new Order;
		$text    = new Text;
		$l 		 = Language::find($_GET['lid']);

		return response()->json([

		'data' 		=> $res->storeOrder(),
		'complete' 	=> $res->storeOrder(6),
		'text'		=> $text->getAppData($_GET['lid']),
		'app_type'	=> isset($l->id) ? $l->type : 0,
		'store'		=> User::find($_GET['id']),
		'overview'	=> $res->overView(),
		'dboy'		=> Delivery::where('status',0)->get()

		]);
	}

	public function login(Request $Request)
	{
		$res = new User;

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

	public function orderProcess()
	{
		$res 		 = Order::find($_GET['id']);
		$res->status = $_GET['status'];
		$res->save();

		if(isset($_GET['dboy']))
		{
			$res->status_by 	= 1;
			$res->d_boy 		= $_GET['dboy'];
			$res->status_time 	= date('d-M-Y').' | '.date('h:i:A');
			$res->save();
			$res->sendSms($_GET['id']);
		}

		return response()->json(['data' => $res->status]);
	}

	public function userInfo($id)
	{
		return response()->json(['data' => User::find($id)]);
	}

	public function storeOpen($type)
	{
		$res 		= User::find($_GET['user_id']);
		$res->open 	= $type;
		$res->save();

		return response()->json(['data' => true]);
	}

	public function updateInfo(Request $Request)
	{
		$res 				= User::find($Request->get('id'));

		if($Request->get('password'))
		{
			$res->password      = bcrypt($Request->get('password'));
        	$res->shw_password  = $Request->get('password');
		}

		$res->min_cart_value 		 = $Request->get('min_cart_value');
		$res->delivery_charges_value = $Request->get('delivery_charges_value');
		$res->save();

		return response()->json(['data' => true]);
	}

	public function updateLocation(Request $Request)
	{
		if($Request->get('user_id') > 0)
		{
			$add 			= Delivery::find($Request->get('user_id'));
			$add->lat 		= $Request->get('lat');
			$add->lng 		= $Request->get('lng');
			$add->save();
		}

		return response()->json(['data' => true]);
	}

	public function getItem()
	{
		$res = new User;

		return response()->json(['data' => $res->menuItem($_GET['id'])]);
	}

	public function changeStatus()
	{
		$res 		 = Item::find($_GET['id']);
		$res->status = $_GET['status'];
		$res->save();

		return response()->json(['data' => true]);
	}
}
