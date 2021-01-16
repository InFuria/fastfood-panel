@extends('admin.layout.main')

@section('title') Usuarios de la aplicación @endsection

@section('icon') mdi-home @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-md-12">
<div class="card py-3 m-b-30">

<div class="card-body">
<table class="table table-hover ">
<thead>
<tr>
<th>Usuario</th>
<th>Correo electrónico</th>
<th>Teléfono</th>
<th>Fecha de registro</th>
<th>Orden total</th>
</tr>

</thead>
<tbody>

@foreach($data as $row)

<tr>
<td width="10%">{{ $row->name }}</td>
<td width="10%">{{ $row->email }}</td>
<td width="10%">{{ $row->phone }}</td>
<td width="10%">{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
<td width="10%">{{ $row->countOrder($row->id) }}</td>

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
