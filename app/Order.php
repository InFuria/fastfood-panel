<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Auth;
use DB;
class Order extends Authenticatable
{
   protected $table = 'orders';

   public function addNew($data)
   {
      $user                = AppUser::find($data['user_id']);

      if(isset($data['address']) && $data['address'] > 0)
      {
          $address = Address::find($data['address']);
      }
      else
      {
          $address = new Address;
      }

      $add                 = new Order;
      $add->user_id        = $data['user_id'];
      $add->status         = -1;
      $add->store_id       = $this->getStore($data['cart_no']);
      $add->name           = $user->name;
      $add->email          = $user->email;
      $add->phone          = $user->phone;
      $add->address        = $address->address;
      $add->lat            = $address->lat;
      $add->lng            = $address->lng;
      $add->address        = $address->address;
      $add->d_charges      = $this->getTotal($data['cart_no'])['d_charges'];
      $add->discount       = $this->getTotal($data['cart_no'])['discount'];
      $add->total          = $this->getTotal($data['cart_no'])['total'];
      $add->payment_method = $data['payment'];
      $add->payment_id     = isset($data['payment_id']) ? $data['payment_id'] : 0;
      $add->type           = isset($data['otype']) ? $data['otype'] : 1;
      $add->notes          = isset($data['notes']) ? $data['notes'] : null;
      $add->save();

      $store = User::find($add->store_id);

      /*

      $delivery = Delivery::where('enabled', 1)
         ->select('*', DB::raw(" IFNULL(6371 * acos(cos(radians(" . $store->lat . "))
            * cos(radians(lat))
            * cos(radians(lng) - radians(" . $store->lng . "))
            + sin(radians(" . $store->lat . "))
            * sin(radians(lat))), 100) AS distance"))
            ->orderBy('distance','ASC')->first();

      if ((isset($delivery)) && ($delivery->distance < 10)) {
        $add->d_boy 		= $delivery->id;
        $add->save();

        $msg2 = "Nuevo orden #".$add->id." toque recibido para más información";
        app('App\Http\Controllers\Controller')->sendPushD("Nuevo pedido recibido",$msg2,$add->d_boy);
      } else {

         if ($add->payment_method == 3) {
            \Conekta\Conekta::setApiVersion("2.0.0");
            \Conekta\Conekta::setLocale('es');
            \Conekta\Conekta::setApiKey(Admin::find(1)->stripe_api_id);

            $order = \Conekta\Order::find($add->payment_id);
            $order->refund([
               'reason' => 'cannot_be_fulfilled',
               'amount' => $add->total * 100
            ]);
         }

        return ['done' => 'Su orden no se puede procesar ya que no existen repartidores en su zona.'];
      }*/

      $item = new OrderItem;
      $item->addNew($add->id,$data['cart_no']);

      $addon = new OrderAddon;
      $addon->addNew($add->id,$data['cart_no']);

      $admin = Admin::find(1);

      Cart::where('cart_no',$data['cart_no'])->delete();
      CartCoupen::where('cart_no',$data['cart_no'])->delete();

      //send sms to admin
      $msg = "Nuevo pedido recibido #".$add->id." de cantidad ".$admin->currency.$add->total;

      app('App\Http\Controllers\Controller')->sendSms($admin->phone,$msg);

      //send sms to user
      $msg2 = "Estimado ".$add->name.", Su pedido se realizó con éxito. Su ID de pedido es #".$add->id."\n Cantidad total ".$admin->currency.$add->total;

      app('App\Http\Controllers\Controller')->sendSms($add->phone,$msg2);

      app('App\Http\Controllers\Controller')->sendPushS("Nuevo pedido recibido",$msg,$add->user_id);

      $return = [

      'id'     => $add->id,
      'store'  => $store->name,
      'total'  => $add->total,
      'name'   => $add->name,
      'lat'    => $add->lat,
      'lng'    => $add->lng,

      ];

      return ['done' => 'done', 'data' => ['data' => $return,'currency' => $admin->currency]];
   }

   public function getStore($cartNo)
   {
      return Cart::where('cart_no',$cartNo)->first()->store_id;
   }

   public function getTotal($cartNo)
   {
      $cart       = new Cart;
      $item_total = $cart->getTotal($cartNo);
      $d_charges  = $cart->d_charges($item_total,$cartNo);
      $discount   = CartCoupen::where('cart_no',$cartNo)->sum('amount');
      $total      = ($item_total - $discount) + $d_charges;

      return ['total' => $total,'discount' => $discount,'d_charges' => $d_charges];
   }

