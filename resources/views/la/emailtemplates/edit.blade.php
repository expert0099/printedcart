@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/emailtemplates') }}">EmailTemplate</a> :
@endsection
@section("contentheader_description", $emailtemplate->$view_col)
@section("section", "EmailTemplates")
@section("section_url", url(config('laraadmin.adminRoute') . '/emailtemplates'))
@section("sub_section", "Edit")

@section("htmlheader_title", "EmailTemplates Edit : ".$emailtemplate->$view_col)

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
				{!! Form::model($emailtemplate, ['route' => [config('laraadmin.adminRoute') . '.emailtemplates.update', $emailtemplate->id ], 'method'=>'PUT', 'id' => 'emailtemplate-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'email_template')
					@la_input($module, 'email_content')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/emailtemplates') }}">Cancel</a></button>
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
	$("#emailtemplate-edit-form").validate({
		
	});
});
</script>
@endpush
