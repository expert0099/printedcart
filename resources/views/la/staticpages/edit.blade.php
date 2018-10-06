@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/staticpages') }}">StaticPage</a> :
@endsection
@section("contentheader_description", $staticpage->$view_col)
@section("section", "StaticPages")
@section("section_url", url(config('laraadmin.adminRoute') . '/staticpages'))
@section("sub_section", "Edit")

@section("htmlheader_title", "StaticPages Edit : ".$staticpage->$view_col)

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
				{!! Form::model($staticpage, ['route' => [config('laraadmin.adminRoute') . '.staticpages.update', $staticpage->id ], 'method'=>'PUT', 'id' => 'staticpage-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'page_name')
					@la_input($module, 'page_slug')
					@la_input($module, 'page_content')
					@la_input($module, 'isActive')
					@la_input($module, 'page_group')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/staticpages') }}">Cancel</a></button>
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
	$("#staticpage-edit-form").validate({
		
	});
});
</script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
	$('textarea[name=page_content]').ckeditor();
	//$('.textarea').ckeditor(); // if class is prefered.
</script>
@endpush
