<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Banner;
use App\City;
use App\User;
use App\BannerStore;
use DB;
use Validator;
use Redirect;
use IMS;
class BannerController extends Controller {

	public $folder  = "admin/banner.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res = new Banner;

		return View($this->folder.'index',['data' => $res->getAll(),'link' => env('admin').'/banner/']);
	}

	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{
		$city = new City;
		$user = new User;

		return View($this->folder.'add',[

			'data' 		=> new Banner,
			'form_url' 	=> env('admin').'/banner',
			'citys' 	=> $city->getAll(0),
			'users'		=> $user->getAll(0)

			]);
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new Banner;

		$data->addNew($Request->all(),"add");

		return redirect(env('admin').'/banner')->with('message','Nuevo registro agregado con éxito.');
	}

	/*
	|---------------------------------------
	|@Edit Page
	|---------------------------------------
	*/
	public function edit($id)
	{
		$city = new City;
		$user = new User;

		return View($this->folder.'edit',[

			'data' 		=> Banner::find($id),
			'form_url' 	=> env('admin').'/banner/'.$id,
			'citys' 	=> $city->getAll(0),
			'users'		=> $user->getAll(0),
			'array'		=> BannerStore::where('banner_id',$id)->pluck('store_id')->toArray()

			]);
	}

	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{
		$data = new Banner;

		$data->addNew($Request->all(),$id);

		return redirect(env('admin').'/banner')->with('message','Registro actualizado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		$res = Banner::find($id);

		BannerStore::where('banner_id',$id)->delete();

		unlink("upload/banner/".$res->img);

		$res->delete();

		return redirect(env('admin').'/banner')->with('message','Registro eliminado exitosamente.');
	}

	/*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= Banner::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect(env('admin').'/banner')->with('message','Estado actualizado correctamente.');
	}
}
