@extends('admin.layout.main')

@section('title') @lang('admin.welcome') ! {{ Auth::guard('admin')->user()->name }} @endsection

@section('icon') mdi-home @endsection


@section('content')

<div class="container pull-up">

@include('admin.dashboard.overview')

@include('admin.dashboard.order')


</div>

@endsection

