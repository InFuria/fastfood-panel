<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\City;
use DB;
use Validator;
use Redirect;
use IMS;
class CityController extends Controller {

	public $folder  = "admin/city.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res = new City;

		return View($this->folder.'index',['data' => $res->getAll(),'link' => env('admin').'/city/']);
	}

	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{
		return View($this->folder.'add',['data' => new City,'form_url' => env('admin').'/city',]);
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new City;

		if($data->validate($Request->all(),'add'))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),'add'))->withInput();
			exit;
		}

		$data->addNew($Request->all(),"add");

		return redirect(env('admin').'/city')->with('message','Nuevo registro agregado con éxito.');
	}

	/*
	|---------------------------------------
	|@Edit Page
	|---------------------------------------
	*/
	public function edit($id)
	{
		return View($this->folder.'edit',['data' => City::find($id),'form_url' => env('admin').'/city/'.$id]);
	}

	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{
		$data = new City;

		if($data->validate($Request->all(),$id))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),$id))->withInput();
			exit;
		}

		$data->addNew($Request->all(),$id);

		return redirect(env('admin').'/city')->with('message','Registro actualizado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		City::where('id',$id)->delete();

		return redirect(env('admin').'/city')->with('message','Registro eliminado exitosamente.');
	}

	/*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= City::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect(env('admin').'/city')->with('message','Estado actualizado con éxito.');
	}
}
