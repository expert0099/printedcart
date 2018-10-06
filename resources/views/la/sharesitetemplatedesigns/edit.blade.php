@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/sharesitetemplatedesigns') }}">ShareSiteTemplateDesign</a> :
@endsection
@section("contentheader_description", $sharesitetemplatedesign->$view_col)
@section("section", "ShareSiteTemplateDesigns")
@section("section_url", url(config('laraadmin.adminRoute') . '/sharesitetemplatedesigns'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ShareSiteTemplateDesigns Edit : ".$sharesitetemplatedesign->$view_col)

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
				{!! Form::model($sharesitetemplatedesign, ['route' => [config('laraadmin.adminRoute') . '.sharesitetemplatedesigns.update', $sharesitetemplatedesign->id ], 'method'=>'PUT', 'id' => 'sharesitetemplatedesign-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'template_name')
					@la_input($module, 'template_photo')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/sharesitetemplatedesigns') }}">Cancel</a></button>
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
	$("#sharesitetemplatedesign-edit-form").validate({
		
	});
});
</script>
@endpush
