<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>@yield('title')</title>
    <link rel="icon" href="{{Asset('assets/img/ico_logo.png')}}" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="{{Asset('assets/vendor/pace/pace.css')}}">
    <script src="{{Asset('assets/vendor/pace/pace.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{Asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{Asset('assets/vendor/jquery-scrollbar/jquery.scrollbar.css')}}">
    <link rel="stylesheet" href="{{Asset('assets/vendor/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{Asset('assets/vendor/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{Asset('assets/vendor/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{Asset('assets/vendor/timepicker/bootstrap-timepicker.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,500,600" rel="stylesheet">
    <link rel="stylesheet" href="{{Asset('assets/fonts/jost/jost.css')}}">
    <link rel="stylesheet" type="text/css" href="{{Asset('assets/fonts/materialdesignicons/materialdesignicons.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{Asset('assets/css/atmos.min.css')}}">

    @yield('css')

<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "88032b40-3acb-43d6-ba37-051543588b62",
      notifyButton: {
        enable: true,
      },
      allowLocalhostAsSecureOrigin: true,
    });
  });
</script>

</head>
<body class="sidebar-pinned ">
<aside class="admin-sidebar">

@include('admin.layout.menu')


</aside>
<main class="admin-main">
<header class="admin-header">

@include('admin.layout.header')

</header>
<section class="admin-content">
<div class="bg-dark m-b-30">
<div class="container">
<div class="row p-b-60 p-t-60">
<div class="col-md-10 mx-auto text-center text-white p-b-30">

@if(Request::segment(3))

<h1 style="text-align: left;text-transform: uppercase;font-size: 22px;font-weight: 900">@yield('title')</h1>


@else

<h1 style="text-align: left;margin-left: -8%;text-transform: uppercase;font-size: 22px;font-weight: 900">@yield('title')</h1>


@endif

@if(Session::has('error'))
<div class="row" style="text-align: left">
<div class="col-md-1">&nbsp;</div>
<div class="col-md-8" style="margin-left: 2%;margin-top: 2%">
<div class="alert alert-danger alert-dismissible fade show" role="alert">
<strong>ERROR : </strong> {{ Session::get('error') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
</div>
</div>
@endif

@if(Session::has('message'))
<div class="row" style="text-align: left">
<div class="col-md-1">&nbsp;</div>
<div class="col-md-8" style="margin-left: 2%;margin-top: 2%">
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>ÉXITO : </strong> {{ Session::get('message') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
</div>
</div>
@endif

@if ($errors->any())

<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
    <li style="color:white">{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

</div>
</div>
</div>
</div>

@yield('content')

</div>
</div>
</div>
</section>
</main>


<script src="{{Asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{Asset('assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{Asset('assets/vendor/popper/popper.js') }}"></script>
<script src="{{Asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{Asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{Asset('assets/vendor/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{Asset('assets/vendor/listjs/listjs.min.js') }}"></script>
<script src="{{Asset('assets/vendor/moment/moment.min.js') }}"></script>
<script src="{{Asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{Asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{Asset('assets/vendor/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{Asset('assets/js/atmos.min.js') }}"></script>
<!--page specific scripts for demo-->


<!--Additional Page includes-->
<!--chart data for current dashboard-->
<script src="{{Asset('assets/js/dashboard-05.js') }}"   ></script>
<script src="{{Asset('assets/vendor/sweetalert/sweetalert2.all.min.js') }}"></script>

<script>
function deleteConfirm(url)
{
	Swal.fire({
            title: '@lang("admin.sure")',
            text: "@lang('admin.revert')",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Eliminado!',
                    'Esta entrada ha sido eliminada.',
                    'success'
                )

                window.location = url;
            }
  })
}

function confirmAlert(url)
{
	Swal.fire({
            title: '@lang("admin.sure")',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Modificado!',
                    'Esta entrada ha sido modificada.',
                    'success'
                )

                window.location = url;
            }
  })
}

function showMsg(data)
{
    Swal.fire(data);
}

$("#cd_id").change(function() {
    var id = $(this).val();

    $('#delivery_id')
            .find('option')
            .remove()
            .end();

    $.get("/admin/delivery/all?city="+id, function(data) {

        var result = data.data;
        for(var i in result) {
            $('#delivery_id')
                .append($("<option></option>")
                .attr("value", result[i].id)
                .text(result[i].name));
        }
    });
});

</script>

@yield('js')

</body>
</html>
