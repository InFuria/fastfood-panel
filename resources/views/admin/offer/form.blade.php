<div class="card py-3 m-b-30">
<div class="card-body">
@include('admin.language.header')
</div>
</div>

<div class="tab-content" id="myTabContent1">

@foreach(DB::table('language')->orderBy('sort_no','ASC')->get() as $l)

<div class="tab-pane fade show" id="lang{{ $l->id }}" role="tabpanel" aria-labelledby="lang{{ $l->id }}-tab">

<input type="hidden" name="lid[]" value="{{ $l->id }}">

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-6">
<label for="asd">Código del cupón</label>
{!! Form::text('l_code[]',$data->getSData($data->s_data,$l->id,0),['placeholder' => 'Code','class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="asd">Descripción</label>
{!! Form::text('l_desc[]',$data->getSData($data->s_data,$l->id,1),['placeholder' => 'Description','class' => 'form-control'])!!}
</div>
</div>

</div>
</div>

</div>
@endforeach

<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Código del cupón</label>
{!! Form::text('code',null,['id' => 'code','class' => 'form-control','required' => 'required'])!!}
</div>
<div class="form-group col-md-6">
<label for="inputEmail6">Descripción</label>
{!! Form::text('description',null,['id' => 'code','class' => 'form-control','required' => 'required'])!!}
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Valor mínimo del carrito <small>(Opcional)</small></label>
{!! Form::number('min_cart_value',null,['id' => 'code','class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Tipo de descuento</label>
<select name="type" class="form-control">
	<option value="0" @if($data->type == 0) selected @endif>en %</option>
	<option value="1" @if($data->type == 1) selected @endif>Cantidad fija</option>
</select>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-3">
<label for="inputEmail6">Valor de descuento</label>
{!! Form::number('value',null,['id' => 'code','class' => 'form-control','required' => 'required'])!!}
</div>

<div class="form-group col-md-3">
<label for="inputEmail6">Descuento hasta <small>(Opcional)</small></label>
{!! Form::number('upto',null,['id' => 'code','class' => 'form-control',])!!}
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Estado</label>
<select name="status" class="form-control">
	<option value="0" @if($data->status == 0) selected @endif>Activo</option>
	<option value="1" @if($data->status == 1) selected @endif>Deshabilitado</option>
</select>
</div>
</div>


<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Seleccionar tienda</label>
<select id="store" name="store[]" class="form-control js-select2" multiple="true">
<option value="-1">Toda la tienda</option>
@foreach($users as $user)
<option value="{{ $user->id }}" @if(in_array($user->id,$array)) selected @endif>{{ $user->name }}</option>
@endforeach
</select>
</div>
</div>
</div>
</div>
</div>
</div>

<button type="submit" class="btn btn-success btn-cta">Guardar cambios</button>
<button type="button" class="btn btn-success btn-cta" onclick="resetStores()">Reiniciar tiendas</button>
<hr/>
