@extends('admin.layout.main')

@section('title') Gestionar ofertas @endsection

@section('icon') mdi-calendar @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-md-12">
<div class="card py-3 m-b-30">

<div class="row">
<div class="col-md-12" style="text-align: right;"><a href="{{ Asset($link.'add') }}" class="btn m-b-15 ml-2 mr-2 btn-rounded btn-warning">Agregar nuevo</a>&nbsp;&nbsp;&nbsp;</div>

</div>


<div class="card-body">
<table class="table table-hover ">
<thead>
<tr>
<th>Código del cupón</th>
<th>Valor de descuento</th>
<th>Fecha Agregada</th>
<th>Estado</th>
<th style="text-align: right">Opción</th>
</tr>

</thead>
<tbody>

@foreach($data as $row)

<tr>
<td width="17%">{{ $row->code }}</td>
<td width="17%">
@if($row->type == 0) {{ $row->value }}% @else {{ $row->value }} @endif

</td>
<td width="17%">{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
<td width="12%">

@if($row->status == 0)

<button type="button" class="btn btn-sm m-b-15 ml-2 mr-2 btn-success" onclick="confirmAlert('{{ Asset($link.'status/'.$row->id) }}')">Activo</button>

@else

<button type="button" class="btn btn-sm m-b-15 ml-2 mr-2 btn-danger" onclick="confirmAlert('{{ Asset($link.'status/'.$row->id) }}')">Deshabilitado</button>

@endif

</td>



<td width="15%" style="text-align: right">

<a href="{{ Asset($link.$row->id.'/edit') }}" class="btn m-b-15 ml-2 mr-2 btn-md  btn-rounded-circle btn-success" data-toggle="tooltip" data-placement="top" data-original-title="@lang('admin.Edit This Entry')"><i class="mdi mdi-border-color"></i></a>

<button type="button" class="btn m-b-15 ml-2 mr-2 btn-md  btn-rounded-circle btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="@lang('admin.Delete This Entry')" onclick="deleteConfirm('{{ Asset($link."delete/".$row->id) }}')"><i class="mdi mdi-delete-forever"></i></button>


</td>
</tr>

@include('admin.offer.store')

@endforeach

</tbody>
</table>

</div>
</div>
</div>
</div>
</div>
</section>

@endsection
