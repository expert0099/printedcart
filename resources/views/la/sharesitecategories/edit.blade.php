@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/sharesitecategories') }}">ShareSiteCategory</a> :
@endsection
@section("contentheader_description", $sharesitecategory->$view_col)
@section("section", "ShareSiteCategories")
@section("section_url", url(config('laraadmin.adminRoute') . '/sharesitecategories'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ShareSiteCategories Edit : ".$sharesitecategory->$view_col)

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
				{!! Form::model($sharesitecategory, ['route' => [config('laraadmin.adminRoute') . '.sharesitecategories.update', $sharesitecategory->id ], 'method'=>'PUT', 'id' => 'sharesitecategory-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'title')
					@la_input($module, 'photo')
					@la_input($module, 'description')
					@la_input($module, 'features')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/sharesitecategories') }}">Cancel</a></button>
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
	$("#sharesitecategory-edit-form").validate({
		
	});
});
</script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
	$('textarea[name=features]').ckeditor();
</script>
@endpush
