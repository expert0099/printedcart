@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/calendarcategories') }}">CalendarCategory</a> :
@endsection
@section("contentheader_description", $calendarcategory->$view_col)
@section("section", "CalendarCategories")
@section("section_url", url(config('laraadmin.adminRoute') . '/calendarcategories'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CalendarCategories Edit : ".$calendarcategory->$view_col)

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
				{!! Form::model($calendarcategory, ['route' => [config('laraadmin.adminRoute') . '.calendarcategories.update', $calendarcategory->id ], 'method'=>'PUT', 'id' => 'calendarcategory-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'calendar_category')
					@la_input($module, 'calendar_image')
					@la_input($module, 'content')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/calendarcategories') }}">Cancel</a></button>
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
	$("#calendarcategory-edit-form").validate({
		
	});
});
</script>
@endpush
