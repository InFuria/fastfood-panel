@php($page = Request::segment(2))

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


<li class="menu-item">
<a href="{{ Asset(env('staff').'/home') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">Casa</span></span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-home"></i>
</span>
</a>
</li>
<hr>
<li class="menu-item">
<a href="{{ Asset(env('staff').'/logout') }}" class="menu-link">
<span class="menu-label"><span class="menu-name">Cerrar sesión</span></span>
<span class="menu-icon">
<i class="icon-placeholder mdi mdi-logout"></i>
</span>
</a>
</li>

</ul>
</div>
