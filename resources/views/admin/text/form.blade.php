<div class="card py-3 m-b-30">
<div class="card-body">
@include('admin.language.header',['langs' => $langs])
</div>
</div>
<div class="tab-content" id="myTabContent1">
@php($i = 0)
@foreach($langs as $l)
@php($i++)

<div class="tab-pane fade show @if($l['id'] == 0) active @endif" id="lang{{ $l['id'] }}" role="tabpanel" aria-labelledby="lang{{$l['id'] }}-tab">

<input type="hidden" name="lid[]" value="{{ $l['id'] }}">

<h4>Pagina de bienvenida</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Botón de salto</label>
<input type="text" name="skip_button[]" class="form-control" value="{{ $data->getSData($l['id'],'skip_button') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">App Enter App</label>
<input type="text" name="enter_button[]" class="form-control" value="{{ $data->getSData($l['id'],'enter_button') }}">
</div>
</div>

</div>
</div>

<!--start-->
<h4>Seleccionar página de ciudad</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título de la página</label>
<input type="text" name="city_title[]" class="form-control" value="{{ $data->getSData($l['id'],'city_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Buscar marcador de posición</label>
<input type="text" name="city_search[]" class="form-control" value="{{ $data->getSData($l['id'],'city_search') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="city_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'city_heading') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Botón</label>
<input type="text" name="city_button[]" class="form-control" value="{{ $data->getSData($l['id'],'city_button') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Página de inicio</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Buscar marcador de posición</label>
<input type="text" name="home_search[]" class="form-control" value="{{ $data->getSData($l['id'],'home_search') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Filtro de título de oferta</label>
<input type="text" name="home_offer[]" class="form-control" value="{{ $data->getSData($l['id'],'home_offer') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Filtro de entrega rápida</label>
<input type="text" name="home_fast_delivery[]" class="form-control" value="{{ $data->getSData($l['id'],'home_fast_delivery') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Filtro de tendencias</label>
<input type="text" name="home_trending[]" class="form-control" value="{{ $data->getSData($l['id'],'home_trending') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Nuevo filtro de llegada</label>
<input type="text" name="home_new_arrival[]" class="form-control" value="{{ $data->getSData($l['id'],'home_new_arrival') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Por filtro de calificación</label>
<input type="text" name="home_by_rating[]" class="form-control" value="{{ $data->getSData($l['id'],'home_by_rating') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Texto de cupón</label>
<input type="text" name="home_coupon[]" class="form-control" value="{{ $data->getSData($l['id'],'home_coupon') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Costo por persona</label>
<input type="text" name="home_per_person[]" class="form-control" value="{{ $data->getSData($l['id'],'home_per_person') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Pestaña Inicio</label>
<input type="text" name="home_footer_name[]" class="form-control" value="{{ $data->getSData($l['id'],'home_footer_name') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Pestaña más cercano </label>
<input type="text" name="home_nearest[]" class="form-control" value="{{ $data->getSData($l['id'],'home_nearest') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Carrito de pestañas</label>
<input type="text" name="home_cart[]" class="form-control" value="{{ $data->getSData($l['id'],'home_cart') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Perfil de pestaña</label>
<input type="text" name="home_profile[]" class="form-control" value="{{ $data->getSData($l['id'],'home_profile') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Menú lateral</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="menu_title[]" class="form-control" value="{{ $data->getSData($l['id'],'menu_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Título de las páginas</label>
<input type="text" name="menu_page_title[]" class="form-control" value="{{ $data->getSData($l['id'],'menu_page_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Version de aplicacion</label>
<input type="text" name="menu_footer[]" class="form-control" value="{{ $data->getSData($l['id'],'menu_footer') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Página del artículo</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Ver información</label>
<input type="text" name="item_view_info[]" class="form-control" value="{{ $data->getSData($l['id'],'item_view_info') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Solo verduras</label>
<input type="text" name="item_veg_only[]" class="form-control" value="{{ $data->getSData($l['id'],'item_veg_only') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón Añadir al carro</label>
<input type="text" name="item_add_button[]" class="form-control" value="{{ $data->getSData($l['id'],'item_add_button') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Título de la página de complementos</label>
<input type="text" name="item_addon_title[]" class="form-control" value="{{ $data->getSData($l['id'],'item_addon_title') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Seleccionar tamaño de encabezado</label>
<input type="text" name="item_size_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'item_size_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Pequeño</label>
<input type="text" name="item_small[]" class="form-control" value="{{ $data->getSData($l['id'],'item_small') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Medio</label>
<input type="text" name="item_m[]" class="form-control" value="{{ $data->getSData($l['id'],'item_m') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Grande</label>
<input type="text" name="item_large[]" class="form-control" value="{{ $data->getSData($l['id'],'item_large') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Añadir</label>
<input type="text" name="addon_add_title[]" class="form-control" value="{{ $data->getSData($l['id'],'addon_add_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Encabezado de complemento</label>
<input type="text" name="item_addon_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'item_addon_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón de complemento</label>
<input type="text" name="item_addon_button[]" class="form-control" value="{{ $data->getSData($l['id'],'item_addon_button') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Página de información</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="info_title[]" class="form-control" value="{{ $data->getSData($l['id'],'info_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Título de Calificación y Opiniones</label>
<input type="text" name="info_rating_title[]" class="form-control" value="{{ $data->getSData($l['id'],'info_rating_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Hora de apertura</label>
<input type="text" name="info_open[]" class="form-control" value="{{ $data->getSData($l['id'],'info_open') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Hora de cierre</label>
<input type="text" name="info_close[]" class="form-control" value="{{ $data->getSData($l['id'],'info_close') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Costo por persona</label>
<input type="text" name="info_person[]" class="form-control" value="{{ $data->getSData($l['id'],'info_person') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">El tiempo de entrega</label>
<input type="text" name="info_d_time[]" class="form-control" value="{{ $data->getSData($l['id'],'info_d_time') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Página de carrito</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="cart_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Cantidad total</label>
<input type="text" name="cart_total[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_total') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Los gastos de envío</label>
<input type="text" name="cart_delivery[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_delivery') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Texto del cupón</label>
<input type="text" name="cart_coupon[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_coupon') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Cantidad a pagar</label>
<input type="text" name="cart_payable[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_payable') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón de pedido</label>
<input type="text" name="cart_button[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_button') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Carrito vacio</label>
<input type="text" name="cart_empty[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_empty') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Comience a ordenar</label>
<input type="text" name="cart_start_order[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_start_order') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Precio del carro</label>
<input type="text" name="cart_price[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_price') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Cantidad de carro</label>
<input type="text" name="cart_qty[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_qty') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Descuento</label>
<input type="text" name="cart_discount[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_discount') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Aplicar cupón</label>
<input type="text" name="cart_apply[]" class="form-control" value="{{ $data->getSData($l['id'],'cart_apply') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Página de cupones</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="coupon_title[]" class="form-control" value="{{ $data->getSData($l['id'],'coupon_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="coupon_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'coupon_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón</label>
<input type="text" name="coupon_button[]" class="form-control" value="{{ $data->getSData($l['id'],'coupon_button') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Página de inicio de sesión</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="login_title[]" class="form-control" value="{{ $data->getSData($l['id'],'login_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="login_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'login_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón de inicio de sesión</label>
<input type="text" name="login_button[]" class="form-control" value="{{ $data->getSData($l['id'],'login_button') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Se te olvidó tu contraseña</label>
<input type="text" name="login_forgot_password[]" class="form-control" value="{{ $data->getSData($l['id'],'login_forgot_password') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Restablecer la contraseña</label>
<input type="text" name="login_reset_password[]" class="form-control" value="{{ $data->getSData($l['id'],'login_reset_password') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón de registro</label>
<input type="text" name="login_signup[]" class="form-control" value="{{ $data->getSData($l['id'],'login_signup') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Se te olvidó tu contraseña</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="forgot_title[]" class="form-control" value="{{ $data->getSData($l['id'],'forgot_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="forgot_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'forgot_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Texto</label>
<input type="text" name="forgot_text[]" class="form-control" value="{{ $data->getSData($l['id'],'forgot_text') }}">
</div>
</div>


</div>
</div>
<!--End-->

<!--start-->
<h4>Regístrate</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="signup_title[]" class="form-control" value="{{ $data->getSData($l['id'],'signup_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="signup_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'signup_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón</label>
<input type="text" name="signup_button[]" class="form-control" value="{{ $data->getSData($l['id'],'signup_button') }}">
</div>
</div>


</div>
</div>
<!--End-->

<!--start-->
<h4>Realizar pedido</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="place_title[]" class="form-control" value="{{ $data->getSData($l['id'],'place_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Dirección de entrega</label>
<input type="text" name="place_delivery_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'place_delivery_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Agregar nueva dirección</label>
<input type="text" name="place_add_address[]" class="form-control" value="{{ $data->getSData($l['id'],'place_add_address') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Texto de dirección</label>
<input type="text" name="place_address_text[]" class="form-control" value="{{ $data->getSData($l['id'],'place_address_text') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Encabezado de pago</label>
<input type="text" name="place_payment_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'place_payment_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón de pedido</label>
<input type="text" name="place_order_button[]" class="form-control" value="{{ $data->getSData($l['id'],'place_order_button') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Agregar nueva dirección</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="add_title[]" class="form-control" value="{{ $data->getSData($l['id'],'add_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Dirección</label>
<input type="text" name="add_address[]" class="form-control" value="{{ $data->getSData($l['id'],'add_address') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Punto de referencia</label>
<input type="text" name="add_landmark[]" class="form-control" value="{{ $data->getSData($l['id'],'add_landmark') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón</label>
<input type="text" name="add_button[]" class="form-control" value="{{ $data->getSData($l['id'],'add_button') }}">
</div>
</div>

</div>
</div>
<!--End-->


<!--start-->
<h4>Página de confirmación de pedido</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="confirm_title[]" class="form-control" value="{{ $data->getSData($l['id'],'confirm_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="confirm_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'confirm_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Ver detalles de la orden</label>
<input type="text" name="confirm_view_order[]" class="form-control" value="{{ $data->getSData($l['id'],'confirm_view_order') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Solicitar ID</label>
<input type="text" name="confirm_order_id[]" class="form-control" value="{{ $data->getSData($l['id'],'confirm_order_id') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Total</label>
<input type="text" name="confirm_total[]" class="form-control" value="{{ $data->getSData($l['id'],'confirm_total') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Mi cuenta</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="profile_title[]" class="form-control" value="{{ $data->getSData($l['id'],'profile_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="profile_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'profile_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Texto de bienvenida</label>
<input type="text" name="profile_welcome[]" class="form-control" value="{{ $data->getSData($l['id'],'profile_welcome') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Historial de pedidos</label>
<input type="text" name="profile_order_history[]" class="form-control" value="{{ $data->getSData($l['id'],'profile_order_history') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Configuraciones</label>
<input type="text" name="profile_setting[]" class="form-control" value="{{ $data->getSData($l['id'],'profile_setting') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Cerrar sesión</label>
<input type="text" name="profile_logout[]" class="form-control" value="{{ $data->getSData($l['id'],'profile_logout') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Order History</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="history_title[]" class="form-control" value="{{ $data->getSData($l['id'],'history_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="history_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'history_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Fecha</label>
<input type="text" name="history_date[]" class="form-control" value="{{ $data->getSData($l['id'],'history_date') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Estado</label>
<input type="text" name="history_status[]" class="form-control" value="{{ $data->getSData($l['id'],'history_status') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Articulo</label>
<input type="text" name="history_item[]" class="form-control" value="{{ $data->getSData($l['id'],'history_item') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Cantidad</label>
<input type="text" name="history_qty[]" class="form-control" value="{{ $data->getSData($l['id'],'history_qty') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Precio</label>
<input type="text" name="history_price[]" class="form-control" value="{{ $data->getSData($l['id'],'history_price') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Título de calificación</label>
<input type="text" name="history_rating[]" class="form-control" value="{{ $data->getSData($l['id'],'history_rating') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Cancelar orden</label>
<input type="text" name="history_cancel[]" class="form-control" value="{{ $data->getSData($l['id'],'history_cancel') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Páginas de calificación e información</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título</label>
<input type="text" name="rating_title[]" class="form-control" value="{{ $data->getSData($l['id'],'rating_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Bóveda</label>
<input type="text" name="rating_heading[]" class="form-control" value="{{ $data->getSData($l['id'],'rating_heading') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Calificación Msg</label>
<input type="text" name="rating_msg[]" class="form-control" value="{{ $data->getSData($l['id'],'rating_msg') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Botón</label>
<input type="text" name="rating_button[]" class="form-control" value="{{ $data->getSData($l['id'],'rating_button') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Sobre nosotros Título</label>
<input type="text" name="about_title[]" class="form-control" value="{{ $data->getSData($l['id'],'about_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Cómo funciona el título</label>
<input type="text" name="how_title[]" class="form-control" value="{{ $data->getSData($l['id'],'how_title') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título de preguntas frecuentes</label>
<input type="text" name="faq_title[]" class="form-control" value="{{ $data->getSData($l['id'],'faq_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Título del contacto</label>
<input type="text" name="contact_title[]" class="form-control" value="{{ $data->getSData($l['id'],'contact_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Idioma</label>
<input type="text" name="language[]" class="form-control" value="{{ $data->getSData($l['id'],'language') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Casa</label>
<input type="text" name="home[]" class="form-control" value="{{ $data->getSData($l['id'],'home') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Ciudad</label>
<input type="text" name="city[]" class="form-control" value="{{ $data->getSData($l['id'],'city') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Cuenta</label>
<input type="text" name="account[]" class="form-control" value="{{ $data->getSData($l['id'],'account') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Orden</label>
<input type="text" name="order[]" class="form-control" value="{{ $data->getSData($l['id'],'order') }}">
</div>

</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>Aplicación de entrega</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">No se encontró orden</label>
<input type="text" name="d_no_order[]" class="form-control" value="{{ $data->getSData($l['id'],'d_no_order') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Nuevos pedidos</label>
<input type="text" name="d_new_order[]" class="form-control" value="{{ $data->getSData($l['id'],'d_new_order') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Ver Detalle</label>
<input type="text" name="d_view_detail[]" class="form-control" value="{{ $data->getSData($l['id'],'d_view_detail') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Usuario</label>
<input type="text" name="d_user[]" class="form-control" value="{{ $data->getSData($l['id'],'d_user') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Teléfono</label>
<input type="text" name="d_phone[]" class="form-control" value="{{ $data->getSData($l['id'],'d_phone') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Dirección</label>
<input type="text" name="d_address[]" class="form-control" value="{{ $data->getSData($l['id'],'d_address') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Comenzar paseo</label>
<input type="text" name="d_start_ride[]" class="form-control" value="{{ $data->getSData($l['id'],'d_start_ride') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Paseo completo</label>
<input type="text" name="d_complete_ride[]" class="form-control" value="{{ $data->getSData($l['id'],'d_complete_ride') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Cantidad total</label>
<input type="text" name="d_total_amount[]" class="form-control" value="{{ $data->getSData($l['id'],'d_total_amount') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Método de pago</label>
<input type="text" name="d_pay[]" class="form-control" value="{{ $data->getSData($l['id'],'d_pay') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Tienda Cerrar</label>
<input type="text" name="close[]" class="form-control" value="{{ $data->getSData($l['id'],'close') }}">
</div>
</div>

</div>
</div>
<!--End-->

<!--start-->
<h4>App de tienda</h4>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Orden total</label>
<input type="text" name="s_total_order[]" class="form-control" value="{{ $data->getSData($l['id'],'s_total_order') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Órdenes completadas</label>
<input type="text" name="s_complete_order[]" class="form-control" value="{{ $data->getSData($l['id'],'s_complete_order') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Nuevos pedidos</label>
<input type="text" name="s_new_order[]" class="form-control" value="{{ $data->getSData($l['id'],'s_new_order') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Nuevo estado del pedido</label>
<input type="text" name="s_new_status[]" class="form-control" value="{{ $data->getSData($l['id'],'s_new_status') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Estado confirmado</label>
<input type="text" name="s_confirm_order[]" class="form-control" value="{{ $data->getSData($l['id'],'s_confirm_order') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Estado de asignación de entrega</label>
<input type="text" name="s_assign_status[]" class="form-control" value="{{ $data->getSData($l['id'],'s_assign_status') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Fuera de estado de entrega</label>
<input type="text" name="s_out_delivery_status[]" class="form-control" value="{{ $data->getSData($l['id'],'s_out_delivery_status') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Estado completo</label>
<input type="text" name="s_complete_status[]" class="form-control" value="{{ $data->getSData($l['id'],'s_complete_status') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Título del detalle del pedido</label>
<input type="text" name="s_detail_title[]" class="form-control" value="{{ $data->getSData($l['id'],'s_detail_title') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Título del elemento del menú</label>
<input type="text" name="s_menu_title[]" class="form-control" value="{{ $data->getSData($l['id'],'s_menu_title') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Resumen de pedidos</label>
<input type="text" name="s_order_overview[]" class="form-control" value="{{ $data->getSData($l['id'],'s_order_overview') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Orden completa</label>
<input type="text" name="s_c_order[]" class="form-control" value="{{ $data->getSData($l['id'],'s_c_order') }}">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
<label for="inputEmail6">Botón de cancelar pedido</label>
<input type="text" name="s_cancel_button[]" class="form-control" value="{{ $data->getSData($l['id'],'s_cancel_button') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Botón de confirmación de pedido</label>
<input type="text" name="s_confirm_button[]" class="form-control" value="{{ $data->getSData($l['id'],'s_confirm_button') }}">
</div>

<div class="form-group col-md-4">
<label for="inputEmail6">Asignar entrega</label>
<input type="text" name="s_assign_button[]" class="form-control" value="{{ $data->getSData($l['id'],'s_assign_button') }}">
</div>
</div>

</div>
</div>

</div>
@endforeach

</div>

<button type="submit" class="btn btn-success btn-cta">Guardar cambios</button><br><br>
