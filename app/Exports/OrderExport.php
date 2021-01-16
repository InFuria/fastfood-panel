<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::select('name','email','phone','address','d_charges','discount','total')->where('store_id',$_GET['store_id'])->get();
    }

    public function headings(): array
    {
        return [
            'User Name',
            'Email',
            'Phone',
            'Address',
            'Delivery Charges',
            'Discount',
            'Total Amount',
        ];
    }
}
