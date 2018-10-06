@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/covercategories') }}">CoverCategory</a> :
@endsection
@section("contentheader_description", $covercategory->$view_col)
@section("section", "CoverCategories")
@section("section_url", url(config('laraadmin.adminRoute') . '/covercategories'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CoverCategories Edit : ".$covercategory->$view_col)

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
				{!! Form::model($covercategory, ['route' => [config('laraadmin.adminRoute') . '.covercategories.update', $covercategory->id ], 'method'=>'PUT', 'id' => 'covercategory-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'cover_category')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/covercategories') }}">Cancel</a></button>
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
	$("#covercategory-edit-form").validate({
		
	});
});
</script>
@endpush
