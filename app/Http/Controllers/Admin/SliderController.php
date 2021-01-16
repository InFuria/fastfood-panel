<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Slider;
use DB;
use Validator;
use Redirect;
use IMS;
class SliderController extends Controller {

	public $folder  = "admin/slider.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res = new Slider;

		return View($this->folder.'index',['data' => $res->getAll(),'link' => env('admin').'/slider/']);
	}

	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{
		return View($this->folder.'add',['data' => new Slider,'form_url' => env('admin').'/slider']);
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new Slider;

		$data->addNew($Request->all(),"add");

		return redirect(env('admin').'/slider')->with('message','Nuevo registro agregado con éxito.');
	}

	/*
	|---------------------------------------
	|@Edit Page
	|---------------------------------------
	*/
	public function edit($id)
	{
		return View($this->folder.'edit',['data' => Slider::find($id),'form_url' => env('admin').'/slider/'.$id]);
	}

	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{
		$data = new Slider;

		$data->addNew($Request->all(),$id);

		return redirect(env('admin').'/slider')->with('message','Registro actualizado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		$res = Slider::find($id);

		unlink("upload/slider/".$res->img);

		$res->delete();

		return redirect(env('admin').'/slider')->with('message','Registro eliminado exitosamente.');
	}
}
