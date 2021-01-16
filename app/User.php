<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Auth;
use DB;
class User extends Authenticatable
{
    protected $guarded = [];
    /*
    |----------------------------------------------------------------
    |   Validation Rules and Validate data for add & Update Records
    |----------------------------------------------------------------
    */

    public function rules($type)
    {
        if($type === "add")
        {
            return [

            'name'      => 'required|unique:users',
            'phone'     => 'required',
            'email'     => 'required|unique:users',
            'password'  => 'required|min:6',
            ];
        }
        else
        {
            return [

            'name'      => 'required',
            'phone'    => 'required',
            'email'     => 'required',
            ];
        }
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
        $a                          = isset($data['lid']) ? array_combine($data['lid'], $data['l_name']) : [];
        $b                          = isset($data['lid']) ? array_combine($data['lid'], $data['l_address']) : [];
        $add                        = $type === 'add' ? new User : User::find($type);
        $add->name                  = isset($data['name']) ? $data['name'] : null;
        $add->phone                 = isset($data['phone']) ? $data['phone'] : null;
        $add->email                 = isset($data['email']) ? $data['email'] : null;
        $add->status                = isset($data['status']) ? $data['status'] : 0;
        $add->city_id               = isset($data['city_id']) ? $data['city_id'] : 0;
        $add->address               = isset($data['address']) ? $data['address'] : 0;
        $add->delivery_time         = isset($data['delivery_time']) ? $data['delivery_time'] : null;
        $add->person_cost           = isset($data['person_cost']) ? $data['person_cost'] : null;
        $add->lat                   = isset($data['lat']) ? $data['lat'] : null;
        $add->lng                   = isset($data['lng']) ? $data['lng'] : null;
        $add->type                  = isset($data['store_type']) ? $data['store_type'] : null;
        $add->min_cart_value        = isset($data['min_cart_value']) ? $data['min_cart_value'] : null;
        $add->delivery_charges_value = isset($data['delivery_charges_value']) ? $data['delivery_charges_value'] : null;
        $add->available_days        = isset($data['days']) ? $data['days'] : null;
        $add->category_id           = isset($data['store_type']) ? $data['store_type'] : null;

        if(isset($data['admin']))
        {
            $add->c_type                = isset($data['c_type']) ? $data['c_type'] : 0;
            $add->c_value               = isset($data['c_value']) ? $data['c_value'] : 0;
        }

        $add->s_data                = serialize([$a,$b]);

        if(isset($data['img']))
        {
            $filename   = time().rand(111,699).'.' .$data['img']->getClientOriginalExtension();
            $data['img']->move("upload/user/", $filename);
            $add->img = $filename;
        }

        if(isset($data['password']))
        {
            $add->password      = bcrypt($data['password']);
            $add->shw_password  = $data['password'];
        }

        if(isset($data['opening_time']))
        {
            $add->opening_time     = $data['opening_time'];
        }

        if(isset($data['closing_time']))
        {
            $add->closing_time   = $data['closing_time'];
        }

        $add->save();

        $gallery = new UserImage;
        $gallery->addNew($data,$add->id);
    }

    /*
    |--------------------------------------
    |Get all data from db
    |--------------------------------------
    */
    public function getAll()
    {
        return User::join('city','users.city_id','=','city.id')
            ->leftjoin('user_category', 'users.category_id', '=', 'user_category.id')
            ->select('city.name as city','users.*', 'user_category.id as cate_id', 'user_category.name as cate_name')
            ->orderBy('users.id','DESC')->get();
    }

