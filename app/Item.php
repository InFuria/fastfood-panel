<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Auth;
use Excel;
class Item extends Authenticatable
{
    protected $table = "item";
    protected $guarded = [];
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
        $a                      = isset($data['lid']) ? array_combine($data['lid'], $data['l_name']) : [];
        $b                      = isset($data['lid']) ? array_combine($data['lid'], $data['l_desc']) : [];
        $add                    = $type === 'add' ? new Item : Item::find($type);
        $add->store_id          = Auth::user()->id;
        $add->category_id       = isset($data['cate_id']) ? $data['cate_id'] : null;
        $add->name              = isset($data['name']) ? $data['name'] : null;
        $add->description       = isset($data['description']) ? $data['description'] : null;
        $add->small_price       = isset($data['small_price']) ? $data['small_price'] : null;
        $add->medium_price      = isset($data['medium_price']) ? $data['medium_price'] : null;
        $add->large_price       = isset($data['large_price']) ? $data['large_price'] : null;

        $add->small_price_real       = isset($data['small_price_real']) ? $data['small_price_real'] : null;
        $add->medium_price_real      = isset($data['medium_price_real']) ? $data['medium_price_real'] : null;
        $add->large_price_real       = isset($data['large_price_real']) ? $data['large_price_real'] : null;

        $add->status            = isset($data['status']) ? $data['status'] : null;
        $add->sort_no           = isset($data['sort_no']) ? $data['sort_no'] : 0;
        $add->nonveg            = isset($data['nonveg']) ? $data['nonveg'] : 0;
        $add->s_data            = serialize([$a,$b]);


        if(isset($data['img']))
        {
            $filename   = time().rand(111,699).'.' .$data['img']->getClientOriginalExtension();
            $data['img']->move("upload/item/", $filename);
            $add->img = $filename;
        }

        $add->save();
    }

    /*
    |--------------------------------------
    |Get all data from db
    |--------------------------------------
    */
    public function getAll()
    {
        return Item::join('category','item.category_id','=','category.id')
                   ->select('item.*','category.name as cate')
                   ->where('item.store_id',Auth::user()->id)
                   ->orderBy('item.id','DESC')->get();
    }

    public function getSData($data,$id,$field)
    {
        $data = unserialize($data);

        return isset($data[$field][$id]) ? $data[$field][$id] : null;
    }

    public function import($data)
    {
        $array = Excel::toArray(new Item, $data['file']);

        Item::where('store_id',Auth::user()->id)->delete();

        $i = 0;
        foreach($array[0] as $a)
        {
            $i++;

            if($i > 1)
            {
                $add                    = new Item;
                $add->store_id          = Auth::user()->id;
                $add->category_id       = $a[0];
                $add->name              = $a[1];
                $add->description       = $a[2];
                $add->small_price       = $a[3];
                $add->medium_price      = $a[4];
                $add->large_price       = $a[5];
                $add->sort_no           = $a[6];
                $add->save();
            }
        }
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'store_id');
    }
}
