
<div class="form-row">
<div class="form-group col-md-12">
<label for="inputEmail6">@lang('admin.Select City')</label>
<select name="city_id" class="form-control">
<option value="">@lang('admin.All City')</option>
@foreach($citys as $city)
<option value="{{ $city->id }}" @if($data->city_id == $city->id) selected @endif>{{ $city->name }}</option>
@endforeach
</select>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Banner Position')</label>
<select name="position" class="form-control" required="required">
<option value="">@lang('admin.Select')</option>
<option value="0" @if($data->position == 0) selected @endif>@lang('admin.Top') (1024 * 1024)</option>
<option value="2" @if($data->position == 2) selected @endif>@lang('admin.Bottom') (600*300)</option>
</select>
</div>
<div class="form-group col-md-6">
<label for="inputEmail4">@lang('admin.Select Restaurants <small>(These selected store will list up on banner click)')</small></label>
<select name="store[]" class="form-control js-select2" multiple>
<option value="">@lang('admin.All')</option>
@foreach($users as $user)
<option value="{{ $user->id }}" @if(isset($array) && in_array($user->id,$array)) selected @endif>{{ $user->name }}</option>
@endforeach
</select>
</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Image')</label>
<input type="file" name="img" class="form-control" @if(!$data->id) required="required" @endif>
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Status')</label>
<select name="status" class="form-control" required="required">
<option value="0" @if($data->status == 0) selected @endif>@lang('admin.Active')</option>
<option value="1" @if($data->status == 1) selected @endif>@lang('admin.Disabled')</option>
</select>
</div>
</div>

@if($data->id)

<img src="{{ Asset('upload/banner/'.$data->img) }}" height="100"><br><br>

@endif

<button type="submit" class="btn btn-success btn-cta">@lang('admin.Save changes')</button>


