<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Validator;
class Admin extends Authenticatable
{
    protected $table = "admin";

    public function rules($type)
    {
        if($type === 'add')
        {
            return [

            'username' => 'required|unique:admin',

            ];
        }
        else
        {
            return [

            'username'     => 'required|unique:admin,username,'.$type,

            ];
        }
    }

    public function validate($data,$type)
    {

        $validator = Validator::make($data,$this->rules($type));
        if($validator->fails())
        {
            return $validator;
        }
    }
    /*
	|------------------------------------------------------------------
	|Checking for current admin password
	|@password = admin password
	|------------------------------------------------------------------
	*/
	public function matchPassword($password)
	{
	  if(auth()->guard('admin')->attempt(['username' => Auth()->guard('admin')->user()->username, 'password' => $password]))
	  {
		  return false;
	  }
	  else
	  {
		  return true;
	  }
	}

	/*
	|---------------------------------
	|Update Account Data
	|---------------------------------
	*/
	public function updateData($data)
	{
        $a                  	   = isset($data['lid']) ? array_combine($data['lid'], $data['l_store_type']) : [];
		$update 					= Admin::find(Auth::guard('admin')->user()->id);
		$update->name 				= isset($data['name']) ? $data['name'] : null;
		$update->email 				= isset($data['email']) ? $data['email'] : null;
		$update->username 			= isset($data['username']) ? $data['username'] : null;
		$update->fb 				= isset($data['fb']) ? $data['fb'] : null;
		$update->insta 				= isset($data['insta']) ? $data['insta'] : null;
		$update->twitter 			= isset($data['twitter']) ? $data['twitter'] : null;
		$update->youtube 			= isset($data['youtube']) ? $data['youtube'] : null;
		$update->currency 			= isset($data['currency']) ? $data['currency'] : null;
		$update->store_type 		= isset($data['store_type']) ? $data['store_type'] : null;
		$update->paypal_client_id 	= isset($data['paypal_client_id']) ? $data['paypal_client_id'] : null;
		$update->stripe_client_id 	= isset($data['stripe_client_id']) ? $data['stripe_client_id'] : null;
        $update->stripe_api_id 		= isset($data['stripe_api_id']) ? $data['stripe_api_id'] : null;
        $update->onesignal_api 		= isset($data['onesignal_api']) ? $data['onesignal_api'] : null;
        $update->onesignal_token 	= isset($data['onesignal_token']) ? $data['onesignal_token'] : null;
        $update->firebase_api 		= isset($data['firebase_api']) ? $data['firebase_api'] : null;
        $update->google_api 		= isset($data['google_api']) ? $data['google_api'] : null;
		$update->s_data 			= serialize($a);

		if(isset($data['new_password']))
		{
			$update->password = bcrypt($data['new_password']);
		}

		if(isset($data['logo']))
        {
            $filename   = time().rand(111,699).'.' .$data['logo']->getClientOriginalExtension();
            $data['logo']->move("upload/admin/", $filename);
            $update->logo = $filename;
        }

		$update->save();

	}

	public function getAll()
	{
		return Admin::where('id','!=',1)->get();
	}

	public function addNew($data,$type)
    {
        $add                    = $type === 'add' ? new Admin : Admin::find($type);
       	$add->username 			= isset($data['username']) ? $data['username'] : null;
       	$add->name 				= isset($data['name']) ? $data['name'] : null;
       	$add->perm 				= isset($data['perm']) ? implode(",", $data['perm']) : null;

        if(isset($data['password']))
        {
            $add->password      = bcrypt($data['password']);
            $add->shw_password  = $data['password'];
        }

        $add->save();
    }

	public function overview()
	{
		return [

		'store' 	=> User::where('status',0)->count(),
		'order'		=> Order::count(),
		'complete'  => Order::where('status',6)->count(),
		'month'  	=> Order::whereDate('created_at','LIKE',date('Y-m').'%')->count(),
		'user'  	=> AppUser::count(),

		];
	}

	public function getMonthName($type)
	{
		 $month = date('m') - $type;

		 return $type == 0 ? date('F') : date('F',strtotime(date('Y').'-'.$month));
	}

	public function chart($type,$sid = 0)
	{
		$month      = date('Y-m',strtotime(date('Y-m').' - '.$type.' month'));

		$order   = Order::where(function($query) use($sid){

			if($sid > 0)
			{
				$query->where('store_id',Auth::user()->id);
			}

		})->where('status',4)->whereDate('created_at','LIKE',$month.'%')->count();


		$cancel  = Order::where(function($query) use($sid){

			if($sid > 0)
			{
				$query->where('store_id',Auth::user()->id);
			}

		})->where('status',2)->whereDate('created_at','LIKE',$month.'%')->count();

		return ['order' => $order,'cancel' => $cancel];
	}

	public function storeChart()
	{
		$storeID = Order::where('status',4)->pluck('store_id')->toArray();


		$data = [];

		foreach(array_unique($storeID) as $sid)
		{
			$user = User::find($sid);

			if(isset($user->id))
			{
				$data[] = ['name' => $user->name,'order' => Order::where('store_id',$sid)->where('status',4)->count()];
			}
		}

		 arsort($data);

		 return $data;
	}

	public function getStoreData($data,$index,$type)
	{

		if(isset($data[$index]))
		{
			return $data[$index][$type];
		}
		else
		{
			return null;
		}
	}

	public function getSData($data,$id,$field)
    {
        $data = unserialize($data);

        return isset($data[$id]) ? $data[$id] : null;
    }

    public function hasPerm($perm)
	{
		$array = explode(",", Auth::guard('admin')->user()->perm);

		if(in_array($perm,$array) || in_array("All",$array))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}
