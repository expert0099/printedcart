@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/photobooks') }}">PhotoBook</a> :
@endsection
@section("contentheader_description", $photobook->$view_col)
@section("section", "PhotoBooks")
@section("section_url", url(config('laraadmin.adminRoute') . '/photobooks'))
@section("sub_section", "Edit")

@section("htmlheader_title", "PhotoBooks Edit : ".$photobook->$view_col)

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
				{!! Form::model($photobook, ['route' => [config('laraadmin.adminRoute') . '.photobooks.update', $photobook->id ], 'method'=>'PUT', 'id' => 'photobook-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'photo_book')
					@la_input($module, 'photo_book_style_id')
					@la_input($module, 'thumb_left')
					@la_input($module, 'thumb_right')
					@la_input($module, 'storytelling')
					@la_input($module, 'standard')
					@la_input($module, 'content')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/photobooks') }}">Cancel</a></button>
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
	$("#photobook-edit-form").validate({
		
	});
});
</script>
@endpush
