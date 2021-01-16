<div class="card py-3 m-b-30">
<div class="card-body">

<h4>Detalle de usuario</h4><br>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Seleccionar tienda</label>
<select name="store_id" class="form-control" required="required" id="store_id">
<option value="">Seleccione</option>
@foreach($users as $u)
<option value="{{ $u->id }}" {{ isset($store_id) && $u->id === $store_id ? 'selected' : '' }}>
    {{ $u->name }}</option>
@endforeach
</select>
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Teléfono</label>
{!! Form::text('phone',$data->phone,['id' => 'code','required' => 'required','class' => 'form-control','onchange' => 'getUser(this.value)'])!!}
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Nombre de usuario</label>
{!! Form::text('name',$data->name,['id' => 'name','required' => 'required','class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Dirección</label>
{!! Form::text('address',$data->address,['id' => 'address','required' => 'required','class' => 'form-control'])!!}
</div>
</div>
</div>
</div>

<div class="card py-3 m-b-30">
<div class="card-body">

<h4>Detalles del pedido</h4><br>

@if($data->id)

@include('admin.order.item')

@endif

<span id="item"></span>

<br>
<button type="button" class="btn btn-info" onClick="AddMore();">Añadir artículo</button>

</div>
</div>

<div class="card py-3 m-b-30">
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="inputEmail6">Seleccione cupon de descuento</label>
                <select name="offer_id" class="form-control" id="offer_id" disabled="disabled">
                    <option id="optDef">...</option>
                </select>
            </div>
        </div>
    </div>

    <button type="button" id="btnOffers" class="btn btn-success btn-cta" onclick="getAvailableOffers()">Cargar cupones disponibles</button>

</div>

<button type="submit" class="btn btn-success btn-cta">Guardar Orden</button>

<SCRIPT>

function getUser(id)
{

var xmlhttp;
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
	xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
	var t = JSON.parse(xmlhttp.responseText);

	if(t.name)
	{
		document.getElementById("name").value=t.name;
	}

	if(t.address)
	{
		document.getElementById("address").value=t.address;
	}
}
}
	xmlhttp.open("GET","{{ Asset(env('admin').'/getUser') }}/"+id,true);
	xmlhttp.send();
}

function AddMore() {

    var sid = document.getElementById("store_id").value;

	$("<DIV>").load("{{ Asset(env('admin').'/orderItem?store_id=') }}"+sid, function() {

	$("#item").append($(this).html());

	});


}
function Remove(id) {
	$(id).remove();
}

function getAvailableOffers(){

    var store_id = $("#store_id").val();

    var items_id=[];
    $('select[name="item_id[]"] option:selected').each(function() {
        items_id.push($(this).val());
    });

    var size=[];
    $('select[name="unit[]"]').each(function() {
        size.push($(this).val());
    });

    var qty=[];
    $('input[name="qty[]"]').each(function() {
        qty.push($(this).val());
    });

    var items = items_id.map(function(v, i) {
        return {
            id: v,
            size: size[i],
            qty: qty[i]
        };
    });


    $.ajax({
        url: '/admin/order/getAvailableOffers',
        type:"GET",
        data: {
            items: items,
            store_id: store_id
        },
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        dataType: 'json',
        success:function(response){

            var offers = response.data;

            $.each(offers, function( i, v ){
                console.log(v.description);
                $("#offer_id")
                    .append('<option value='+ v.offer_id +'>' + v.code + '</option>');
            });

            $("#offer_id").prop( "disabled", false );
            $("#optDef").text('Seleccione').prop("disabled", true);
        },
    });
}

</SCRIPT>
<br>