    public function getAppData($city_id,$trending = false)
    {
        date_default_timezone_set('America/Monterrey');
        $currency   = Admin::find(1)->currency;
        $lat        = isset($_GET['lat']) ? $_GET['lat'] : 0;
        $lon        = isset($_GET['lng']) ? $_GET['lng'] : 0;

        $res  = User::leftjoin('user_category', 'users.category_id', '=', 'user_category.id')
        ->where(function($query) use($city_id,$trending){

            $query->where('users.status',0)->where('users.city_id',$city_id);

            if($trending)
            {
                $query->where('users.trending',1);
            }

            if(isset($_GET['banner']))
            {
                $sid   = BannerStore::where('banner_id',$_GET['banner'])->pluck('store_id')->toArray();

                $query->whereIn('users.id',$sid);
            }

            if(isset($_GET['q']))
            {
                $q   = $_GET['q'];
                $ids = Item::whereRaw('lower(name) like "%' . strtolower($q) . '%"')->pluck('store_id')->toArray();

                if(count($ids) > 0)
                {
                    $query->whereIn('users.id',$ids);
                }

                $query->whereRaw('lower(name) like "%' . strtolower($q) . '%"');
            }

        })->select('users.*', 'user_category.name as cate_name', 'user_category.id as cate_id',
                DB::raw("6371 * acos(cos(radians(" . $lat . "))
                * cos(radians(users.lat))
                * cos(radians(users.lng) - radians(" . $lon . "))
                + sin(radians(" .$lat. "))
                * sin(radians(users.lat))) AS distance"))

                ->orderBy('distance','ASC')->get();

        $data = [];

        foreach($res as $row)
        {

            $time  = date('H:i:s');
            $admin = Admin::find(1);
            $time = date('H:i:s',strtotime($time));
            $openTime  = date("H:i:s",strtotime($row->opening_time));
            $closeTime = date("H:i:s",strtotime($row->closing_time));


            if($time >= $openTime && $time <= $closeTime)
            {
                if($row->open == 0)
                {
                    $open = true;
                }
                else
                {
                    $open = false;
                }

            }
            else
            {
                $open = false;
            }

            $totalRate    = Rate::where('store_id',$row->id)->count();
            $totalRateSum = Rate::where('store_id',$row->id)->sum('star');

            if($totalRate > 0)
            {
                $avg          = $totalRateSum / $totalRate;
            }
            else
            {
                $avg           = 0 ;
            }

            $lid     =  isset($_GET['lid']) && $_GET['lid'] > 0 ? $_GET['lid'] : 0;

            $data[] = [

                'id'            => $row->id,
                //'title'         => $this->getLang($row->id,$_GET['lid'])['name'],
                'title'         => $this->getLang($row->id,$lid)['name'],
                'img'           => Asset('upload/user/'.$row->img),
                //'address'       => $this->getLang($row->id,$_GET['lid'])['address'],
                'address'       => $this->getLang($row->id,$lid)['address'],
                'open'          => $open,
                'trending'      => $row->trending,
                'logo'          => $admin->logo ? Asset('upload/admin/'.$admin->logo) : null,
                'phone'         => $row->phone,
                'rating'        => $avg > 0 ? number_format($avg, 1) : '0.0',
                'open_time'     => $openTime,
                'close_time'    => date('h:i:A',strtotime($row->closing_time)),
                'images'        => $this->userImages($row->id),
                'ratings'       => $this->getRating($row->id),
                'person_cost'   => $row->person_cost,
                'delivery_time' => $row->delivery_time,
                'type'          => $row->type,
                'currency'      => $currency,
                'discount'      => $this->discount($row->id,$currency)['msg'],
                'discount_value'=> $this->discount($row->id,$currency)['value'],
                'items'         => $this->menuItem($row->id),
                'cate_id'       => $row->cate_id,
                'cate_name'     =>$row->cate_name,
                'hora'         => $time,
            ];

        }

        return $data;

    }

    public function getLang($id,$lid)
    {
        $lid  = $lid > 0 ? $lid : 0;
        $data = User::find($id);

        if($lid == 0)
        {
            return ['name' => $data->name,'address' => $data->address];
        }
        else
        {
            $data = unserialize($data->s_data);

           return ['name' => $data[0][$lid],'address' => $data[1][$lid]];
        }
    }

    public function discount($id,$currency)
    {
        $res =  OfferStore::join('offer','offer_store.offer_id','=','offer.id')
                         ->select('offer.*')
                         ->where('offer.status',0)
                         ->where('offer_store.store_id',$id)
                         ->orderBy('offer.id','DESC')
                         ->first();
        $msg = null;
        $val = 0;

        if(isset($res->id))
        {
            $val = $res->value;

            if($res->type == 0)
            {
                $msg = $res->value."% de descuento con este cupon ".$res->code;
            }
            else
            {
                $msg = $currency.$res->value." de descuento con este cupon ".$res->code;
            }
        }

        return ['msg' => $msg,'value' => $val];
    }

    public function getRating($id)
    {
        $res =  Rate::join('app_user','rate.user_id','=','app_user.id')
                   ->select('app_user.name as user','rate.*')
                   ->where('rate.store_id',$id)
                   ->orderBy('rate.id','DESC')
                   ->get();
        $data = [];

        foreach($res as $row)
        {
            $data[] = ['user' => $row->user,'star' => $row->star,'comment' => $row->comment,'date' => date('d-M-Y',strtotime($row->created_at))];
        }

        return $data;
    }

    public function userImages($id)
    {
        $res = UserImage::where('user_id',$id)->get();
        $data = [];

        foreach($res as $row)
        {
            $data[] = ['img' => Asset('upload/user/gallery/'.$row->img)];
        }

        return $data;
    }

    public function menuItem($id)
    {
        $data     = [];
        $cates    = Item::where('status',0)->where('store_id',$id)->select('category_id')->distinct()->get();

        foreach($cates as $cate)
        {
            $items = Item::where('status',0)->where('category_id',$cate->category_id)->where('store_id',$id)->orderBy('sort_no','ASC')->get();
            $count = [];
            $showOptions = true;

            foreach($items as $i)
            {
                $entra = 0;

                if ($i->large_price != null) {
                    $entra++;
                }

                if ($i->small_price != null) {
                    $entra++;
                }

                if ($i->medium_price != null) {
                    $entra++;
                }

                if ($entra == 1) {
                    $showOptions = false;
                }

                if($i->small_price)
                {
                    $price = $i->small_price;
                }
                elseif(!$i->small_price && $i->medium_price)
                {
                    $price = $i->medium_price;
                }
                elseif(!$i->small_price && !$i->medium_price)
                {
                    $price = $i->large_price;
                }

                if($i->small_price)
                {
                    $count[] = $i->small_price;
                }

                if($i->medium_price)
                {
                    $count[] = $i->medium_price;
                }

                if($i->large_price)
                {
                    $count[] = $i->large_price;
                }

                $lid     =  isset($_GET['lid']) && $_GET['lid'] > 0 ? $_GET['lid'] : 0;

                $item[] = [

                'id'            => $i->id,
                //'name'          => $this->getLangItem($i->id,$_GET['lid'])['name'],
                'name'          => $this->getLangItem($i->id,$lid)['name'],
                'img'           => $i->img ? Asset('upload/item/'.$i->img) : null,
                //'description'   => $this->getLangItem($i->id,$_GET['lid'])['desc'],
                'description'   => $this->getLangItem($i->id,$lid)['desc'],
                's_price'       => $i->small_price,
                'm_price'       => $i->medium_price,
                'l_price'       => $i->large_price,
                'price'         => $price,
                'count'         => count($count),
                'nonveg'        => $i->nonveg,
                'addon'         => $this->addon($i->id),
                'status'        => $i->status,
                'showOptions'   => $showOptions,
                'cate_id'       => $i->category_id,
                'cate_name'     => Category::find($i->category_id)->name,
                ];


            }

            //$data[] = ['id' => $cate->category_id,'cate_name' => $this->getLangCate($cate->category_id,$_GET['lid'])['name'],'items' => $item];

            $data[] = [
                'id' => $cate->category_id,
             //   'cate_name' => $this->getLangCate($cate->category_id,$lid)['name'],
                'items' => $item
            ];

            unset($item);

        }

        //print_r( $data);

        return $data;
    }

    public function getLangCate($id,$lid)
    {
        $lid  = $lid > 0 ? $lid : 0;
        $data = Category::find($id);

        if($lid == 0)
        {
            return ['name' => $data->name];
        }
        else
        {
            $data = unserialize($data->s_data);

            return ['name' => $data[$lid]];
        }
    }

    public function getLangItem($id,$lid)
    {
        $lid  = $lid > 0 ? $lid : 0;
        $data = Item::find($id);

        if($lid == 0)
        {
            return ['name' => $data->name,'desc' => $data->description];
        }
        else
        {
            $data = unserialize($data->s_data);

            return ['name' => $data[0][$lid],'desc' => $data[1][$lid]];

        }
    }

    public function addon($id)
    {
       return ItemAddon::join('addon','item_addon.addon_id','=','addon.id')
                        ->select('addon.*')
                        ->where('item_addon.item_id',$id)
                        ->get();
    }

    public function overview()
    {
        return [

        'order'     => Order::where('store_id',Auth::user()->id)->count(),
        'complete'  => Order::where('store_id',Auth::user()->id)->where('status',4)->count(),
        'month'     => Order::where('store_id',Auth::user()->id)->whereDate('created_at','LIKE',date('Y-m').'%')
                            ->count(),
        'items'     => Item::where('store_id',Auth::user()->id)->where('status',0)->count()

        ];
    }

    public function getSData($data,$id,$field)
    {
        $data = unserialize($data);

        return isset($data[$field][$id]) ? $data[$field][$id] : null;
    }

   public function login($data)
   {
     $chk = User::where('status',0)->where('email',$data['email'])->where('shw_password',$data['password'])->first();

     if(isset($chk->id))
     {
        return ['msg' => 'done','user_id' => $chk->id];
     }
     else
     {
        return ['msg' => 'Opps! Datos de acceso incorrectos'];
     }
   }

   public function getCom($id,$total)
   {
     $order = Order::find($id);
     $user  = User::find($order->store_id);

     if($user->c_type == 0)
     {
        $val = $user->c_value;
     }
     else
     {
        $val = round($total * intval(str_replace('%', '', $user->c_value)) / 100);
     }

     return $val;
   }

    public function items()
    {
        return $this->hasMany(item::class, "store_id", "id");
    }

    public function openStoresData($city_id,$trending = false)
    {
        date_default_timezone_set('America/Monterrey');
        $currency   = Admin::find(1)->currency;
        $lat        = isset($_GET['lat']) ? $_GET['lat'] : 0;
        $lon        = isset($_GET['lng']) ? $_GET['lng'] : 0;

        $res  = User::leftjoin('user_category', 'users.category_id', '=', 'user_category.id')->where('users.open', 0)
            ->whereRaw("STR_TO_DATE(opening_time, '%H:%i') < time(now()) and STR_TO_DATE(closing_time, '%H:%i') > time(now())")
            ->where(function($query) use($city_id,$trending){

                $query->where('users.status',0)->where('users.city_id',$city_id);

                if($trending)
                {
                    $query->where('users.trending',1);
                }

                if(isset($_GET['banner']))
                {
                    $sid   = BannerStore::where('banner_id',$_GET['banner'])->pluck('store_id')->toArray();

                    $query->whereIn('users.id',$sid);
                }

                if(isset($_GET['q']))
                {
                    $q   = $_GET['q'];
                    $ids = Item::whereRaw('lower(name) like "%' . strtolower($q) . '%"')->pluck('store_id')->toArray();

                    if(count($ids) > 0)
                    {
                        $query->whereIn('users.id',$ids);
                    }

                    $query->whereRaw('lower(name) like "%' . strtolower($q) . '%"');
                }

            })->select('users.*', 'user_category.name as cate_name', 'user_category.id as cate_id',
                DB::raw("6371 * acos(cos(radians(" . $lat . "))
                * cos(radians(users.lat))
                * cos(radians(users.lng) - radians(" . $lon . "))
                + sin(radians(" .$lat. "))
                * sin(radians(users.lat))) AS distance"))

            ->orderBy('distance','ASC')->get();

        $data = [];

        foreach($res as $row)
        {

            $time  = date('H:i:s');
            $admin = Admin::find(1);
            $time = date('H:i:s',strtotime($time));
            $openTime  = date("H:i:s",strtotime($row->opening_time));
            $closeTime = date("H:i:s",strtotime($row->closing_time));


            if($time >= $openTime && $time <= $closeTime)
            {
                if($row->open == 0)
                {
                    $open = true;
                }
                else
                {
                    $open = false;
                }

            }
            else
            {
                $open = false;
            }

            $totalRate    = Rate::where('store_id',$row->id)->count();
            $totalRateSum = Rate::where('store_id',$row->id)->sum('star');

            if($totalRate > 0)
            {
                $avg          = $totalRateSum / $totalRate;
            }
            else
            {
                $avg           = 0 ;
            }

            $lid     =  isset($_GET['lid']) && $_GET['lid'] > 0 ? $_GET['lid'] : 0;

            $data[] = [

                'id'            => $row->id,
                //'title'         => $this->getLang($row->id,$_GET['lid'])['name'],
                'title'         => $this->getLang($row->id,$lid)['name'],
                'img'           => Asset('upload/user/'.$row->img),
                //'address'       => $this->getLang($row->id,$_GET['lid'])['address'],
                'address'       => $this->getLang($row->id,$lid)['address'],
                'open'          => $open,
                'trending'      => $row->trending,
                'logo'          => $admin->logo ? Asset('upload/admin/'.$admin->logo) : null,
                'phone'         => $row->phone,
                'rating'        => $avg > 0 ? number_format($avg, 1) : '0.0',
                'open_time'     => $openTime,
                'close_time'    => date('h:i:A',strtotime($row->closing_time)),
                'images'        => $this->userImages($row->id),
                'ratings'       => $this->getRating($row->id),
                'person_cost'   => $row->person_cost,
                'delivery_time' => $row->delivery_time,
                'type'          => $row->type,
                'currency'      => $currency,
                'discount'      => $this->discount($row->id,$currency)['msg'],
                'discount_value'=> $this->discount($row->id,$currency)['value'],
                'items'         => $this->menuItem($row->id),
                'cate_id'       => $row->cate_id,
                'cate_name'     => $row->cate_name,
                'hora'         => $time,
            ];

        }

        return $data;

    }


    /** Relationships */
    public function category(){

        return $this->belongsTo(StoreCategory::class, 'category_id');
    }
}
