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
<label for="asd">@lang('admin.Name')</label>
{!! Form::text('l_name[]',$data->getSData($data->s_data,$l->id,0),['placeholder' => @lang('admin.Name'),'class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="asd">@lang('admin.Address')</label>
{!! Form::text('l_address[]',$data->getSData($data->s_data,$l->id,1),['placeholder' => @lang("admin.Store Address"),'class' => 'form-control'])!!}
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
<label for="inputEmail6">@lang('admin.Name')</label>
{!! Form::text('name',null,['required' => 'required','placeholder' => @lang("admin.Name"),'class' => 'form-control'])!!}
</div>
<div class="form-group col-md-6">
<label for="inputEmail4">Correo electrónico (<i>@lang('admin.This will be username')</i>)</label>
{!! Form::email('email',null,['required' => 'required','placeholder' => @lang('admin.Email Address'),'class' => 'form-control'])!!}
</div>
</div>

<div class="form-row">
<div class="form-group col-md-3">
<label for="inputEmail6">@lang('admin.Phone')</label>
{!! Form::text('phone',null,['required' => 'required','placeholder' => @lang('admin.Contact Number'),'class' => 'form-control'])!!}
</div>

<div class="form-group col-md-3">
<label for="inputEmail4">@lang('admin.Store Type')</label>
<select name="store_type" class="form-control" required="required">
<option value="">@lang('admin.Select')</option>
@foreach($types as $type)
<option value="{{ trim($type) }}" @if($data->type == trim($type)) selected @endif>{{ trim($type) }}</option>
@endforeach
</select>
</div>

<div class="form-group col-md-6">
<label for="inputEmail4">@lang('admin.City')</label>
<select name="city_id" class="form-control" required="required">
<option value="">@lang('admin.Select City')</option>
@foreach($citys as $city)
<option value="{{ $city->id }}" @if($data->city_id == $city->id) selected @endif>{{ $city->name }}</option>
@endforeach
</select>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Address')</label>
{!! Form::text('address',null,['required' => 'required','placeholder' => @lang('admin.Full Address'),'class' => 'form-control'])!!}
</div>
<div class="form-group col-md-6">
<label for="inputEmail4">@lang('admin.Image') (@lang('admin.recommended size') 600 * 400)</label>
<input type="file" name="img" class="form-control" @if(!$data->id) required="required" @endif>
</div>
</div>

@if(isset($type))

<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">@lang('admin.Change Password') (<i>@lang('admin.Enter new password if you want to change current password').</i>)</label>
<input type="Password" name="password" class="form-control">
</div>
</div>

@else

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Password')</label>
<input type="Password" name="password" class="form-control" @if(!$data->id) required="required" @endif>
</div>

<div class="form-group col-md-6">
<label for="inputEmail4">@lang('admin.Status')</label>
<select name="status" class="form-control">
<option value="0" @if($data->status == 0) selected @endif>@lang('admin.Active')</option>
<option value="1" @if($data->status == 1) selected @endif>@lang('admin.Disbaled')</option>
</select>
</div>
</div>
@endif

@if($data->img)

<img src="{{ Asset('upload/user/'.$data->img) }}" width="50px"><br><br>

@endif

</div>
</div>

<h1 style="font-size: 20px">@lang('admin.Delivery Charges & Timing')</h1>
<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Min Cart Value')</label>
{!! Form::text('min_cart_value',null,['placeholder' => @lang('admin.After this amount delivery will be free'),'class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Delivery Charges')</label>
{!! Form::number('delivery_charges_value',null,['class' => 'form-control'])!!}
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Opening Time')</label>
<select name="opening_time" class="form-control">
<option>@lang('admin.Select')</option>
@php($ot = 0)

@while($ot < 23)

@php($ot++)

<option value="{{ $ot }}" @if($data->opening_time == $ot) selected @endif>{{ $ot }}</option>
<option value="{{ $ot.":30" }}" @if($data->opening_time == $ot.':30') selected @endif> {{ $ot }}:30</option>

@endwhile
<option value="00" @if($data->opening_time == '00') selected @endif>00</option>
</select>
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Closing Time')</label>
<select name="closing_time" class="form-control">
<option>@lang('admin.Select')</option>
@php($ct = 0)

@while($ct < 23)

@php($ct++)

<option value="{{ $ct }}" @if($data->closing_time == $ct) selected @endif>{{ $ct }}</option>
<option value="{{ $ct.":30" }}" @if($data->closing_time == $ct.":30") selected @endif>{{ $ct }}:30</option>

@endwhile
<option value="00" @if($data->closing_time == '00') selected @endif>00</option>
</select>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Estimated Delivery Time') <small>(@lang('admin.only in minutes'))</small></label>
{!! Form::text('delivery_time',null,['placeholder' => 'e.g 20-25','class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Approx Per Person Cost') <small>(@lang('admin.Approx do not include any currency sign'))</small></label>
{!! Form::text('person_cost',null,['placeholder' => 'e.g 200-250','class' => 'form-control'])!!}
</div>
</div>
</div>
</div>

<h1 style="font-size: 20px">@lang('admin.Additional Images')</h1>
<div class="card py-3 m-b-30">
<div class="card-body">

<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail4">@lang('admin.Select Images') (@lang('admin.for multiple select with CTRl'))</label>
<input type="file" name="gallery[]" class="form-control" multiple="true">
</div>
</div>

@if(isset($images))
<div class="form-row">
@foreach($images as $img)
<div class="form-group col-md-2">
<img src="{{ Asset('upload/user/gallery/'.$img->img) }}" width="50%"><br>
<a href="{{ Asset(env('admin').'/imageRemove/'.$img->id) }}" onclick="return confirm('Are you sure?')" style="color:Red">@lang('admin.Remove')</a>
</div>
@endforeach
</div>
@endif

</div>
</div>
<h3 style="font-size: 20px;">@lang('admin.Select Location From Google Map') <small>(@lang('admin.For search according location in app'))</small></h3>
<div class="card py-3 m-b-30">
<div class="card-body">

@include('admin.user.google')

</div>
</div>
</div>
</div>
<button type="submit" class="btn btn-success btn-cta">@lang('admin.Save changes')</button><br><br>
