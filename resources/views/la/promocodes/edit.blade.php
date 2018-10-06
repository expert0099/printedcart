@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/promocodes') }}">PromoCode</a> :
@endsection
@section("contentheader_description", $promocode->$view_col)
@section("section", "PromoCodes")
@section("section_url", url(config('laraadmin.adminRoute') . '/promocodes'))
@section("sub_section", "Edit")

@section("htmlheader_title", "PromoCodes Edit : ".$promocode->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($promocode, ['route' => [config('laraadmin.adminRoute') . '.promocodes.update', $promocode->id ], 'method'=>'PUT', 'id' => 'promocode-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'coupon_flag')
					@la_input($module, 'coupon_count')
					@la_input($module, 'end_date')
					@la_input($module, 'amount_limit')
					@la_input($module, 'saving_type')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/promocodes') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#promocode-edit-form").validate({
		
	});
});
</script>
@endpush