   public function history($id)
   {
      $data     = [];
      $currency = Admin::find(1)->currency;

      $orders = Order::where(function($query) use($id){

         if($id > 0)
         {
            $query->where('orders.user_id',$id);
         }

         if(isset($_GET['id']))
         {
            $query->where('orders.d_boy',$_GET['id']);
         }

         if(isset($_GET['status']))
         {
            if($_GET['status'] == 3)
            {
               $query->whereIn('orders.status',[0,1,3,4,5]);
            }
            else
            {
               $query->where('orders.status',6);
            }
         }

      })->join('users','orders.store_id','=','users.id')
         ->leftjoin('delivery_boys','orders.d_boy','=','delivery_boys.id')
         ->select('users.name as store','orders.*','delivery_boys.name as dboy')
         ->orderBy('id','DESC')
         ->get();

      $u = new User;

      foreach($orders as $order)
      {
         $items = [];
         $i     = new OrderItem;

         if($order->status == 0)
         {
            $status = "Repartidor pendiente";
         }
         elseif($order->status == 1)
         {
            $status = "Repartidor confirmado";
         }
         elseif($order->status == 2)
         {
            $status = "Cancelled";
         }
         elseif($order->status == 3)
         {
            $status = "Confirmado por el restaurant";
         }
         elseif($order->status == 4)
         {
            $status = "Completo restaurant";
         }
         elseif($order->status == 5)
         {
            $status = "En camino ".$order->dboy;
         }
         else
         {
            $status = "Entregado en ".$order->status_time;
         }

         $user = User::find($order->store_id);

         $countRate = Rate::where('order_id',$order->id)->where('user_id',$id)->first();

         $data[] = [

         'id'        => $order->id,
         'store'     => $u->getLang($order->store_id,$_GET['lid'])['name'],
         'lat'       => $user->lat,
         'lng'       => $user->lng,
         'date'      => date('d-M-Y',strtotime($order->created_at))." | ".date('h:i:A',strtotime($order->created_at)),
         'total'     => $order->total,
         'items'     => $i->getItem($order->id),
         'status'    => $status,
         'st'        => $order->status,
         'stime'     => $order->status_time,
         'sid'       => $order->store_id,
         'hasRating' => isset($countRate->id) ? $countRate->star : 0,
         'currency'  => $currency,
         'user'      => $order,
         'pay'       => $order->payment_method
         ];
      }

      return $data;
   }

   public function getAll($type = null,$store_id = 0)
   {
      $take  = $type ? 15 : "";

      return Order::where(function($query) use($store_id) {

         if(isset($_GET['status']))
         {
            if($_GET['status'] == 1 && !isset($_GET['type']))
            {
               $query->whereIn('orders.status',[1,3]);
            }
            else
            {
               $query->where('orders.status',$_GET['status']);
            }
         }

         if($store_id > 0)
         {
            $query->where('orders.store_id',$store_id);
         }

         if(isset($_GET['type']))
         {
            $query->where('orders.store_id',Auth::user()->id);
         }

      })->join('users','orders.store_id','=','users.id')
        ->leftjoin('delivery_boys','orders.d_boy','=','delivery_boys.id')
        ->select('users.name as store','orders.*','delivery_boys.name as dboy')
        ->orderBy('orders.id','DESC')
        ->take($take)
        ->paginate(50);
   }

   public function getType($id)
   {
      $res = Order::find($id);

      if($res->status_by == 1)
      {
         $return = "Admin";
      }
      elseif($res->status_by == 2)
      {
         $return = "Store";
      }
      elseif($res->status_by == 3)
      {
         $return = "User";
      }

      return $return;
   }

   public function signleOrder($id)
   {
      return Order::join('users','orders.store_id','=','users.id')
                 ->select('users.name as store','orders.*')
                 ->where('orders.id',$id)
                 ->first();
   }

   public function cancelOrder($id,$uid)
   {
      $res              = Order::find($id);
      $res->status      = 2;
      $res->status_by   = 3;
      $res->status_time    = date('d-M-Y').' | '.date('h:i:A');
      $res->save();

      return ['data' => $this->history($res->user_id)];
   }

