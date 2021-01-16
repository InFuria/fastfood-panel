<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;

class City extends Authenticatable
{
    protected $table = "city";

    /*
    |----------------------------------------------------------------
    |   Validation Rules and Validate data for add & Update Records
    |----------------------------------------------------------------
    */

    public function rules($type)
    {
        return [

        'name'      => 'required',

        ];
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
    |--------------------------------
    |Create/Update city
    |--------------------------------
    */

    public function addNew($data,$type)
    {
        $a                  = isset($data['lid']) ? array_combine($data['lid'], $data['l_name']) : [];
        $add                = $type === 'add' ? new City : City::find($type);
        $add->name          = isset($data['name']) ? $data['name'] : null;
        $add->status        = isset($data['status']) ? $data['status'] : null;
        $add->s_data        = serialize($a);
        $add->save();

    }
    /*
    |--------------------------------------
    |Get all data from db
    |--------------------------------------
    */
    public function getAll($type = null)
    {
        return City::where(function($query) use($type) {

            if($type)
            {
                $query->where('status',$type);
            }

        })->orderBy('id','DESC')->get();
    }

    public function getSData($data,$id,$field)
    {
        $data = unserialize($data);

        return isset($data[$id]) ? $data[$id] : null;
    }
}
