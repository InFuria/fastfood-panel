<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
class Cart extends Authenticatable
{
    protected $table = 'cart';

    public function addNew($data)
    {
        $store = Item::find($data['id']);
        $this->checkStore($data,$store->store_id);

        $check = Cart::where('cart_no',$data['cart_no'])->where('item_id',$data['id'])
                     ->where('qty_type',$data['qtype'])->first();

        $add                = !isset($check->id) ? new Cart : Cart::find($check->id);
        $add->cart_no       = isset($data['cart_no']) ? $data['cart_no'] : 0;
        $add->store_id      = $store->store_id;
        $add->item_id       = isset($data['id']) ? $data['id'] : 0;
        $add->price         = isset($data['price']) ? $data['price'] : 0;
        $add->qty_type      = isset($data['qtype']) ? $data['qtype'] : 0;

        if ($store->small_price == $add->price) {
            $add->price_real      = isset($store->small_price_real) ? $store->small_price_real : 0;
        } else if ($store->medium_price == $add->price) {
            $add->price_real      = isset($store->medium_price_real) ? $store->medium_price_real : 0;
        } else if ($store->large_price == $add->price) {
            $add->price_real      = isset($store->large_price_real) ? $store->large_price_real : 0;
        }

        if($data['type'] == 0)
        {
            $add->qty = $add->qty + 1;
        }
        else
        {
            $add->qty = $add->qty - 1;
        }

        $add->save();

        Cart::where('qty',0)->delete();

        $addon = new CartAddon;
        $addon->addNew($data,$add->id);

        return [

        'count' => Cart::where('cart_no',$data['cart_no'])->count(),
        'cart'  => $this->getItemQty($data['cart_no'])

        ];
    }

    public function updateCart($id,$type)
    {
        if(isset($_GET['cart_no']))
        {
            $res            = Cart::where('cart_no',$_GET['cart_no'])->where('item_id',$id)->first();
            $qty            = $res->qty;
            $res->qty       = $qty - 1;
            $res->save();

            if($res->qty == 0)
            {
                $res->delete();
            }

            return $this->getItemQty($_GET['cart_no']);
        }
        else
        {
            $res            = Cart::find($id);
            $qty            = $res->qty;
            $res->qty       = $type == 0 ? $qty - 1 : $qty + 1;
            $res->save();

            if($res->qty == 0)
            {
                $res->delete();
            }

            CartCoupen::where('cart_no',$res->cart_no)->delete();

            return $this->getCart($res->cart_no);
        }
    }

    public function getItemQty($cart_no)
    {
        $id = Cart::select('item_id')->distinct()->where('cart_no',$cart_no)->get();

        $data = [];

        foreach($id as $i)
        {
            $qty = Cart::where('cart_no',$cart_no)->where('item_id',$i->item_id)->sum('qty');

            $data[] = ['item_id' => $i->item_id,'qty' => $qty];
        }

        return $data;
    }

    public function checkStore($data,$sid)
    {
        $count = Cart::where('cart_no',$data['cart_no'])->orderBy('id','DESC')->first();

        if(isset($count->id))
        {

            Cart::where('cart_no',$data['cart_no'])->where('store_id','!=',$sid)->delete();
        }
    }

    public function getCart($cartNo)
    {
        $res = Cart::join('item','cart.item_id','=','item.id')
                   ->select('item.name as item','item.img','cart.*')
                   ->where('cart.cart_no',$cartNo)
                   ->get();

        $data       = [];

        $u = new User;
        $lid = isset($_GET['lid']) ? $_GET['lid'] : 0; // Validacion de id de lenguaje

        foreach($res as $row)
        {
            if($row->qty_type == 0)
            {
                $qtyName = 'Pequeño';
            }
            elseif($row->qty_type == 1)
            {
                $qtyName = 'Mediano';
            }
            else
            {
                $qtyName = 'Completo';
            }

            $data[] = [

            'id'       => $row->id,
            'store_id' => $row->store_id,
            'item_id'  => $row->item_id,
            'price'    => $row->price,
            'qtype'    => $row->qty_type,
            'qty'      => $row->qty,
            'item'     => $u->getLangItem($row->item_id, $lid)['name'],
            'img'      => $row->img ? Asset('upload/item/'.$row->img) : null,
            'qtyName'  => $qtyName,
            'addon'    => $this->cartAddon($row->id,$row->item_id)

            ];
        }

       $item_total = $this->getTotal($cartNo);
       $d_charges  = $this->d_charges($item_total,$cartNo);
       $discount   = CartCoupen::where('cart_no',$cartNo)->sum('amount');
       $total      = ($item_total - $discount) + $d_charges;
       $sid        = Cart::where('cart_no',$cartNo)->select('store_id')->distinct()->first();
       return [

       'data'           => $data,
       'item_total'     => $item_total,
       'd_charges'      => $d_charges,
       'total'          => $total,
       'discount'       => $discount,
       'store'          => isset($sid->store_id) ? $u->getLang($sid->store_id, $lid)['name'] : [],
       'currency'       => Admin::find(1)->currency

       ];
    }

    public function cartAddon($id,$item_id)
    {
        return CartAddon::join('addon','cart_addon.addon_id','=','addon.id')
                        ->select('addon.*','cart_addon.qty')
                        ->where('cart_addon.cart_id',$id)
                        ->where('cart_addon.item_id',$item_id)
                        ->get();
    }

    public function d_charges($total,$cartNo)
    {
        $cart = Cart::where('cart_no',$cartNo)->first();
        $val = 0;
        if(isset($cart->id))
        {
            $user = User::find($cart->store_id);

            if(isset($user) && $user->delivery_charges_value > 0)
            {
                if($user->min_cart_value > 0)
                {
                    if($total < $user->min_cart_value)
                    {
                        $val = $user->delivery_charges_value;
                    }
                }
                else
                {
                    $val = $user->delivery_charges_value;
                }
            }
            else
            {
                $val = 0;
            }
        }

        return $val;
    }

    public function getTotal($cartNo)
    {
        $total = [];
        $res = Cart::where('cart_no',$cartNo)->get();
        foreach($res as $row)
        {
            $total[] = $row->price * $row->qty;

            foreach($this->cartAddon($row->id,$row->item_id) as $addon)
            {
                $total[] = $addon->price * $addon->qty;
            }
        }

        return array_sum($total);
    }
}
