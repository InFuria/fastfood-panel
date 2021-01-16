@extends('admin.layout.main')

@section('title') @lang('admin.Add New') @endsection

@section('icon') mdi-comment-plus @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-lg-10 mx-auto  mt-2">

{!! Form::model($data, ['url' => [$form_url],'files' => true],['class' => 'col s12']) !!}

@include('admin.user.form')

</form>
</div>
</div>
</div>
</section>

@endsection

@section('js')
<script>
    $(document).ready( function() {

        var val = '';
        var concat = '';
        $('input[name=available_days]').change(function (){
            val = '';
            concat = '';
            $('input[name=available_days]').each(function (index){

                val = $(this).is(':checked') ? '1' : '0';
                concat = concat.concat('', val);

                $('#days').val(concat);
            })
        })

    })
</script>
@append
