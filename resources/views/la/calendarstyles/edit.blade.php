@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/calendarstyles') }}">CalendarStyle</a> :
@endsection
@section("contentheader_description", $calendarstyle->$view_col)
@section("section", "CalendarStyles")
@section("section_url", url(config('laraadmin.adminRoute') . '/calendarstyles'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CalendarStyles Edit : ".$calendarstyle->$view_col)

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
				{!! Form::model($calendarstyle, ['route' => [config('laraadmin.adminRoute') . '.calendarstyles.update', $calendarstyle->id ], 'method'=>'PUT', 'id' => 'calendarstyle-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'calendar_style')
					@la_input($module, 'calendar_category_id')
					@la_input($module, 'calendar_style_type_id')
					@la_input($module, 'photo')
					@la_input($module, 'standard')
					@la_input($module, 'storytelling')
					@la_input($module, 'art_library')
					@la_input($module, 'of_photos')
					@la_input($module, 'reg_corner')
					@la_input($module, 'round_corner')
					@la_input($module, 'float_paperie')
					@la_input($module, 'paper_plains')
					@la_input($module, 'potts_design')
					@la_input($module, 'yours_truly')
					@la_input($module, 'disney')
					@la_input($module, 'printedcart')
					@la_input($module, 'design_style')
					@la_input($module, 'design_size')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/calendarstyles') }}">Cancel</a></button>
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
	$("#calendarstyle-edit-form").validate({
		
	});
});
</script>
@endpush
