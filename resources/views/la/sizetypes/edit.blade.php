@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/sizetypes') }}">SizeType</a> :
@endsection
@section("contentheader_description", $sizetype->$view_col)
@section("section", "SizeTypes")
@section("section_url", url(config('laraadmin.adminRoute') . '/sizetypes'))
@section("sub_section", "Edit")

@section("htmlheader_title", "SizeTypes Edit : ".$sizetype->$view_col)

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
				{!! Form::model($sizetype, ['route' => [config('laraadmin.adminRoute') . '.sizetypes.update', $sizetype->id ], 'method'=>'PUT', 'id' => 'sizetype-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'sizetype')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/sizetypes') }}">Cancel</a></button>
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
	$("#sizetype-edit-form").validate({
		
	});
});
</script>
@endpush
