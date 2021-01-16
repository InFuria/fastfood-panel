@include('admin.language.header')
<br>

<div class="tab-content" id="myTabContent1">
@foreach(DB::table('language')->orderBy('sort_no','ASC')->get() as $l)
<div class="tab-pane fade show" id="lang{{ $l->id }}" role="tabpanel" aria-labelledby="lang{{ $l->id }}-tab">

<input type="hidden" name="lid[]" value="{{ $l->id }}">

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Nombre</label>
{!! Form::text('l_name[]',$data->getSData($data->s_data,$l->id,'l_name'),['id' => 'code','placeholder' => 'Name','class' => 'form-control'])!!}
</div>
</div>

<input type="hidden" name="test[]" value="{{ $l->id }}">


</div>
@endforeach


<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">Nombre</label>
{!! Form::text('name',null,['id' => 'code','placeholder' => 'Name','class' => 'form-control','required' => 'required'])!!}
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">Precio</label>
{!! Form::text('price',null,['id' => 'code','class' => 'form-control','required' => 'required'])!!}
</div>
</div>
</div>
</div>

<button type="submit" class="btn btn-success btn-cta">Guardar cambios</button>
