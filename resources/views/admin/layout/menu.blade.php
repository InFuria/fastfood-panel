@inject('admin', 'App\Admin')


@php($page = Request::segment(2))
<style type="text/css">
.menu-item{
	border-bottom: 1px solid #000000 !important;
}
</style>
<div class="admin-sidebar-brand">
<!-- begin sidebar branding-->
<img class="admin-brand-logo" src="{{Asset('assets/img/ico_logo.png') }}" width="40" alt="atmos Logo">
<span class="admin-brand-content font-secondary"><a href="{{ Asset(env('admin').'/home') }}">  Administrador</a></span>
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
<span class="menu-name">Dashboard
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
<a href="{{ Asset(env('admin').'/home') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.home')</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-home">

</i>
</span>
</a>
</li>
<li class="menu-item ">
<a href="{{ Asset(env('admin').'/setting') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.Settings')</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-message-settings-variant">

</i>
</span>
</a>
</li>

<!--
<li class="menu-item ">
<a href="{{ Asset(env('admin').'/text/add') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.App_Text')</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-message-settings-variant">

</i>
</span>
</a>
</li>-->
</ul>
</li>

<!--<li class="menu-item @if($page === 'language') active @endif">
<a href="{{ Asset(env('admin').'/language') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.Languages')</span></span>
<span class="menu-icon">
 <i class="mdi mdi-calendar-edit"></i>
</span>
</a>
</li>-->

<li class="menu-item @if($page === 'slider' || $page == 'banner') active @endif">
<a href="#" class="open-dropdown menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.Banners')
<span class="menu-arrow"></span>
</span>

</span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-image-filter "></i>
</span>
</a>
<!--submenu-->
<ul class="sub-menu">
<li class="menu-item">
<a href="{{ Asset(env('admin').'/slider') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.Welcome_Slider')</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-image-filter">

</i>
</span>
</a>
</li>

<li class="menu-item ">
<a href="{{ Asset(env('admin').'/banner') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.Banners')</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-image">

</i>
</span>
</a>
</li>
</ul>
</li>

<li class="menu-item @if($page === 'city') active @endif">
<a href="{{ Asset(env('admin').'/city') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.Manage_Cities')</span></span>
<span class="menu-icon">
 <i class="mdi mdi-map-marker"></i>
</span>
</a>
</li>

<li class="menu-item @if($page === 'page') active @endif">
<a href="{{ Asset(env('admin').'/page/add') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.App_Pages')</span></span>
<span class="menu-icon">
 <i class="mdi mdi-file"></i>
</span>
</a>
</li>

<li class="menu-item @if($page === 'user') active @endif">
<a href="{{ Asset(env('admin').'/user') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.Manage_Restaurants')</span></span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-home"></i>
</span>
</a>
</li>

<li class="menu-item @if($page === 'category') active @endif">
    <a href="{{ Asset(env('admin').'/category') }}" class="menu-link">
        <span class="menu-label"><span class="menu-name">@lang('admin.Manage_Categories')</span></span>
        <span class="menu-icon">
<i class="icon-placeholder mdi mdi-tag"></i>
</span>
</a>
</li>

<li class="menu-item @if($page === 'offer') active @endif">
<a href="{{ Asset(env('admin').'/offer') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.Discount_Offers')</span></span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-calendar"></i>
</span>
</a>
</li>


<li class="menu-item @if($page === 'delivery') active @endif">
<a href="{{ Asset(env('admin').'/delivery') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.Staff_Members')</span></span>
<span class="menu-icon">
<i class="mdi mdi-account-clock"></i>
</span>
</a>
</li>

<li class="menu-item @if($page === 'order') active @endif">
<a href="#" class="open-dropdown menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.Manage_Orders')

<?php
$cOrder = DB::table('orders')->where('status',0)->count();
$rOrder = DB::table('orders')->where('status',1)->count();
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
<a href="{{ Asset(env('admin').'/order/assing?status=-1') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">Asignar Ordenes

</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-cart">

</i>
</span>
</a>
</li>

<li class="menu-item">
<a href="{{ Asset(env('admin').'/order?status=0') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.New_Orders')

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
<a href="{{ Asset(env('admin').'/order?status=1') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.Running_Orders')

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
<a href="{{ Asset(env('admin').'/order?status=2') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.Cancelled_Orders')</span>
</span>
<span class="menu-icon">
<i class="icon-placeholder  mdi mdi-cancel">

</i>
</span>
</a>
</li>

<li class="menu-item">
<a href="{{ Asset(env('admin').'/order?status=6') }}" class=" menu-link">
<span class="menu-label">
<span class="menu-name">@lang('admin.Completed_Orders')</span>
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
<a href="{{ Asset(env('admin').'/push') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.Push_Notification')</span></span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-send"></i>
</span>
</a>
</li>

<li class="menu-item">
<a href="{{ Asset(env('admin').'/report') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.Reporting')</span></span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-file"></i>
</span>
</a>
</li>

<li class="menu-item">
<a href="{{ Asset(env('admin').'/appUser') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.App_Users')</span></span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-account"></i>
</span>
</a>
</li>




<li class="menu-item">
<a href="{{ Asset(env('admin').'/logout') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">@lang('admin.Logout')</span></span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-logout"></i>
</span>
</a>
</li>

</ul>
</div>
