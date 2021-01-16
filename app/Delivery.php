<?php

namespace App;

use Mail;
use Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Delivery extends Authenticatable
{
    protected $table = "delivery_boys";

    /*
    |----------------------------------------------------------------
    |   Validation Rules and Validate data for add & Update Records
    |----------------------------------------------------------------
    */

    public function rules($type)
    {
        if($type === 'add')
        {
            return [

            'phone' => 'required|unique:delivery_boys',
            'email' => 'required|unique:delivery_boys',

            ];
        }
        else
        {
            return [

            'phone'     => 'required|unique:delivery_boys,phone,'.$type,
            'email'     => 'required|unique:delivery_boys,email,'.$type,

            ];
        }
    }

    public function messages()
    {
        return [

            'phone.required' => 'El Teléfono es requerido.',
            'phone.unique' => 'El Teléfono que ingreso ya fue utilizado.',
            'email.required' => 'El Email es requerido.',
            'email.unique' => 'El Email que ingreso ya fue utilizado.'

        ];
    }

    public function validate($data,$type)
    {

        $validator = Validator::make($data,$this->rules($type),$this->messages());
        if($validator->fails())
        {
            return $validator;
        }
    }

    /*
    |--------------------------------
    |Create/Update city
    |--------------------------------
    */

    public function addNew($data,$type)
    {
        $add                    = $type === 'add' ? new Delivery : Delivery::find($type);
        $add->store_id          = isset($data['user_id']) ? $data['user_id'] : 0;
        $add->name              = isset($data['name']) ? $data['name'] : null;
        $add->phone             = isset($data['phone']) ? $data['phone'] : null;
        $add->status            = isset($data['status']) ? $data['status'] : 0;
        $add->email             = isset($data['email']) ? $data['email'] : null;
        $add->cd_id             = isset($data['cd_id']) ? $data['cd_id'] : null;

        if(isset($data['password']))
        {
            $add->password      = bcrypt($data['password']);
            $add->shw_password  = $data['password'];
        }

        $add->save();
    }



    /*
    |--------------------------------------
    |Get all data from db
    |--------------------------------------
    */
    public function getAll($store = 0)
    {
        return Delivery::where(function($query) use($store) {

            if($store > 0)
            {
                $query->where('store_id',$store);
            }

        })->leftjoin('users','delivery_boys.store_id','=','users.id')
          ->select('users.name as store','delivery_boys.*')
          ->orderBy('delivery_boys.id','DESC')->get();
    }

    public function getAllByCity()
    {
        $city = $_GET["city"];


        return Delivery::where(function($query) use($city) {

            $query->where('enabled', 1);

            $query->where('cd_id',$city);

        })->leftjoin('users','delivery_boys.store_id','=','users.id')
        ->select('users.name as store','delivery_boys.*')
        ->orderBy('delivery_boys.id','DESC')->get();
    }

   public function login($data)
   {
     $chk = Delivery::where('status',0)->where('phone',$data['phone'])->where('shw_password',$data['password'])->first();

     if(isset($chk->id))
     {
        $chk->enabled = 1;
        $chk->save();
        return ['msg' => 'done','user_id' => $chk->id];
     }
     else
     {
        return ['msg' => 'Opps! Datos de acceso incorrectos'];
     }
   }

    public function logout() {
        $res = Delivery::find($_GET['id']);
        $res->enabled = 0;
        $res->save();

        return ['msg' => 'done','user_id' => $res->id];
    }

   public function forgot($data)
    {
        $res = Delivery::where('email',$data['email'])->first();

        if(isset($res->id))
        {
            $otp = rand(1111,9999);

            $res->otp = $otp;
            $res->save();

           Mail::send('email',['res' => $res], function($message) use($res)
           {
              $message->to($res->email)->subject("Restablecer contraseña");

            });

            $return = ['msg' => 'done','user_id' => $res->id];
        }
        else
        {
            $return = ['msg' => 'error','error' => '¡Lo siento! Este correo electrónico no está registrado con nosotros.'];
        }

        return $return;
    }

    public function verify($data)
    {
        $res = Delivery::where('id',$data['user_id'])->where('otp',$data['otp'])->first();

        if(isset($res->id))
        {
            $return = ['msg' => 'done','user_id' => $res->id];
        }
        else
        {
            $return = ['msg' => 'error','error' => '¡Lo siento! OTP no coincide.'];
        }

        return $return;
    }

    public function updatePassword($data)
    {
        $res = Delivery::where('id',$data['user_id'])->first();

        if(isset($res->id))
        {
            $res->password      = bcrypt($data['password']);
            $res->shw_password  = $data['password'];
            $res->save();

            $return = ['msg' => 'done','user_id' => $res->id];
        }
        else
        {
            $return = ['msg' => 'error','error' => '¡Lo siento! Algo salió mal.'];
        }

        return $return;
    }
}
