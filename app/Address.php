<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
class Address extends Authenticatable
{
    protected $table = 'user_address';

    public function getAll($id)
    {
        return Address::where('user_id',$id)->get();
    }

    public function addNew($data)
    {
        if(isset($data['address']))
        {
            $uid            = $data['user_id'];
            $add            = new Address;
            $add->user_id   = $uid;
            $add->address   = $data['address'];
            $add->lat       = isset($data['lat']) ? $data['lat'] : 0;
            $add->lng       = isset($data['lng']) ? $data['lng'] : 0;
            $add->save();

            return ['msg' => 'done'];
        }
    }

    public function removeNew($id)
    {
        $item = Address::find($id);
        $item->delete();
        return ['msg' => 'done'];
    }
}
