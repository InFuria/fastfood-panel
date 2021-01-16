<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Offer;
use App\User;
use App\OfferStore;
use DB;
use Validator;
use Redirect;
use IMS;
class OfferController extends Controller {

	public $folder  = "admin/offer.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res = new Offer;
		$user = new User;

		return View($this->folder.'index',[

			'data' 		=> $res->getAll(),
			'link' 		=> env('admin').'/offer/',
			'form_url'	=> env('admin').'/offer/assign',
			'users'		=> $user->getAll(0),
			'assign'	=> new OfferStore

			]);
	}

	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{
		$u = new User;

		return View($this->folder.'add',[

			'data' 		=> new Offer,
			'form_url' 	=> env('admin').'/offer',
			'users' 	=> $u->getAll(),
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
		$data = new Offer;

		if($data->validate($Request->all(),'add'))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),'add'))->withInput();
			exit;
		}

		$data->addNew($Request->all(),"add");

		//$this->sendPush('Discount Offer',$Request->get('description'));


		return redirect(env('admin').'/offer')->with('message','Nuevo registro agregado con éxito.');
	}

	/*
	|---------------------------------------
	|@Edit Page
	|---------------------------------------
	*/
	public function edit($id)
	{
		$u = new User;

		return View($this->folder.'edit',[

			'data' 		=> Offer::find($id),
			'form_url' 	=> env('admin').'/offer/'.$id,
			'users' 	=> $u->getAll(),
			'array'		=> OfferStore::where('offer_id',$id)->pluck('store_id')->toArray()

			]);
	}

	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{
		$data = new Offer;

		if($data->validate($Request->all(),$id))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),$id))->withInput();
			exit;
		}

		$data->addNew($Request->all(),$id);

		return redirect(env('admin').'/offer')->with('message','Registro actualizado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		Offer::where('id',$id)->delete();

		return redirect(env('admin').'/offer')->with('message','Registro eliminado exitosamente.');
	}

	/*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= Offer::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect(env('admin').'/offer')->with('message','Estado actualizado con éxito.');
	}

	public function assign(Request $Request)
	{
		$res = new OfferStore;

		$res->addNew($Request->all());

		return redirect(env('admin').'/offer')->with('message','Actualizado con éxito.');
	}
}
