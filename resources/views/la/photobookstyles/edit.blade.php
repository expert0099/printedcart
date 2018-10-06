@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/photobookstyles') }}">PhotoBookStyle</a> :
@endsection
@section("contentheader_description", $photobookstyle->$view_col)
@section("section", "PhotoBookStyles")
@section("section_url", url(config('laraadmin.adminRoute') . '/photobookstyles'))
@section("sub_section", "Edit")

@section("htmlheader_title", "PhotoBookStyles Edit : ".$photobookstyle->$view_col)

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
				{!! Form::model($photobookstyle, ['route' => [config('laraadmin.adminRoute') . '.photobookstyles.update', $photobookstyle->id ], 'method'=>'PUT', 'id' => 'photobookstyle-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'photo_book_style')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/photobookstyles') }}">Cancel</a></button>
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
	$("#photobookstyle-edit-form").validate({
		
	});
});
</script>
@endpush
