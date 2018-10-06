@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/photobookbackgrounds') }}">PhotoBookBackground</a> :
@endsection
@section("contentheader_description", $photobookbackground->$view_col)
@section("section", "PhotoBookBackgrounds")
@section("section_url", url(config('laraadmin.adminRoute') . '/photobookbackgrounds'))
@section("sub_section", "Edit")

@section("htmlheader_title", "PhotoBookBackgrounds Edit : ".$photobookbackground->$view_col)

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
				{!! Form::model($photobookbackground, ['route' => [config('laraadmin.adminRoute') . '.photobookbackgrounds.update', $photobookbackground->id ], 'method'=>'PUT', 'id' => 'photobookbackground-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'photo_book_id')
					@la_input($module, 'background_image')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/photobookbackgrounds') }}">Cancel</a></button>
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
	$("#photobookbackground-edit-form").validate({
		
	});
});
</script>
@endpush
