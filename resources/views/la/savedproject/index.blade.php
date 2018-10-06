@extends("la.layouts.app")

@section("contentheader_title", "Order Project")
@section("contentheader_description", "Order Project listing")
@section("section", "SavedProject")
@section("sub_section", "Listing")
@section("htmlheader_title", "Order Project Listing")

@section("main-content")

@if(count($errors) > 0)
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
					<th>#</th>
					<th>Project</th>
					<th>User</th>
					<th>Order Amount</th>
					<th>Order Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i = 0;
				?>
				@foreach($order as $k => $v)
					@foreach($v->user_saved_projects as $j => $val)
					<?php 
					$i++;
					?>
					<tr>
						<td>{!! $i !!}</td>
						<td>{!! $val->project_name !!}</td>
						<td>{!! $val->user_name !!}</td>
						<td>{!! $v->amt+$v->shipping_amt !!} {!! $v->currency_code !!}</td>
						<td>{!! $val->created_at !!}</td>
						<td>
							<a href="{{ url(config('laraadmin.adminRoute') . '/saved_project/view/'.$val->project_id.'/'.$v->id) }}"><button class="btn btn-success btn-xs" type="submit">View <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></a>
							|
							<a href="{{ url(config('laraadmin.adminRoute') . '/saved_project/order_detail/'.$val->project_id.'/'.$v->id) }}"><button class="btn btn-success btn-xs" type="submit">Order Detail <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></a>
							<!--<a href="{{ url(config('laraadmin.adminRoute') . '/saved_project/'.$v->id) }}"><button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are you sure?');return false;"><i class="fa fa-times"></i></button></a>-->
						</td>
					</tr>
					@endforeach
				@endforeach
			</tbody>
		</table>
	</div>
</div>


@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('public/la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		/* processing: true,
        serverSide: true,
        //ajax: "{{ url(config('laraadmin.adminRoute') . '/staticpage_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		}, */
		
	});
});
</script>
@endpush