   public function getReport($data)
   {
      $res = Order::where(function($query) use($data) {

      if(isset($data['from']))
      {
         $from = date('Y-m-d',strtotime($data['from']));
      }
      else
      {
         $from = null;
      }

      if(isset($data['to']))
      {
         $to = date('Y-m-d',strtotime($data['to']));
      }
      else
      {
         $to = null;
      }

      if($from)
      {
         $query->whereDate('orders.created_at','>=',$from);
      }

      if($to)
      {
         $query->whereDate('orders.created_at','<=',$to);
      }

      if(isset($data['store_id']))
      {
         $query->where('orders.store_id',$data['store_id']);
      }

      })->join('app_user','orders.user_id','=','app_user.id')
        ->join('order_item','orders.id','=','order_item.order_id')
        ->join('delivery_boys','delivery_boys.id','=','orders.d_boy')
        ->join('item','order_item.item_id','=','item.id')
        ->join('users','orders.store_id','=','users.id')
        ->select('users.name as store','app_user.name as user','orders.*','item.name as name_item',
            'order_item.price as precio_venta', 'order_item.price_real as precio_real', 'delivery_boys.name as dboy')
        ->orderBy('orders.id','ASC')->get();

      $allData = [];

      foreach($res as $row)
      {

         $allData[] = [

         'id'     => $row->id,
         'date'   => date('d-M-Y',strtotime($row->created_at)),
         'user'   => $row->user,
         'store'  => $row->store,
         'amount' => $row->total,
         'name_item' => $row->name_item,
         'precio_venta' => floatval($row->precio_venta),
         'precio_real' => floatval($row->precio_real),
         'total' => (floatval($row->precio_venta) - floatval($row->precio_real)),
         'd_charges' => $row->d_charges,
         'dboy' => $row->dboy,

         ];
      }

      return $allData;
   }

   public function getStatus($id)
   {
      $order = Order::find($id);

         if($order->status == -1)
         {
            $status = "<span class='badge badge-soft-danger badge-light'>Por asignar</span>";
         }
         elseif($order->status == 0)
         {
            $status = "<span class='badge badge-soft-danger badge-light'>Pendiente</span>";
         }
         elseif($order->status == 1)
         {
            $status = "<span class='badge badge-soft-info badge-light'>Pedido confirmado</span>";
         }
         elseif($order->status == 2)
         {
            $status = "<span class='badge badge-soft-warning badge-light'>Orden cancelada</span>";
         }
         elseif($order->status == 3)
         {
            $status = "<span class='badge badge-soft-info badge-light'>Repartidor asignado</span>";
         }
         elseif($order->status == 4)
         {
            $status = "<span class='badge badge-soft-info badge-light'>En camino</span>";
         }
         else
         {
            $status = "<span class='badge badge-soft-success badge-light'>Entregada</span>";
         }

         return $status;
   }

   public function sendSms($id)
   {
      $order = Order::find($id);
      $admin = Admin::find(1);

      if($order->status == 1)
      {
         $msg = "Estimado ".$order->name.", su pedido #".$order->id." ha sido confirmado El monto total del pedido es ".$admin->currency.$order->total;
         $title = "Orden confirmada";
      }
      elseif($order->status == 2)
      {
         $msg   = "Estimado ".$order->name.", su pedido #".$order->id." has been Cancelled.";
         $title = "Orden cancelada";

      }
      elseif($order->status == 3)
      {
         $msg = "Estimado ".$order->name.", El socio de entrega ha sido asignado para su pedido no..".$order->id;
         $title = "Socio de entrega asignado";

         $msg2 = "Nuevo orden #".$order->id." toque recibido para más información";
         app('App\Http\Controllers\Controller')->sendPushD("Nuevo pedido recibido",$msg2,$order->d_boy);

      }
       elseif($order->status == 4)
      {
         $msg = "Estimado ".$order->name.", su pedido #".$order->id." ha sido enviado.";
         $title = "Pedido para entrega";
      }
      else
      {
         $msg = "Estimado ".$order->name.", su pedido #".$order->id." ha sido entregado con éxito.";
         $title = "Pedido entregado";

      }

      app('App\Http\Controllers\Controller')->sendSms($order->phone,$msg);
      app('App\Http\Controllers\Controller')->sendPush($title,$msg,$order->user_id);

      return true;
   }

