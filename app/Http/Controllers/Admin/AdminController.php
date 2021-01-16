<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Admin;
use App\User;
use App\AppUser;
use App\Order;
use App\Delivery;
use DB;
use Validator;
use Redirect;
class AdminController extends Controller {

	public $folder = "admin.";

	/*
	|------------------------------------------------------------------
	|Index page for login
	|------------------------------------------------------------------
	*/
	public function index()
	{
		return View($this->folder.'index',[


		'form_url' => Asset(env('admin').'/login')


		]);
	}

	/*
	|------------------------------------------------------------------
	|Login attempt,check username & password
	|------------------------------------------------------------------
	*/
	public function login(Request $request)
	{
		$username = $request->input('username');
		$password = $request->input('password');

		if (auth()->guard('admin')->attempt(['username' => $username, 'password' => $password]))
		{
			return Redirect::to(env('admin').'/home')->with('message', 'Bienvenido Estás conectado ahora.');
		}
		else
		{
			return Redirect::to(env('admin').'/login')->with('error', 'La contraseña del nombre de usuario no coincide')->withInput();
		}
	}

	/*
	|------------------------------------------------------------------
	|Homepage, Dashboard
	|------------------------------------------------------------------
	*/
	public function home()
	{
		$admin = new Admin;
		$order = new Order;

		return View($this->folder.'dashboard.home',[

		'overview'	=> $admin->overview(),
		'admin'		=> $admin,
		'schart'	=> $admin->storeChart(),
		'orders'	=> $order->getAll('last'),
		'form_url'	=> env('admin').'/order/dispatched',
		'boys'		=> Delivery::where('status',0)->where('store_id',0)->get(),



		]);
	}

	/*
	|------------------------------------------------------------------
	|Logout
	|------------------------------------------------------------------
	*/
	public function logout()
	{
		auth()->guard('admin')->logout();

		return Redirect::to(env('admin').'/login')->with('message', 'Cerrar sesión con éxito');
	}

	/*
	|------------------------------------------------------------------
	|Account setting's page
	|------------------------------------------------------------------
	*/
	public function setting()
	{
		return View($this->folder.'dashboard.setting',[

			'data' 		=> auth()->guard('admin')->user(),
			'form_url'	=> Asset(env('admin').'/setting'),
			'admin'		=> new Admin,

			]);
	}

	/*
	|------------------------------------------------------------------
	|update account setting's
	|------------------------------------------------------------------
	*/
	public function update(Request $Request)
	{
		$admin = new Admin;

		if($admin->matchPassword($Request->get('password')))
		{
			return Redirect::back()->with('error','Opps! Tu contraseña actual no coincide.');
		}
		else
		{
			$admin->updateData($Request->all());

			return Redirect::back()->with('message','Información de cuenta actualizada correctamente.');
		}
	}

	public function admin()
	{
		return Redirect(env('admin'));
	}

	public function appUser()
	{
		return View($this->folder.'dashboard.appUser',['data' => AppUser::orderBy('id','DESC')->paginate(60)]);
	}
}
