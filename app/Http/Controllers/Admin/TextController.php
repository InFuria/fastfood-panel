<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Banner;
use App\City;
use App\User;
use App\Text;
use App\Language;
use DB;
use Validator;
use Redirect;
use IMS;
class TextController extends Controller {

	public $folder  = "admin/text.";

	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function show()
	{
		$lang = new Language;

		return View($this->folder.'index',[

			'form_url'  => env('admin').'/text',
			'data' 		=> new Text,
			'langs' 	=> $lang->getWithEng()

			]);
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new Text;

		$data->addNew($Request->all());

		return redirect::back()->with('message','Actualizado con éxito.');
	}
}
