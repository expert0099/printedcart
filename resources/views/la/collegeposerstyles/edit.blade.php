@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/collegeposerstyles') }}">CollegePoserStyle</a> :
@endsection
@section("contentheader_description", $collegeposerstyle->$view_col)
@section("section", "CollegePoserStyles")
@section("section_url", url(config('laraadmin.adminRoute') . '/collegeposerstyles'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CollegePoserStyles Edit : ".$collegeposerstyle->$view_col)

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
				{!! Form::model($collegeposerstyle, ['route' => [config('laraadmin.adminRoute') . '.collegeposerstyles.update', $collegeposerstyle->id ], 'method'=>'PUT', 'id' => 'collegeposerstyle-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'poster_style')
					@la_input($module, 'photo')
					@la_input($module, 'of_photos')
					@la_input($module, 'disney')
					@la_input($module, 'printedcart')
					@la_input($module, 'design_style')
					@la_input($module, 'design_size')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/collegeposerstyles') }}">Cancel</a></button>
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
	$("#collegeposerstyle-edit-form").validate({
		
	});
});
</script>
@endpush
