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
class PushController extends Controller {

	public $folder  = "admin/push.";

	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{
		return View($this->folder.'index',['form_url' => Asset(env('admin').'/push')]);
	}

	public function send(Request $Request)
	{
		$this->sendPush($Request->get('title'),$Request->get('desc'));

		return Redirect::back()->with('message','Notificaciones enviadas con éxito.');
	}
}
