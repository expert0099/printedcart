@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/sizes') }}">Size</a> :
@endsection
@section("contentheader_description", $size->$view_col)
@section("section", "Sizes")
@section("section_url", url(config('laraadmin.adminRoute') . '/sizes'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Sizes Edit : ".$size->$view_col)

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
				{!! Form::model($size, ['route' => [config('laraadmin.adminRoute') . '.sizes.update', $size->id ], 'method'=>'PUT', 'id' => 'size-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'sizegroup')
					@la_input($module, 'size')
					@la_input($module, 'price')
					@la_input($module, 'currency')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/sizes') }}">Cancel</a></button>
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
	$("#size-edit-form").validate({
		
	});
});
</script>
@endpush
