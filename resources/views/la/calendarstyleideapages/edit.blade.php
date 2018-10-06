@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/calendarstyleideapages') }}">CalendarStyleIdeaPage</a> :
@endsection
@section("contentheader_description", $calendarstyleideapage->$view_col)
@section("section", "CalendarStyleIdeaPages")
@section("section_url", url(config('laraadmin.adminRoute') . '/calendarstyleideapages'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CalendarStyleIdeaPages Edit : ".$calendarstyleideapage->$view_col)

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
				{!! Form::model($calendarstyleideapage, ['route' => [config('laraadmin.adminRoute') . '.calendarstyleideapages.update', $calendarstyleideapage->id ], 'method'=>'PUT', 'id' => 'calendarstyleideapage-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'calendar_style_id')
					@la_input($module, 'idea_pages')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/calendarstyleideapages') }}">Cancel</a></button>
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
	$("#calendarstyleideapage-edit-form").validate({
		
	});
});
</script>
@endpush
