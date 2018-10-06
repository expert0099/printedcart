@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/photobooklayouts') }}">PhotoBookLayout</a> :
@endsection
@section("contentheader_description", $photobooklayout->$view_col)
@section("section", "PhotoBookLayouts")
@section("section_url", url(config('laraadmin.adminRoute') . '/photobooklayouts'))
@section("sub_section", "Edit")

@section("htmlheader_title", "PhotoBookLayouts Edit : ".$photobooklayout->$view_col)

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
				{!! Form::model($photobooklayout, ['route' => [config('laraadmin.adminRoute') . '.photobooklayouts.update', $photobooklayout->id ], 'method'=>'PUT', 'id' => 'photobooklayout-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'photo_book_id')
					@la_input($module, 'layout_image')
					@la_input($module, 'content_page')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/photobooklayouts') }}">Cancel</a></button>
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
	$("#photobooklayout-edit-form").validate({
		
	});
});
</script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
$('textarea[name=content_page]').ckeditor();
</script>
@endpush
