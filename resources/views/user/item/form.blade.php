@include('admin.language.header')
<br>
<div class="tab-content" id="myTabContent1">

@foreach(DB::table('language')->orderBy('sort_no','ASC')->get() as $l)

<div class="tab-pane fade show" id="lang{{ $l->id }}" role="tabpanel" aria-labelledby="lang{{ $l->id }}-tab">

<input type="hidden" name="lid[]" value="{{ $l->id }}">


<div class="form-row">
<div class="form-group col-md-6">
<label for="asd">Nombre del árticulo</label>
{!! Form::text('l_name[]',$data->getSData($data->s_data,$l->id,0),['placeholder' => 'Nombre','class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="asd">Descripción</label>
{!! Form::text('l_desc[]',$data->getSData($data->s_data,$l->id,1),['placeholder' => 'Descripción','class' => 'form-control'])!!}
</div>
</div>


</div>
@endforeach

<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Selecciona una categoría</label>
<select name="cate_id" class="form-control" required="required">
<option value="">Seleccione</option>
@foreach($cates as $cate)
<option value="{{ $cate->id }}" @if($data->category_id == $cate->id) selected @endif>{{ $cate->name }}</option>
@endforeach
</select>
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Nombre</label>
{!! Form::text('name',null,['id' => 'code','placeholder' => 'Nombre','class' => 'form-control'])!!}
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Descripción</label>
{!! Form::text('description',null,['id' => 'code','placeholder' => 'Descripción','class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Tipo de artículo</label>
<select name="nonveg" class="form-control">
<option value="0" @if($data->nonveg == 0) selected @endif>Verduras</option>
<option value="1" @if($data->nonveg == 1) selected @endif>No vegetales</option>
</select>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Estado</label>
<select name="status" class="form-control">
	<option value="0" @if($data->status == 0) selected @endif>Activo</option>
	<option value="1" @if($data->status == 1) selected @endif>Deshabilitado</option>
</select>
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Imagen</label>
<input type="file" name="img" class="form-control">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Orden de clasificación</label>
{!! Form::number('sort_no',null,['id' => 'code','class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Cantidad</label>
{!! Form::number('qty',null,['id' => 'code','class' => 'form-control'])!!}
</div>
</div>

<fieldset class="border p-2">
    <legend  class="w-auto">Costo Siik</legend>
    <div class="form-row">
    <div class="form-group col-md-4">
    <label for="inputEmail6">Pequeño precio</label>
    {!! Form::text('small_price',null,['id' => 'code','placeholder' => 'Precio porción pequeña','class' => 'form-control'])!!}
    </div>

    <div class="form-group col-md-4">
    <label for="inputEmail6">Precio medio</label>
    {!! Form::text('medium_price',null,['id' => 'code','placeholder' => 'Precio porción media','class' => 'form-control'])!!}
    </div>

    <div class="form-group col-md-4">
    <label for="inputEmail6">Precio grande / completo</label>
    {!! Form::text('large_price',null,['id' => 'code','placeholder' => 'Precio porción grande / completa','class' => 'form-control'])!!}
    </div>
    </div>
</fieldset>


<fieldset class="border p-2">
    <legend  class="w-auto">Costo Real</legend>
    <div class="form-row">
        <div class="form-group col-md-4">
        <label for="inputEmail6">Pequeño precio</label>
        {!! Form::text('small_price_real',null,['id' => 'code','placeholder' => 'Precio porción pequeña','class' => 'form-control'])!!}
        </div>

        <div class="form-group col-md-4">
        <label for="inputEmail6">Precio medio</label>
        {!! Form::text('medium_price_real',null,['id' => 'code','placeholder' => 'Precio porción media','class' => 'form-control'])!!}
        </div>

        <div class="form-group col-md-4">
        <label for="inputEmail6">Precio grande / completo</label>
        {!! Form::text('large_price_real',null,['id' => 'code','placeholder' => 'Precio porción grande / completa','class' => 'form-control'])!!}
        </div>
        </div>
</fieldset>




</div>
</div>
<button type="submit" class="btn btn-success btn-cta">Guardar cambios</button>
