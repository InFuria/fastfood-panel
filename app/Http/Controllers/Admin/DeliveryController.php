<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Delivery;
use App\User;
use App\City;
use DB;
use Validator;
use Redirect;
use IMS;
class deliveryController extends Controller {

    public $folder  = "admin/delivery.";

    public function all()
	{
		$res = new Delivery;

        return response()->json(['data' => $res->getAllByCity()]);
	}

	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res = new Delivery;

		return View($this->folder.'index',['data' => $res->getAll(),'link' => env('admin').'/delivery/']);
	}

	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{
        $u = new User;
        $city = City::all();

        return View(
                    $this->folder.'add',
                    [
                        'data' => new Delivery,
                        'form_url' => env('admin').'/delivery',
                        'users' => $u->getAll(),
                        'city' => $city
                    ]
                );
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new Delivery;

		if($data->validate($Request->all(),'add'))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),'add'))->withInput();
			exit;
        }

		$data->addNew($Request->all(),"add");

		return redirect(env('admin').'/delivery')->with('message','Nuevo registro agregado con éxito.');
	}

	/*
	|---------------------------------------
	|@Edit Page
	|---------------------------------------
	*/
	public function edit($id)
	{
        $u = new User;
        $city = City::all();

		return View($this->folder.'edit',['data' => Delivery::find($id), 'city' => $city, 'form_url' => env('admin').'/delivery/'.$id,'users' => $u->getAll()]);
	}

	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{
		$data = new Delivery;

		if($data->validate($Request->all(),$id))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),$id))->withInput();
			exit;
		}

		$data->addNew($Request->all(),$id);

		return redirect(env('admin').'/delivery')->with('message','Registro actualizado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		Delivery::where('id',$id)->delete();

		return redirect(env('admin').'/delivery')->with('message','Registro eliminado exitosamente.');
	}

	/*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= Delivery::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect(env('admin').'/delivery')->with('message','Estado actualizado correctamente.');
	}
}
