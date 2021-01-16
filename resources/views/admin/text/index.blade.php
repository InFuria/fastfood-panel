@extends('admin.layout.main')

@section('title') Texto de la aplicación @endsection

@section('icon') mdi-map-marker @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-lg-10 mx-auto  mt-2">

{!! Form::model($data, ['url' => [$form_url],'files' => true],['class' => 'col s12']) !!}

@include('admin.text.form')

</form>

</div>
</div>
</div>
</section>

@endsection
