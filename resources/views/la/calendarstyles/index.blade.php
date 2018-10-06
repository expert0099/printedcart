@extends("la.layouts.app")

@section("contentheader_title", "CalendarStyles")
@section("contentheader_description", "CalendarStyles listing")
@section("section", "CalendarStyles")
@section("sub_section", "Listing")
@section("htmlheader_title", "CalendarStyles Listing")

@section("headerElems")
@la_access("CalendarStyles", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add CalendarStyle</button>
@endla_access
@endsection

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

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>Actions</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@la_access("CalendarStyles", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add CalendarStyle</h4>
			</div>
			{!! Form::open(['action' => 'LA\CalendarStylesController@store', 'id' => 'calendarstyle-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
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
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('public/la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/calendarstyle_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#calendarstyle-add-form").validate({
		
	});
});
</script>
@endpush
