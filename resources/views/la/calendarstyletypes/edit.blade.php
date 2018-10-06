@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/calendarstyletypes') }}">CalendarStyleType</a> :
@endsection
@section("contentheader_description", $calendarstyletype->$view_col)
@section("section", "CalendarStyleTypes")
@section("section_url", url(config('laraadmin.adminRoute') . '/calendarstyletypes'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CalendarStyleTypes Edit : ".$calendarstyletype->$view_col)

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
				{!! Form::model($calendarstyletype, ['route' => [config('laraadmin.adminRoute') . '.calendarstyletypes.update', $calendarstyletype->id ], 'method'=>'PUT', 'id' => 'calendarstyletype-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'style_type')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/calendarstyletypes') }}">Cancel</a></button>
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
	$("#calendarstyletype-edit-form").validate({
		
	});
});
</script>
@endpush