   public function storeOrder($status = null)
   {
      $res = Order::where(function($query) use($status) {

         if(isset($_GET['id']))
         {
            $query->where('orders.store_id',$_GET['id']);
         }

         if(isset($_GET['status']) && !$status)
         {
            if($_GET['status'] == 0)
            {
               $query->whereIn('orders.status',[0,1,3,4]);
            }
         }

         if($status == 6)
         {
            $query->where('orders.status',6);
         }

      })->orderBy('orders.id','DESC')
        ->get();

        $data   = [];
        $admin  = Admin::find(1);
        $item   = new OrderItem;

        foreach($res as $row)
        {
            if($row->status == 0)
            {
                $status = "Repartidor pendiente";
            }
            elseif($row->status == 1)
            {
                $status = "Repartidor confirmado";
            }
            elseif($row->status == 2)
            {
                $status = "Cancelled";
            }
            elseif($row->status == 3)
            {
                $status = "Confirmado por el restaurant";
            }
            elseif($row->status == 4)
            {
                $status = "Completo restaurant";
            }
            elseif($row->status == 5)
            {
                $status = "En camino ".$row->dboy;
            }
            else
            {
                $status = "Entregado";
            }

          $data[] = [

          'id'       => $row->id,
          'name'     => $row->name,
          'notes'    => $row->notes,
          'phone'    => $row->phone,
          'address'  => $row->address,
          'status'   => $row->status,
          'status_desc' => $status,
          'total'    => $row->total,
          'currency' => $admin->currency,
          'items'    => $item->getItem($row->id),
          'pay'      => $row->payment_method,
          'date'     => date('d-M-Y',strtotime($row->created_at))

          ];
        }

        return $data;
   }

   public function overView()
   {
      $total = Order::where('store_id',$_GET['id'])->count();
      $comp  = Order::where('store_id',$_GET['id'])->where('status',5)->count();

      return ['total' => $total,'complete' => $comp];
   }

   public function getUnit($id)
   {
      $item = Item::find($id);

      $data = [];

      if($item->small_price)
      {
         $data[] = ['id' => 1,'name' => "Pequeño - $.".$item->small_price];
      }

      if($item->medium_price)
      {
         $data[] = ['id' => 2,'name' => "Medio - $.".$item->medium_price];
      }

      if($item->large_price)
      {
         $data[] = ['id' => 3,'name' => "Grande/Completo - $.".$item->large_price];
      }

      return $data;
   }

   public function editOrder($data,$id)
   {
         $order                     = $id > 0 ? Order::find($id) : new Order;
         $address                   = $data['address'];

         if($id == 0)
         {
            $check = AppUser::where('phone',$data['phone'])->first();

            if(isset($check->id))
            {
               $uid = $check->id;
            }
            else
            {
               $user              = new AppUser;
               $user->name        = isset($data['name']) ? $data['name'] : null;
               $user->phone       = isset($data['phone']) ? $data['phone'] : null;
               $user->password    = 123456;
               $user->save();

               $uid = $user->id;
            }
         }

         $order->name               = isset($data['name']) ? $data['name'] : null;
         $order->phone              = isset($data['phone']) ? $data['phone'] : null;
         $order->store_id           = $data['store_id'];
         $order->email              = "none";
         $order->address            = $address;

         if($id == 0)
         {
            $order->user_id         = $uid;
         }

         $order->status             = 1;
         $order->d_charges          = 0;
         $order->discount           = 0;
         $order->offer_id           = 0;
         $order->total              = 0;
         $order->save();

         $item = new OrderItem;
         $item->editOrder($data,$order->id);

         $total = $this->updateTotal($order->id);

         if (isset($data['offer_id'])){
             $offer = Offer::find($data['offer_id']);
             $upto = $offer->upto;

             if ($offer['type'] === 0) // percent discount
                 $discount = ($offer['value'] / 100) * $total;

             if ($offer['type'] === 1) // defined discount
                 $discount = $offer['value'];

             $discount = $discount < $upto || $upto == null || $upto < 0 ? $discount: $upto;

             $order->total = $total - $discount;
             $order->offer_id = $offer->id;
             $order->discount = $discount;
             $order->save();
         }
   }

   public function updateTotal($id)
   {
      $order  = Order::find($id);
      $item   = new OrderItem;
      $total  = $item->getTotal($id);

      if($order->extra == 0)
      {
         $total = $total + $order->extra_amount;
      }
      else
      {
         $total = $total - $order->extra_amount;
      }

      $d_charges = $this->getDelivery($total,$id);

      $total = $total + $d_charges;

      $order->total        = $total;
      $order->d_charges    = $d_charges;
      $order->save();

      return $order->total;
   }

   public function getDelivery($total,$id)
   {
      $order = Order::find($id);
      $user  = User::find($order->store_id);
      $val   = 0;

      if($user->delivery_charges_value > 0)
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

      return $val;
   }
}
