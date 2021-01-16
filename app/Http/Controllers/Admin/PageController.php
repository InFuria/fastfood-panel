<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Banner;
use App\City;
use App\User;
use App\Page;
use DB;
use Validator;
use Redirect;
use IMS;
class PageController extends Controller {

	public $folder  = "admin/page.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function show()
	{
		$count = Page::find(1);

		if(!isset($count->id))
		{
			$add 			= new Page;
			$add->about_us  = "About Us";
			$add->save();
		}

		$res = new Page;

		if(isset($_GET['remove']))
		{
			$update = Page::find(1);

			if($_GET['remove'] == "about_img")
			{
				$update->about_img = null;
			}

			if($_GET['remove'] == "how_img")
			{
				$update->how_img = null;
			}

			$update->save();

			return redirect::back()->with('message','Actualizado con éxito.');

			exit;
		}

		return View($this->folder.'index',['data' => Page::find(1),'form_url' => env('admin').'/page']);
	}

	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{
		$data = new Page;

		$data->addNew($Request->all(),"add");

		return redirect::back()->with('message','Actualizado con éxito.');
	}
}
