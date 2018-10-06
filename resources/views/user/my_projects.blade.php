@extends("layouts.home")

@section("main-content")

<div class="container">

	@include('pages.banner')

	<!-- Calander Page Info Start -->
	<section class="clander-page-info pt-5 mt-5 mb-3">
		<div class="row">
			<div class="col-12">
				<h5 class="text-blue">My Projects</h5>
				<!-- my photo content -->
				
				<div class="content-body">
					<div class="grid">
						<div class="cap-mid">
							<div>
								<hr/>
								@foreach($all_user_project as $k => $value)
								<div class="albumBack" style="padding-bottom:15px;float:left;" id="{{$value->id}}">
									<table class="albumtable" style="padding:0px 0px 5px 0px" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td title="Default Album" align="left" style="width:208px;">
												<div style="text-align:left;border:1px solid #ccc;border-radius:5px;margin:10px 10px;background-color:#f1f1f1;">
				<div>
					<span class="contentInfo" style="padding-left:5px">
						<span class="contentName" style="font-weight:bold">
						@if($slug == 'Photobook')
							@if($value->photobook_id == 0)
								<a href="{{ URL::asset('photobooks/editor_simple_path/'.$value->size_id) }}">{{$value->project_name}}</a>
							@else
								<a href="{{ URL::asset('photobooks/custom_path/project/'.$value->id) }}">{{$value->project_name}}</a>
							@endif
						@elseif($slug == 'College Poster')
							<a href="{{ URL::asset('calendars/poster_editor/'.$value->calendar_style_id .'/'.$value->size_id .'/'. $value->calendar_category_id .'/'.$value->cyear) }}">{{$value->project_name}}</a>
						@else
							<a href="{{ URL::asset('calendars/cal_editor/'.$value->calendar_style_id .'/'.$value->size_id .'/'.$value->calendar_category_id .'/'.$value->cmonth .'/'.$value->cyear) }}">{{$value->project_name}}</a>
						@endif
						</span>
					</span>
					<a href="{{URL::asset('user/delete_project/'.$value->id .'/'.$slug)}}" onclick="return confirm('Are you sure?');return false;"><i class="fa fa-trash-o" style="font-size:16px;color:red;float:right;margin:5px;"></i></a>
				</div>
													<div style="font-size:100%">
														<span class="contentInfo" id="albumDetail_{{$value->id}}" title="{{$value->id}}">Created :- {{date('d-m-Y',strtotime($value->created_at))}}</span>
													</div>
												</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				<!-- end my photo content -->
				
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->
</div>
@endsection