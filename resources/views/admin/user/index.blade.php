@extends('admin.layout.main')

@section('title') @lang('admin.Manage Restaurants') @endsection

@section('icon') mdi-home @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-md-12">
<div class="card py-3 m-b-30">

<div class="row">
<div class="col-md-12" style="text-align: right;"><a href="{{ Asset($link.'add') }}" class="btn m-b-15 ml-2 mr-2 btn-rounded btn-warning">@lang('admin.Add New')</a>&nbsp;&nbsp;&nbsp;</div>

</div>


<div class="card-body">
<table class="table table-hover ">
<thead>
<tr>
<th>@lang('admin.Image')</th>
<th>@lang('admin.Name')</th>
<th>@lang('admin.Phone')</th>
<th>@lang('admin.City')</th>
<th>@lang('admin.Status')</th>
<th style="text-align: right">@lang('admin.Option')</th>
</tr>

</thead>
<tbody>

@foreach($data as $row)

<tr>
<td width="10%"><img src="{{ Asset('upload/user/'.$row->img) }}" height="40"></td>
<td width="15%">{{ $row->name }}<br>
    @if(isset($row->cate_name))
        <small>{{ $row->cate_name }}</small>
    @else
        <small>No asignado</small>
    @endif
</td>
<td width="12%">{{ $row->phone }}</td>
<td width="12%">{{ $row->city }}</td>
<td width="12%">

@if($row->status == 0)

<button type="button" class="btn btn-sm m-b-15 ml-2 mr-2 btn-info" onclick="confirmAlert('{{ Asset($link.'status/'.$row->id) }}')">@lang('admin.Active')</button>

@else

<button type="button" class="btn btn-sm m-b-15 ml-2 mr-2 btn-danger" onclick="confirmAlert('{{ Asset($link.'status/'.$row->id) }}')">@lang('admin.Disabled')</button>

@endif

</td>

<td width="35%" style="text-align: right">
    <form action="{{ route('cloneUser') }}" method="post" id="sendToClone{{ $row->id }}">
        @csrf
        <input type="hidden" name="id" value="{{ $row->id }}"/>
    </form>

    <a href="javascript::void()" class="btn m-b-15 ml-2 mr-2 btn-md  btn-rounded-circle btn-info" onclick="document.getElementById('sendToClone{{ $row->id }}').submit()"><i class="mdi mdi-content-copy"></i></a>


<a href="javascript::void()" class="btn m-b-15 ml-2 mr-2 btn-md  btn-rounded-circle <?php if($row->open == 1){ echo "btn-danger"; } else { echo "btn-success"; } ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php if($row->open == 1){ echo "Cerrado"; } else { echo "Abierto"; } ?>" onclick="confirmAlert('{{ Asset($link.'status/'.$row->id.'?type=open') }}')"><i class="mdi mdi-disc"></i></a>

<a href="javascript::void()" class="btn m-b-15 ml-2 mr-2 btn-md  btn-rounded-circle <?php if($row->trending == 1){ echo "btn-success"; } else { echo "btn-warning"; } ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php if($row->trending == 1){ echo "Tendencia"; } else { echo "Hacer tendencia"; } ?>" onclick="confirmAlert('{{ Asset($link.'status/'.$row->id.'?type=trend') }}')"><i class="mdi mdi-trending-up"></i></a>


<a href="{{ Asset(env('admin').'/loginWithID/'.$row->id) }}" class="btn m-b-15 ml-2 mr-2 btn-md  btn-rounded-circle btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Iniciar sesión con este usuario" target="_blank"><i class="mdi mdi-login"></i></a>

<a href="javascript::void()" class="btn m-b-15 ml-2 mr-2 btn-md  btn-rounded-circle btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Ver credenciales" onclick="showMsg('Usuario: {{ $row->email }}<br>Contraseña: {{ $row->shw_password }}')"><i class="mdi mdi-lock"></i></a>

<a href="{{ Asset($link.$row->id.'/edit') }}" class="btn m-b-15 ml-2 mr-2 btn-md  btn-rounded-circle btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Editar esta entrada"><i class="mdi mdi-border-color"></i></a>

<button type="button" class="btn m-b-15 ml-2 mr-2 btn-md  btn-rounded-circle btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar esta entrada" onclick="deleteConfirm('{{ Asset($link."delete/".$row->id) }}')"><i class="mdi mdi-delete-forever"></i></button>


</td>
</tr>

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
