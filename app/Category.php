<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Auth;
class Category extends Authenticatable
{
    protected $table = "category";
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
    |Create/Update user
    |--------------------------------
    */

    public function addNew($data,$type)
    {
        $a                  = isset($data['lid']) ? array_combine($data['lid'], $data['l_name']) : [];
        $add                = $type === 'add' ? new Category : Category::find($type);
        $add->store_id      = Auth::user()->id;
        $add->name          = isset($data['name']) ? $data['name'] : null;
        $add->status        = isset($data['status']) ? $data['status'] : null;
        $add->sort_no       = isset($data['sort_no']) ? $data['sort_no'] : 0;
        $add->s_data        = serialize($a);
        $add->save();
    }

    /*
    |--------------------------------------
    |Get all data from db
    |--------------------------------------
    */
    public function getAll()
    {
        return Category::where('store_id',Auth::user()->id)->orderBy('name', 'ASC')->orderBy('sort_no','ASC')->get();
    }

    public function getSData($data,$id,$field)
    {
        $data = unserialize($data);

        return isset($data[$id]) ? $data[$id] : null;
    }
}
