<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Item;
use App\Type;
use App\Addon;
use App\ItemAddon;
use App\Exports\ItemExport;
use DB;
use Validator;
use Redirect;
use IMS;
use Excel;
class ItemController extends Controller {

	public $folder  = "user/item.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		$res 	= new Item;
		$addon  = new Addon;

		return View($this->folder.'index',[

			'data' 	=> $res->getAll(),
			'link' 	=> env('user').'/item/',
			'addon' => $addon->getAll(),
			'assign' => new ItemAddon

			]);
	}

	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{
		$cate = new Category;
		$type = new Type;

		return View($this->folder.'add',[

			'data' 		=> new Item,
			'form_url' 	=> env('user').'/item',
			'cates' 	=> $cate->getAll(),
			'type'		=> $type->getAll()

		]);
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new Item;

		if($data->validate($Request->all(),'add'))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),'add'))->withInput();
			exit;
		}

		$data->addNew($Request->all(),"add");

		return redirect(env('user').'/item')->with('message','Nuevo registro agregado con éxito.');
	}

	/*
	|---------------------------------------
	|@Edit Page
	|---------------------------------------
	*/
	public function edit($id)
	{
		$cate = new Category;
		$type = new Type;

		return View($this->folder.'edit',[

			'data' 		=> Item::find($id),
			'form_url' 	=> env('user').'/item/'.$id,
			'cates' 	=> $cate->getAll(),
			'type'		=> $type->getAll()

		]);
	}

	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{
		$data = new Item;

		if($data->validate($Request->all(),$id))
		{
			return redirect::back()->withErrors($data->validate($Request->all(),$id))->withInput();
			exit;
		}

		$data->addNew($Request->all(),$id);

		return redirect(env('user').'/item')->with('message','Registro actualizado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		Item::where('id',$id)->delete();

		return redirect(env('user').'/item')->with('message','Registro eliminado exitosamente.');
	}

	/*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= Item::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect(env('user').'/item')->with('message','Estado actualizado correctamente.');
	}

	public function addon(Request $Request)
	{
		$data = new ItemAddon;

		$data->addNew($Request->all());

		return redirect::back()->with('message','Actualizado con éxito.');
	}

	public function export()
	{
		return Excel::download(new ItemExport, 'items.xlsx');
	}

	public function import()
	{
		return View($this->folder.'import');
	}

	public function _import(Request $Request)
	{
		$res = new Item;

		$res->import($Request->all());

		return Redirect::back()->with('message','Subido correctamente.');
	}
}
