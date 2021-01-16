
<br>
<br>
<br>
<div class="tab-content" id="myTabContent1">
@php($i = 0)
@foreach(DB::table('language')->orderBy('sort_no','ASC')->get() as $l)
@php($i++)

<div class="tab-pane fade show" id="lang{{ $l->id }}" role="tabpanel" aria-labelledby="lang{{ $l->id }}-tab">

<input type="hidden" name="lid[]" value="{{ $l->id }}">

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Sobre nosotros</label>
<textarea id="desc{{ $i }}" name="l_about_us[]">{!! $data->getSData($data->s_data,$l->id,0) !!}</textarea>
</div>
</div>

</div>
</div>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Cómo funciona</label>
<textarea id="how{{ $i }}" name="l_how[]">{!! $data->getSData($data->s_data,$l->id,1) !!}</textarea>
</div>
</div>

</div>
</div>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Preguntas frecuentes</label>
<textarea id="faq{{ $i }}" name="l_faq[]">{!! $data->getSData($data->s_data,$l->id,2) !!}</textarea>
</div>
</div>

</div>
</div>

<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Contacta con nosotros</label>
<textarea id="con{{ $i }}" name="l_contact_us[]">{!! $data->getSData($data->s_data,$l->id,3) !!}</textarea>
</div>
</div>

</div>
</div>

</div>
@endforeach

<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

<h4>Sobre nosotros página</h4>
<div class="card py-3 m-b-30">
<div class="card-body">
<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Descripción</label>
<textarea id="summernote" name="about_us">{!! $data->about_us !!}</textarea>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Imagen</label>
<input type="file" name="about_img" class="form-control">

@if($data->about_img)

<br><img src="{{ Asset('upload/page/'.$data->about_img) }}" height="60">

<a href="{{ Asset($form_url.'/add?remove=about_img') }}" onclick="return confirm('Are you sure?')" style="color:red">Eliminar</a>

@endif

</div>
</div>

</div>
</div>

<h4>Cómo funciona</h4>
<div class="card py-3 m-b-30">
<div class="card-body">
<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Descripción</label>
<textarea id="summernote2" name="how">{!! $data->how !!}</textarea>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Imagen</label>
<input type="file" name="how_img" class="form-control" @if(!$data->id) required="required" @endif>

@if($data->how_img)

<br><img src="{{ Asset('upload/page/'.$data->how_img) }}" height="60">

<a href="{{ Asset($form_url.'/add?remove=how_img') }}" onclick="return confirm('Are you sure?')" style="color:red">Eliminar</a>

@endif

</div>
</div>

</div>
</div>

<h4>Preguntas frecuentes</h4>
<div class="card py-3 m-b-30">
<div class="card-body">
<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Descripción</label>
<textarea id="summernote3" name="faq">{!! $data->faq !!}</textarea>
</div>
</div>

</div>
</div>

<h4>Contacta con nosotros</h4>
<div class="card py-3 m-b-30">
<div class="card-body">
<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">Descripción</label>
<textarea id="summernote4" name="contact_us">{!! $data->contact_us !!}</textarea>
</div>
</div>

</div>
</div>
</div>
</div>

<button type="submit" class="btn btn-success btn-cta">Guardar cambios</button><br><br>
