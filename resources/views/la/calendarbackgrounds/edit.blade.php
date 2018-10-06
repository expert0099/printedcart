@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/calendarbackgrounds') }}">CalendarBackground</a> :
@endsection
@section("contentheader_description", $calendarbackground->$view_col)
@section("section", "CalendarBackgrounds")
@section("section_url", url(config('laraadmin.adminRoute') . '/calendarbackgrounds'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CalendarBackgrounds Edit : ".$calendarbackground->$view_col)

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
				{!! Form::model($calendarbackground, ['route' => [config('laraadmin.adminRoute') . '.calendarbackgrounds.update', $calendarbackground->id ], 'method'=>'PUT', 'id' => 'calendarbackground-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'calendar_category_id')
					@la_input($module, 'calendar_style_id')
					@la_input($module, 'background_image')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/calendarbackgrounds') }}">Cancel</a></button>
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
	$("#calendarbackground-edit-form").validate({
		
	});
});
</script>
@endpush
