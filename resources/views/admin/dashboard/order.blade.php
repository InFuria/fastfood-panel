<div class="row">
<div class="col-lg-12 m-b-30">
<div class="card">
<div class="card-header">
<div class="card-title">@lang('admin.Latest_Orders')</div>

<div class="card-controls">

<a href="#" class="js-card-refresh icon"> </a>

</div>

</div>

<div class="table-responsive">

<table class="table table-hover table-sm ">
<thead>
<tr>
<th>@lang('admin.Order_ID')</th>
<th>@lang('admin.Store')</th>
<th>@lang('admin.User')</th>
<th>@lang('admin.Address')</th>
<th>@lang('admin.Status')</th>
<th>@lang('admin.Order_Time')</th>
<th class="text-center">@lang('admin.Action')</th>
</tr>
</thead>
<tbody>
<tr>

@foreach($orders as $row)

<tr>
<td width="10%">#{{ $row->id }}</td>
<td width="20%">{{ $row->store }}
<br>
@if($row->type == 0)

<small style="color:blue">@lang('admin.Home_Delivery')</small>

@else

<small style="color:green">@lang('admin.Pickup')</small>


@endif
<td width="15%">{{ $row->name }}<br>{{ $row->phone }}</td>
<td width="15%">{{ $row->address }}</td>
<td width="15%">
    {!! $row->getStatus($row->id) !!}

    @if($row->status == 4)
        <label class="badge badge-soft-info badge-light mt-1">
            {!! $row->dboy !!}
        </label>
    @endif
</td>
<td width="15%">{{ date('d-M-Y',strtotime($row->created_at)) }}</td>
<td width="15%">@include('admin.order.action')</td>
@endforeach

</tr>

</tbody>
</table>

</div>

</div>
</div>
</div>
