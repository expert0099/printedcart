@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/sizegroups') }}">SizeGroup</a> :
@endsection
@section("contentheader_description", $sizegroup->$view_col)
@section("section", "SizeGroups")
@section("section_url", url(config('laraadmin.adminRoute') . '/sizegroups'))
@section("sub_section", "Edit")

@section("htmlheader_title", "SizeGroups Edit : ".$sizegroup->$view_col)

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
				{!! Form::model($sizegroup, ['route' => [config('laraadmin.adminRoute') . '.sizegroups.update', $sizegroup->id ], 'method'=>'PUT', 'id' => 'sizegroup-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'sizegroup')
					@la_input($module, 'photo')
					@la_input($module, 'content')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/sizegroups') }}">Cancel</a></button>
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
	/* $("#sizegroup-edit-form").validate({
		
	}); */
});
</script>
@endpush
