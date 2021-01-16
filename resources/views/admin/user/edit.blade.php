@extends('admin.layout.main')

@section('title') @lang('admin.Edit Details') @endsection

@section('icon') mdi-comment-plus @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-lg-10 mx-auto  mt-2">
{!! Form::model($data, ['url' => [$form_url],'files' => true,'method' => 'PATCH'],['class' => 'col s12']) !!}

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

            var checkDays = $('input[name=available_days]');
            var days = $('#days');

            if (days.val().length > 0){
                var definedDays = days.val().toString(10).replace(/\D/g, '0').split('').map(Number);

                checkDays.each(function (index){

                    if (definedDays[index] === 1){
                        $(this).prop('checked', 'checked');
                    }
                })
            }

            var val = '';
            var concat = '';
            checkDays.change(function (){
                val = '';
                concat = '';
                checkDays.each(function (index){

                    val = $(this).is(':checked') ? '1' : '0';
                    concat = concat.concat('', val);

                    days.val(concat);
                })
            })
        })
    </script>
@append
