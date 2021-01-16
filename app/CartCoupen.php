<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;

class CartCoupen extends Authenticatable
{
    protected $table = "cart_coupen";

    public function addNew($id,$cartNo)
    {
        $cart   = new Cart;
        $items  = $cart->getCart($cartNo);
        //$total  = $cart->getTotal($cartNo);
        $total  = 0;
        $offer  = Offer::where("id", $id)->where("status", 0)->first();
        $discount    = 0;

        foreach ($items['data'] as $key => $item){

            $sub_total = $item['price'] * $item['qty'];

            $assigned_stores = OfferStore::where('offer_id', $id)->where('store_id', $item['store_id'])->first();

            if (isset($assigned_stores)){

                if ($offer->type == 0)
                    $val = $sub_total * $offer->value / 100;

                if ($offer->type == 1)
                    $val = $offer->value;

                $discount += $val;
            }

            $total += $sub_total;
        }

        if($offer->min_cart_value > 0 && $total <= $offer->min_cart_value)
            $discount = 0;


        if($discount < 0)
            return ['msg' => 'Este cupón requiere un valor mínimo de carrito de '.$offer->min_cart_value];


        CartCoupen::where('cart_no',$cartNo)->delete();

        $add = new CartCoupen;
        $add->cart_no = $cartNo;
        $add->code    = $offer->code;
        $add->amount  = $discount;
        $add->save();


        return ['msg' => 'done','data' => $cart->getCart($cartNo)];
    }


    public function getVal($total,$offer)
    {
        //0 = %
        if($offer->type == 0)
        {
            $val = $total * $offer->value / 100;
        }
        else
        {
            $val = $offer->value;
        }

        $return = $val;

        if($offer->upto > 0)
        {
            if($val >= $offer->upto)
            {
                $return = $offer->upto;
            }
        }

        return $return;
    }
}
