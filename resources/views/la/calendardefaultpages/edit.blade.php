@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/calendardefaultpages') }}">CalendarDefaultPage</a> :
@endsection
@section("contentheader_description", $calendardefaultpage->$view_col)
@section("section", "CalendarDefaultPages")
@section("section_url", url(config('laraadmin.adminRoute') . '/calendardefaultpages'))
@section("sub_section", "Edit")

@section("htmlheader_title", "CalendarDefaultPages Edit : ".$calendardefaultpage->$view_col)

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
				{!! Form::model($calendardefaultpage, ['route' => [config('laraadmin.adminRoute') . '.calendardefaultpages.update', $calendardefaultpage->id ], 'method'=>'PUT', 'id' => 'calendardefaultpage-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'calendar_category_id')
					@la_input($module, 'page_name')
					@la_input($module, 'page_content')
					@la_input($module, 'isActive')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/calendardefaultpages') }}">Cancel</a></button>
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
	$("#calendardefaultpage-edit-form").validate({
		
	});
});
</script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ URL::asset('public/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
$('textarea[name=page_content]').ckeditor();
</script>
@endpush
