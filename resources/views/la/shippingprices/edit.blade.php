@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/shippingprices') }}">ShippingPrice</a> :
@endsection
@section("contentheader_description", $shippingprice->$view_col)
@section("section", "ShippingPrices")
@section("section_url", url(config('laraadmin.adminRoute') . '/shippingprices'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ShippingPrices Edit : ".$shippingprice->$view_col)

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
				{!! Form::model($shippingprice, ['route' => [config('laraadmin.adminRoute') . '.shippingprices.update', $shippingprice->id ], 'method'=>'PUT', 'id' => 'shippingprice-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'shipping_category_id')
					@la_input($module, 'size_group_id')
					@la_input($module, 'qty_min')
					@la_input($module, 'qty_max')
					@la_input($module, 'price')
					@la_input($module, 'inc_price')
					@la_input($module, 'size_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/shippingprices') }}">Cancel</a></button>
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
	$("#shippingprice-edit-form").validate({
		
	});
});
</script>
@endpush
