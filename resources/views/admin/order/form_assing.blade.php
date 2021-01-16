<div class="card py-3 m-b-30">
<div class="card-body">

<h4>Asignar Delivery</h4><br>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Seleccionar Ciudad</label>
<select name="cd_id" class="form-control" required="required" id="cd_id" >
<option value="">Seleccione</option>
@foreach($city as $c)
<option value="{{ $c->id }}">{{ $c->name }}</option>
@endforeach
</select>
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Seleccionar Delivery</label>

<select name="delivery_id" class="form-control" required="required" id="delivery_id">
<option value="">Seleccione</option>
</select>

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


<button type="submit" class="btn btn-success btn-cta">Guardar cambios</button>
<br>


