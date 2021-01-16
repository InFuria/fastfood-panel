@extends('admin.layout.main')

@section('title') Editar detalles @endsection

@section('icon') mdi-calendar @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-lg-10 mx-auto  mt-2">
{!! Form::model($data, ['url' => [$form_url],'files' => true,'method' => 'PATCH'],['class' => 'col s12']) !!}

@include('admin.offer.form')

</form>
</div>
</div>
</div>
</section>

<script>
    function resetStores(){

        var stores = {!! $users !!};

        $('#store')
            .empty()
            .append('<option value="-1">Toda la tienda</option>')
        ;

        $.each(stores, function( key, value ) {
            $('#store').append('<option value=' + value.id + '>'+ value.name +'</option>');
        });
    }
</script>
@endsection

@section('js')
@append
