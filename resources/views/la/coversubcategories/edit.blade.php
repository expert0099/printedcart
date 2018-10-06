@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/coversubcategories') }}">CoverSubCategory</a> :
@endsection
@section("contentheader_description", $coversubcategory->$view_col)
@section("section", "CoverSubCategories")
@section("section_url", url(config('laraadmin.adminRoute') . '/coversubcategories'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CoverSubCategories Edit : ".$coversubcategory->$view_col)

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
				{!! Form::model($coversubcategory, ['route' => [config('laraadmin.adminRoute') . '.coversubcategories.update', $coversubcategory->id ], 'method'=>'PUT', 'id' => 'coversubcategory-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'cover_sub_category')
					@la_input($module, 'cover_category_id')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/coversubcategories') }}">Cancel</a></button>
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
	$("#coversubcategory-edit-form").validate({
		
	});
});
</script>
@endpush
