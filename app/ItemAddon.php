<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Auth;
class ItemAddon extends Authenticatable
{
    protected $table = "item_addon";

    public function addNew($data)
    {
        ItemAddon::where('item_id',$data['item_id'])->delete();

        $a = isset($data['a_id']) ? $data['a_id'] : [];

        for($i=0;$i<count($a);$i++)
        {
            $add            = new ItemAddon;
            $add->item_id   = $data['item_id'];
            $add->addon_id  = $a[$i];
            $add->save();
        }
    }

    public function getAssigned($id)
    {
        return ItemAddon::where('item_id',$id)->pluck('addon_id')->toArray();
    }
}
