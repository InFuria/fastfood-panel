@extends('user.layout.main')

@section('title') Imprimir factura @endsection

@section('icon') mdi-file @endsection


@section('content')

<div class="pull-up">
<div class="container" id="printableArea">
<div class="row"  >
<div class="col-md-12 m-b-40">
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-md-6">

<address class="m-t-10">
To,<br>
<span class="h4 font-primary"> {{ $order->name }}</span> <br>
{{ $order->phone }}<br>
{{ $order->email }}<br>
{{ $order->address }}<br>
{{ $order->city }}<br>


</address>
</div>
<div class="col-md-6 text-right my-auto">
<h1 class="font-primary">RECIBO</h1>
<div class="">Solicitar ID: #{{ $order->id }}</div>
<div class="">Fecha: {{ date('d-M-Y',strtotime($order->created_at)) }}</div>
</div>
</div>

<div class="table-responsive ">
<table class="table m-t-50">
<thead>
<tr>
<th width="40%">Nombre del árticulo</th>
<th class="text-center">Precio</th>
<th class="text-center">Cantidad</th>
<th class="text-right">Total</th>
</tr>
</thead>
<tbody>
@php($total = [])
@foreach($items as $item)
@php($total[] = $item['qty'] * $item['price'])

<tr>
<td width="40%">{{ $item['type'] }} - {{ $item['item'] }}</td>
<td width="20%" class="text-center">{{ $item['price'] }}</td>
<td width="20%" class="text-center">{{ $item['qty'] }}</td>
<td width="20%" class="text-right">{{ $currency.$item['qty'] * $item['price'] }}</td>
</tr>

@foreach($it->getAddon($item['id'],$order->id) as $add)

<tr>
<td width="40%">{{ $add->addon }}</td>
<td width="20%" class="text-center">{{ $currency.$add->price }}</td>
<td width="20%" class="text-center">{{ $add->qty  }}</td>
<td width="20%" class="text-right">{{ $currency.$add->qty * $add->price }}</td>
</tr>

@endforeach

@endforeach

<tr>
<td width="40%">&nbsp;</td>
<td width="20%">&nbsp;</td>
<td width="20%" class="text-center"><b>Total</b></td>
<td width="20%" class="text-right"><b>{{ $currency.array_sum($total) }}</b></td>
</tr>

@if($order->discount)

<tr>
<td width="40%">&nbsp;</td>
<td width="20%">&nbsp;</td>
<td width="20%" class="text-center"><b>Descuento</b></td>
<td width="20%" class="text-right"><b>{{ $currency.$order->discount }}</b></td>
</tr>

@endif


@if($order->d_charges)

<tr>
<td width="40%">&nbsp;</td>
<td width="20%">&nbsp;</td>
<td width="20%" class="text-center"><b>Los gastos de envío</b></td>
<td width="20%" class="text-right"><b>{{ $currency.$order->d_charges }}</b></td>
</tr>

@endif

<tr>
<td width="40%">&nbsp;</td>
<td width="20%">&nbsp;</td>
<td width="20%" class="text-center"><b>Subtotal</b></td>
<td width="20%" class="text-right"><b>{{ $currency.$order->total }}</b></td>
</tr>

</tbody>
</table>
</div>
<div class="p-t-10 p-b-20">
<p class="text-muted ">

@if($order->payment_method == 1)

<b>Método de pago : </b> Contra reembolso<br><br>

@else

<b>Método de pago : </b> Pagado a través de PayPal<br><br>


@endif

Los servicios se facturarán de acuerdo con la Descripción del servicio. Debes
pagar todas las facturas no disputadas en su totalidad dentro de los 30 días posteriores a la fecha de la factura, a menos que
especificado de otra manera en los Términos y condiciones especiales. Todos los pagos deben
referencia el número de factura. A menos que se especifique lo contrario, todas las facturas serán
pagado en la moneda de la factura
</p>
<hr>
<div class="text-center opacity-75">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

@endsection
