<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Admin;
use DB;
use Validator;
use Redirect;
use IMS;
class AdminUserController extends Controller {

	public $folder  = "admin/adminUser.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res = new Admin;

		return View($this->folder.'index',['data' => $res->getAll(),'link' => env('admin').'/adminUser/']);
	}

	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{
		return View($this->folder.'add',[

		'data' => new Admin,
		'form_url' => env('admin').'/adminUser',
		'array'		=> []

		]);
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new Admin;

		if($data->validate($Request->all(),'add'))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),'add'))->withInput();
			exit;
		}

		$data->addNew($Request->all(),"add");

		return redirect(env('admin').'/adminUser')->with('message','Nuevo registro agregado con éxito.');
	}

	/*
	|---------------------------------------
	|@Edit Page
	|---------------------------------------
	*/
	public function edit($id)
	{
		$admin = Admin::find($id);

		return View($this->folder.'edit',[

		'data' 		=> $admin,
		'form_url'  => env('admin').'/adminUser/'.$id,
		'array'		=> explode(",", $admin->perm)

		]);
	}

	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{
		$data = new Admin;

		if($data->validate($Request->all(),$id))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),$id))->withInput();
			exit;
		}

		$data->addNew($Request->all(),$id);

		return redirect(env('admin').'/adminUser')->with('message','Registro actualizado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		Admin::where('id',$id)->delete();

		return redirect(env('admin').'/adminUser')->with('message','Registro eliminado exitosamente.');
	}

	/*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= Admin::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect(env('admin').'/adminUser')->with('message','Estado actualizado correctamente.');
	}
}
