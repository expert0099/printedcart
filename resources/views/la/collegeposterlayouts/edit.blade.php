@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/collegeposterlayouts') }}">CollegePosterLayout</a> :
@endsection
@section("contentheader_description", $collegeposterlayout->$view_col)
@section("section", "CollegePosterLayouts")
@section("section_url", url(config('laraadmin.adminRoute') . '/collegeposterlayouts'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CollegePosterLayouts Edit : ".$collegeposterlayout->$view_col)

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
				{!! Form::model($collegeposterlayout, ['route' => [config('laraadmin.adminRoute') . '.collegeposterlayouts.update', $collegeposterlayout->id ], 'method'=>'PUT', 'id' => 'collegeposterlayout-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'layout_name')
					@la_input($module, 'layout_image')
					@la_input($module, 'page_content')
					@la_input($module, 'differiciate')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/collegeposterlayouts') }}">Cancel</a></button>
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
	$("#collegeposterlayout-edit-form").validate({
		
	});
});
</script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
$('textarea[name=page_content]').ckeditor();
</script>
@endpush
