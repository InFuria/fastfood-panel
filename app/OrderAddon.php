<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
class OrderAddon extends Authenticatable
{
    protected $table = 'order_addon';

    public function addNew($id,$cartNo)
    {
        $cid  = Cart::where('cart_no',$cartNo)->first()->id;
        $cart = CartAddon::where('cart_id',$cid)->get();

        foreach($cart as $c)
        {
            $add             = new OrderAddon;
            $add->order_id   = $id;
            $add->item_id    = $c->item_id;
            $add->addon_id   = $c->addon_id;
            $add->qty        = 1;
            $add->save();
        }

        CartAddon::where('cart_id',$cid)->delete();
    }
}
