<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\StoreCategory;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\City;
use App\UserImage;
use App\Admin;
use App\Item;
use DB;
use Validator;
use Redirect;
use IMS;
class UserController extends Controller {

	public $folder  = "admin/user.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res = new User;

		return View($this->folder.'index',['data' => $res->getAll(),'link' => env('admin').'/user/']);
	}

	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{
        $admin = Admin::find(1);

        $city = new City;

		return View($this->folder.'add',[

			'data' 		=> new User,
			'form_url'  => env('admin').'/user',
			'citys'     => $city->getAll(0),
            'types'		=> StoreCategory::all(),
            'google_key'		=> $admin->google_api,
            'days'      => ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],
            'categories' => StoreCategory::all(),

			]);
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new User;

		if($data->validate($Request->all(),'add'))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),'add'))->withInput();
			exit;
		}

		$data->addNew($Request->all(),"add");

		$this->sendPush('New Food Store',$Request->get('name'));


		return redirect(env('admin').'/user')->with('message','Nuevo registro agregado con éxito.');
	}

	/*
	|---------------------------------------
	|@Edit Page
	|---------------------------------------
	*/
	public function edit($id)
	{
        $admin = Admin::find(1);
		$city = new City;
        $user = User::find($id);
        $available_days = str_split($user->available_days);

        return View($this->folder.'edit',[

            'data' 		=> $user,
            'form_url'  => env('admin').'/user/'.$id,
            'citys'     => $city->getAll(0),
            'images' 	=> UserImage::where('user_id',$id)->get(),
            'types'		=> StoreCategory::all(),
            'admin'		=> true,
            'google_key'		=> $admin->google_api,
            'available_days' => $available_days,
            'days'      => ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'],

        ]);
	}

	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{
		$data = new User;

		if($data->validate($Request->all(),$id))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),$id))->withInput();
			exit;
		}

		$data->addNew($Request->all(),$id);

		return redirect(env('admin').'/user')->with('message','Registro actualizado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		User::where('id',$id)->delete();

		return redirect(env('admin').'/user')->with('message','Registro eliminado exitosamente.');
	}

	/*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= User::find($id);

		if(isset($_GET['type']) && $_GET['type'] == "trend")
		{
			$res->trending 	= $res->trending == 0 ? 1 : 0;
		}
		elseif(isset($_GET['type']) && $_GET['type'] == "open")
		{
			$res->open 	= $res->open == 0 ? 1 : 0;
		}

		$res->save();

		return redirect(env('admin').'/user')->with('message','Estado actualizado correctamente.');
	}

	public function imageRemove($id)
	{
		UserImage::where('id',$id)->delete();

		return redirect::back()->with('message','Borrado exitosamente.');
	}

	public function loginWithID($id)
	{
		if(Auth::loginUsingId($id))
		{
		   return Redirect::to('home')->with('message', 'Bienvenidos ! Estás conectado ahora.');
		}
		else
		{
			return Redirect::to('login')->with('error', 'Algo salió mal.');
		}

	}


	//Clone a registry
	public function clone(Request $request)
    {
       $itemsToCloneArray = collect();
        $user = User::find($request->id);
        $user->name = $user->name . " - copia";

        $newUserArray = $user->toArray();
        $newUserArray = collect($newUserArray)->except('id')->toArray();


        $newUser = new User($newUserArray);
        $newUser->save();

        // Solucionando el problema de los items que no se clonan
        $itemsToClone = Item::where('store_id', $user->id)->get();

       $itemsToClone->each(function ($value) use ($newUser) {
            $newValue = collect($value->toArray());
            $newValue->forget('id');
            $newValue['store_id'] = $newUser->id;

            Item::create($newValue->toArray());

            return $newValue;
        });

        return redirect('/admin/user');
    }
}
