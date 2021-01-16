@php($page = Request::segment(1))
<style type="text/css">
.menu-item{
	border-bottom: 1px solid #0c6057 !important;
}
</style>
<div class="admin-sidebar-brand">
<!-- begin sidebar branding-->
<img class="admin-brand-logo" src="{{Asset('assets/img/logo.png') }}" width="40" alt="atmos Logo">
<span class="admin-brand-content font-secondary"><a href="{{ Asset(env('user').'/home') }}">  Administrador</a></span>
<!-- end sidebar branding-->
<div class="ml-auto">
<!-- sidebar pin-->
<a href="#" class="admin-pin-sidebar btn-ghost btn btn-rounded-circle"></a>
<!-- sidebar close for mobile device-->
<a href="#" class="admin-close-sidebar"></a>
</div>
</div>
<div class="admin-sidebar-wrapper js-scrollbar">
<ul class="menu">
<li class="menu-item @if($page === 'home' || $page == 'setting') active @endif">
<a href="#" class="open-dropdown menu-link">
<span class="menu-label">
<span class="menu-name">Tablero
<span class="menu-arrow"></span>
</span>

</span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-shape-outline "></i>
</span>
</a>
<!--submenu-->
<ul class="sub-menu">

<li class="menu-item">
<a href="{{ Asset(env('user').'/home') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Casa</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-home">

</i>
</span>
</a>
</li>

<li class="menu-item ">
<a href="{{ Asset(env('user').'/setting') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Configuraciones</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-message-settings-variant">

</i>
</span>
</a>
</li>
</ul>
</li>

<li class="menu-item @if($page === 'category' || $page == 'item') active @endif">
<a href="#" class="open-dropdown menu-link">
<span class="menu-label">
<span class="menu-name">Elementos de menú
<span class="menu-arrow"></span>
</span>

</span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-silverware-fork-knife"></i>
</span>
</a>
<!--submenu-->
<ul class="sub-menu">

<li class="menu-item">
<a href="{{ Asset(env('user').'/category') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Categoría de menú</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-silverware-fork-knife">

</i>
</span>
</a>
</li>

<li class="menu-item ">
<a href="{{ Asset(env('user').'/item') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Elementos de menú</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-silverware-fork-knife">

</i>
</span>
</a>
</li>
<!-- 
<li class="menu-item">
<a href="{{ Asset(env('user').'/addon') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Addon</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-folder-plus">

</i>
</span>
</a>
</li> -->

</ul>
</li>

<li class="menu-item @if($page === 'order') active @endif" style="display: none !important">
<a href="#" class="open-dropdown menu-link">
<span class="menu-label">
<span class="menu-name">Gestionar pedidos

<?php
$cOrder = DB::table('orders')->where('store_id',Auth::user()->id)->where('status',0)->count();
$rOrder = DB::table('orders')->where('store_id',Auth::user()->id)->where('status',1)->count();
if($cOrder > 0)
{
?>

<span class="icon-badge badge-success badge badge-pill">{{ $cOrder }}</span>

<?php } ?>

<span class="menu-arrow"></span>
</span>

</span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-cart"></i>
</span>
</a>
<!--submenu-->
<ul class="sub-menu">

<li class="menu-item">
<a href="{{ Asset('order?status=0') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Nuevos pedidos

@if($cOrder > 0)

<span class="icon-badge badge-success badge badge-pill">{{ $cOrder }}</span>

@endif

</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-cart">

</i>
</span>
</a>
</li>


<li class="menu-item">
<a href="{{ Asset('order?status=1') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Ordenes en ejecución

@if($rOrder > 0)

<span class="icon-badge badge-success badge badge-pill">{{ $rOrder }}</span>

@endif

</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-camera-control">

</i>
</span>
</a>
</li>

<li class="menu-item">
<a href="{{ Asset('order?status=2') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Órdenes canceladas</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-cancel">

</i>
</span>
</a>
</li>

<li class="menu-item">
<a href="{{ Asset('order?status=5') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Órdenes completadas</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-check-all">

</i>
</span>
</a>
</li>
</ul>
</li>

<li class="menu-item">
<a href="{{ Asset(env('user').'/logout') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">Cerrar sesión</span></span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-logout"></i>
</span>
</a>
</li>

</ul>
</div>
