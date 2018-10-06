@extends('la.layouts.app')

@section('htmlheader_title')
	PromoCode View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $promocode->$view_col }}</h4>
				</div>
			</div>
		</div>
		
		
		<div class="col-md-1 actions">
			@la_access("PromoCodes", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/promocodes/'.$promocode->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("PromoCodes", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.promocodes.destroy', $promocode->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/promocodes') }}" data-toggle="tooltip" data-placement="right" title="Back to PromoCodes"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>General Info</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'coupon_flag')
						@la_display($module, 'coupon_count')
						<div class="form-group">
							<label for="coupon" class="col-md-2">Coupons :</label>
							<div class="col-md-10 fvalue">{!! $coupon !!}</div>
						</div>
						@la_display($module, 'end_date')
						@la_display($module, 'amount_limit')
						@la_display($module, 'saving_type')
						
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
</div>
@endsection
