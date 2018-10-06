@extends("la.layouts.app")

@section("contentheader_title", "MMB Request")
@section("contentheader_description", "MMB Request listing")
@section("section", "MmbRequest")
@section("sub_section", "Listing")
@section("htmlheader_title", "MMB Request listing")

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
					<th>User</th>
					<th>My Book Name</th>
					<th>Photobook</th>
					<th>Photobook Style</th>
					<th>Size</th>
					<th>Request Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($mmbrequest as $k => $v)
					<tr>
						<td>{!! $k+1 !!}</td>
						<td>{!! $v->user_name !!}</td>
						<td>{!! $v->mybook_name !!}</td>
						<td>{!! $v->photo_book !!}</td>
						<td>{!! $v->photo_book_style !!}</td>
						<td>{!! $v->Size !!}</td>
						<td>{!! $v->mmb_created_at !!}</td>
						<td>
							<a href="{{ url(config('laraadmin.adminRoute') . '/mmbrequest/view/'.$v->mmb_id) }}"><button class="btn btn-success btn-xs" type="submit">View <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></a>
						</td>
					</tr>
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
