
<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Name')</label>
{!! Form::text('name',null,['id' => 'code','required' => 'required','class' => 'form-control'])!!}
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Type')</label>
<select name="type" class="form-control">
	<option value="0" @if($data->type == 0) selected @endif>@lang('admin.Left to Right')</option>
	<option value="1" @if($data->type == 1) selected @endif>@lang('admin.Right to Left')</option>
</select>
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.ICON') <small>(512x512)</small></label>
<input type="file" name="img" class="form-control">
</div>

<div class="form-group col-md-6">
<label for="inputEmail6">@lang('admin.Sort No')</label>
{!! Form::number('sort_no',null,['id' => 'code','class' => 'form-control'])!!}
</div>
</div>

<button type="submit" class="btn btn-success btn-cta">@lang('admin.Save changes')</button>
