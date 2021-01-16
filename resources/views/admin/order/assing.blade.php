@extends('admin.layout.main')

@section('title') {{ $title }} @endsection

@section('icon') mdi-cart @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-md-12">
<div class="card py-3 m-b-30">

<div class="row">

</div>


<div class="card-body">
<table class="table table-hover ">
<thead>
<tr>
<th>ID</th>
<th>Tienda</th>
<th>Usuario</th>
<th>Dirección</th>
<th>Artículos</th>
<th style="text-align: right">Opción</th>
</tr>

</thead>
<tbody>

@foreach($data as $row)

<tr>
<td width="6%">#{{ $row->id }}</td>
<td width="12%">{{ $row->store }}</td>
<td width="12%">{{ $row->name }}<br>{{ $row->phone }}</td>
<td width="15%">{{ $row->address }},{{ $row->city }}</td>
<td width="40%">

<div class="row">
<div class="col-md-6"><b>Articulo</b></div>
<div class="col-md-3"><b>Cantidad</b></div>
<div class="col-md-3"><b>Precio</b></div>
</div><hr>

@foreach($item->getItem($row->id) as $i)

<div class="row" style="font-size: 12px">
<div class="col-md-6">{{ $i['type']." - ".$i['item'] }}</div>
<div class="col-md-3">{{ $i['qty'] }}</div>
<div class="col-md-3">{{ $currency.$i['price'] }}</div>
</div><hr>

@if(count($item->getAddon($i['id'],$row->id)) > 0)

@foreach($item->getAddon($i['id'],$row->id) as $add)

<div class="row" style="font-size: 12px">
<div class="col-md-6">{{ $add->addon }}</div>
<div class="col-md-3">{{ $add->qty }}</div>
<div class="col-md-3">{{ $currency.$add->price }}</div>
</div><hr>



@endforeach

@endif

@endforeach

<div class="row" style="font-size: 12px;color:red">
<div class="col-md-6">Los gastos de envío : {{ $currency.$row->d_charges }}</div>
<div class="col-md-3">Descuento : {{ $currency.$row->discount }}</div>
<div class="col-md-3">Total : {{ $currency.$row->total }}</div>
</div><hr>

@if($row->notes)
<small style="color:blue">Notas : {{ $row->notes }}</small>
@endif
</td>


<td width="20%" style="text-align: right">

@include('admin.order.action')

</td>
</tr>

@endforeach

</tbody>
</table>

</div>
</div>

{!! $data->links() !!}

</div>
</div>
</div>
</section>

@endsection
