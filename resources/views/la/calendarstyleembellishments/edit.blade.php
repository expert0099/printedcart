@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/calendarstyleembellishments') }}">CalendarStyleEmbellishment</a> :
@endsection
@section("contentheader_description", $calendarstyleembellishment->$view_col)
@section("section", "CalendarStyleEmbellishments")
@section("section_url", url(config('laraadmin.adminRoute') . '/calendarstyleembellishments'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CalendarStyleEmbellishments Edit : ".$calendarstyleembellishment->$view_col)

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
				{!! Form::model($calendarstyleembellishment, ['route' => [config('laraadmin.adminRoute') . '.calendarstyleembellishments.update', $calendarstyleembellishment->id ], 'method'=>'PUT', 'id' => 'calendarstyleembellishment-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'calendar_style_id')
					@la_input($module, 'embellishments')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/calendarstyleembellishments') }}">Cancel</a></button>
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
	$("#calendarstyleembellishment-edit-form").validate({
		
	});
});
</script>
@endpush
