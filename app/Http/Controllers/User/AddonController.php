<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Addon;
use DB;
use Validator;
use Redirect;
use IMS;
class AddonController extends Controller {

	public $folder  = "user/addon.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res = new Addon;

		return View($this->folder.'index',['data' => $res->getAll(),'link' => env('user').'/addon/','c' => $this->currency()]);
	}

	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{
		return View($this->folder.'add',['data' => new Addon,'form_url' => env('user').'/addon']);
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new Addon;

		$data->addNew($Request->all(),"add");

		return redirect(env('user').'/addon')->with('message','Nuevo registro agregado con éxito.');
	}

	/*
	|---------------------------------------
	|@Edit Page
	|---------------------------------------
	*/
	public function edit($id)
	{
		return View($this->folder.'edit',['data' => Addon::find($id),'form_url' => env('user').'/addon/'.$id]);
	}

	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{
		$data = new Addon;

		$data->addNew($Request->all(),$id);

		return redirect(env('user').'/addon')->with('message','Registro actualizado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		Addon::where('id',$id)->delete();

		return redirect(env('user').'/addon')->with('message','Registro eliminado exitosamente.');
	}
}
