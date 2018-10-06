@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/sizetypeassigntosizes') }}">SizeTypeAssignToSize</a> :
@endsection
@section("contentheader_description", $sizetypeassigntosize->$view_col)
@section("section", "SizeTypeAssignToSizes")
@section("section_url", url(config('laraadmin.adminRoute') . '/sizetypeassigntosizes'))
@section("sub_section", "Edit")

@section("htmlheader_title", "SizeTypeAssignToSizes Edit : ".$sizetypeassigntosize->$view_col)

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
				{!! Form::model($sizetypeassigntosize, ['route' => [config('laraadmin.adminRoute') . '.sizetypeassigntosizes.update', $sizetypeassigntosize->id ], 'method'=>'PUT', 'id' => 'sizetypeassigntosize-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'sizetype')
					@la_input($module, 'Size')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/sizetypeassigntosizes') }}">Cancel</a></button>
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
	$("#sizetypeassigntosize-edit-form").validate({
		
	});
});
</script>
@endpush
