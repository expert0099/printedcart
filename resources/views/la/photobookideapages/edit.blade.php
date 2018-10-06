@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/photobookideapages') }}">PhotoBookIdeaPage</a> :
@endsection
@section("contentheader_description", $photobookideapage->$view_col)
@section("section", "PhotoBookIdeaPages")
@section("section_url", url(config('laraadmin.adminRoute') . '/photobookideapages'))
@section("sub_section", "Edit")

@section("htmlheader_title", "PhotoBookIdeaPages Edit : ".$photobookideapage->$view_col)

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
				{!! Form::model($photobookideapage, ['route' => [config('laraadmin.adminRoute') . '.photobookideapages.update', $photobookideapage->id ], 'method'=>'PUT', 'id' => 'photobookideapage-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'photo_book_id')
					@la_input($module, 'idea_pages')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/photobookideapages') }}">Cancel</a></button>
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
	$("#photobookideapage-edit-form").validate({
		
	});
});
</script>
@endpush
