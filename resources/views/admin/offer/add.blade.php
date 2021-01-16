@extends('admin.layout.main')

@section('title') Agregar nuevo @endsection

@section('icon') mdi-calendar @endsection

@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-lg-10 mx-auto  mt-2">
{!! Form::model($data, ['url' => [$form_url],'files' => true],['class' => 'col s12']) !!}

@include('admin.offer.form')

</form>
</div>
</div>
</div>
</section>

@endsection
