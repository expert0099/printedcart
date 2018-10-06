@extends("layouts.photobook")

@section("main-content")
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<script>
$(function(){
	setTimeout(function() {
        $('.alert-success').fadeOut('fast');
    }, 20000); 
	setTimeout(function(){
        $('.alert-danger').fadeOut('fast');
    }, 20000);
});
</script>
  
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>

<!-- data table includes -->
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap.min.js"></script>
<!-- end data table includes -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(function(){
	/* delete project dialog */
	$( ".delAlb" ).on( "click", function(){
		var project_name = $(this).attr('rel');
		var href = $(this).attr('p');
		var ref = $(this);
		var message = "Are you sure you want to delete your project: "+project_name+"? This action cannot be undone."
		$("#deleteProjectDialog").html(message);
		$("#deleteProjectDialog").dialog({
			resizable: false,
			height: "auto",
			width: 400,
			modal: true,
			buttons: {
				"Delete": function(){
					/* var str = project_name;
					var x = confirm("Are you sure you want to delete your Project: "+str+"? This action cannot be undone.");
					if (x){  */
						$("#deleteProjectDialog").dialog( "close" );
						window.location.href = href;
						return true;
					/* }else{
						return false;
					} */
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
	});
	/* end delete project dialog */
	
	$("#tabs").tabs();
	$('#example').DataTable();
});
</script>

<style rel="stylesheet">
.pagination li a {
    display: inline-block;
    padding: 4px 11px;
    margin-right: 4px;
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}

.pagination li a:hover {
	background: #0099cc;
	color: #fff;
	padding: 4px 11px;
}

.pagination li.active {
    display: inline-block;
    padding: 4px 11px;
    margin-right: 4px;
    background: #0099cc;
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
}
.pagination li.disabled{
	display: inline-block;
    padding: 0px 9px;
    margin-right: 4px;
}

</style>

<div class="container">
	<!-- Calander Page Info Start -->
	<section class="mt-5 mb-3 mySection">
		<div class="row">
			<div class="col-12">
				@foreach($errors->all() as $error)
					<p class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{ $error }}
					</p>
				@endforeach
				@if(Session::has('success'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{Session::get('success')}}
					</div>
				@endif
				
				@if(Session::has('success_add_to_cart'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						Item added to cart! <a href="{{URL::asset('payments/cart')}}">View cart and checkout.</a>
					</div>
				@endif
				
				<h2 class="text-blue mb-3">My PrintedCart</h2>
				<!-- my photo content -->
				<div class="content-body">
					<div id="tabs" style="min-height:300px;">
						<ul>
							<li><a href="#my_project">My Projects</a></li>
							<li><a href="#order_history" id="oh">Order History</a></li>
							<li><a href="#address_book">Address Book</a></li>
							<li><a href="#account_info">Account Info</a></li>
						</ul>
						<div id="my_project">
							@if(count($all_my_project)>0)
							<div class="project-box">
								@foreach($all_my_project as $k => $value)
								<div class="albumBack" style="padding-bottom:15px;float:left; margin-bottom: 20px;" id="{{$value->id}}">
									<table width="100%" class="albumtable" style="padding:0px 0px 5px 0px" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td title="Default Album" align="left" style="width:238px;">
													<div class="box-style">
														<div>
															<span class="contentInfo">
																<span class="contentName" style="font-weight:bold">
																@if($value['flag'] == 'Photobook')
																	{{$value->project_name}}
																@elseif($value['flag'] == 'College Poster')
																	{{$value->project_name}}
																@else
																	{{$value->project_name}}
																@endif
																</span>
															</span>
														</div>
														<div style="font-size:15px;">
															<span class="contentInfo" id="albumDetail_{{$value->id}}" title="{{$value->id}}">Created: {{date('m-d-Y',strtotime($value->created_at))}}</span>
														</div>
														<div class="box-btn">
															<!--<a href="{{URL::asset('user/delete_project/'.$value->id .'/'.$value['flag'])}}" onclick="return confirm('Are you sure?');return false;" class="btn bg-danger fz-15 font-weight-light border-0 rounded-0 px-3 mt-2 text-white" title="Delete" alt="Delete">Delete</a>-->
															
															<a rel="{{$value->project_name}}" p="{{URL::asset('user/delete_project/'.$value->id .'/'.$value['flag'])}}" class="delAlb btn bg-danger fz-15 font-weight-light border-0 rounded-0 px-3 mt-2 text-white" href="javascript:void(0)" title="Delete" alt="Delete">Delete</a>
															
															@if($value['flag'] == 'Photobook')
																<a href="{{ URL::asset('photobooks/custom_path/project/'.$value->id) }}" class="btn btn-primary fz-15 font-weight-light border-0 rounded-0 px-3 mt-2 text-white" title="Edit" alt="Edit" onclick="swalAlert();">Edit</a>
															@elseif($value['flag'] == 'College Poster')
																<a href="{{ URL::asset('calendars/poster_editor/'.$value->calendar_style_id .'/'.$value->size_id .'/'. $value->calendar_category_id .'/'.$value->cyear) }}" class="btn btn-primary fz-15 font-weight-light border-0 rounded-0 px-3 mt-2 text-white" title="Edit" alt="Edit" onclick="swalAlert();">Edit</a>
															@else
															<a href="{{ URL::asset('calendars/cal_editor/'.$value->calendar_style_id .'/'.$value->size_id .'/'.$value->calendar_category_id .'/'.$value->cmonth .'/'.$value->cyear) }}" class="btn btn-primary fz-15 font-weight-light border-0 rounded-0 px-3 mt-2 text-white" title="Edit" alt="Edit" onclick="swalAlert();">Edit</a>
															@endif
															
															<form name="cartForm" method="post" action="{{URL::asset('cart/add_to_cart')}}" style="width: 104px;float: right;">
															<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
															<input type="hidden" name="project_id" value="{{$value->id}}"/>
															<input type="hidden" name="flag" value="{{$value->flag}}"/>
															@if(null!==$value['Cart'])
															<input type="button" class="btn btn-primary fz-15 font-weight-light border-0 rounded-0 px-3 mt-2 text-white" name="button" value="Added to Cart" disabled style="cursor:none;" title="Added to Cart" alt="Added to Cart" onclick="swalAlert();"></button>
															@elseif(null!==$value['Order'])
															<input type="button" class="btn btn-success fz-15 font-weight-light border-0 rounded-0 px-3 mt-2 text-white" name="button" value="Ordered" disabled style="cursor:none;" title="Ordered" alt="Ordered" onclick="swalAlert();"></button>
															@else
															<input type="submit" name="submit" class="btn btn-primary fz-15 font-weight-light border-0 rounded-0 px-3 mt-2 text-white" value="Add To Cart" title="Add To Cart" alt="Add To Cart" onclick="swalAlert();"/>
															@endif
															</form>
														</div>									
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								@endforeach
							</div>
							<div class="porject-box-pagination">{!! $all_my_project->links() !!}</div>
							@else
								<div class="project-box" style="text-align:center;color:red;">Project not found!</div>
							@endif
						</div>
	
						<div id="order_history">
							<!-- order table -->
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Order Product</th>
										<th>Amount</th>
										<th>Shipping Amt</th>
										<th>Total Amt</th>
										<th>Transaction ID</th>
										<th>Order Status</th>
										<th>Order Date</th>
									</tr>
								</thead>
								<tbody>
								@if(count($orders)>0)
									@foreach($orders as $k => $val)
									<tr>
										<td>{!! $k+1 !!}</td>
										<td>
										@if(null!==$val['Project'])
											{!! $val['Project']['project_name'] !!} - {!! $val['Project']['size'] !!}
										@else 
											Bulk-item
										@endif
										</td>
										<td>{!! $default_currency->currencysymbol !!}{!! $val['amt'] !!}</td>
										<td>{!! $default_currency->currencysymbol !!}{!! $val['shipping_amt'] !!}</td>
										<td>{!! $default_currency->currencysymbol !!}{!! $val['amt']+$val['shipping_amt'] !!}</td>
										<td>{!! $val['txn_id'] !!}</td>
										<td>{!! $val['status'] !!}</td>
										<td>{!! date('Y-m-d H:i:s',strtotime($val['created_at'])) !!}</td>
									</tr>
									@endforeach
								@else
									<tr>
										<td colspan="9" align="center" style="color:red;">You haven't placed any orders yet.</td>
									</tr>
								@endif
								</tbody>
							</table>
							<!-- end order table -->
						</div>
	
						<div id="address_book">
							<div>
								{!! Form::open(['method' => 'POST','url'=>'user/save_info','style'=>'','id'=>'addressBookForm']) !!}
								<div class="form-row">
									<div class="form-group col-md-6" style="text-align:left;">
										First Name:{!! Form::text('first_name',$address['first_name'], ['class'=>'form-control','required'=>'true']) !!}
									</div>
									 <div class="form-group col-md-6" style="text-align:left;">
										Last Name:{!! Form::text('last_name',$address['last_name'], ['class'=>'form-control','required'=>'true']) !!}
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6" style="text-align:left;">
										Email Address:{!! Form::text('email',$address['email'], ['class'=>'form-control','required'=>'true']) !!}
									</div>
									<div class="form-group col-md-6" style="text-align:left;">
										Address Street:{!! Form::text('street',$address['street'], ['class'=>'form-control','required'=>'true']) !!}
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6" style="text-align:left;">
										City:{!! Form::text('city',$address['city'], ['class'=>'form-control','required'=>'true']) !!}
									</div>
									<div class="form-group col-md-6" style="text-align:left;">
										State:{!! Form::text('state',$address['state'], ['class'=>'form-control','required'=>'true']) !!}
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6" style="text-align:left;">
										Zipcode:{!! Form::text('zipcode',$address['zipcode'], ['class'=>'form-control','required'=>'true']) !!}
									</div>
									<div class="form-group col-md-6" style="text-align:left;">
										Country:{!! Form::text('country',$address['country'], ['class'=>'form-control','required'=>'true']) !!}
									</div>
								</div>
								<div>
									{!! Form::submit('Update', ['class'=>'form-control btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3 w-auto','id'=>'addressBookButton']) !!}
								</div>
																	
								{!! Form::close() !!}
							</div>
						</div>
	
						<div id="account_info">
							<div>
								{!! Form::open(['method' => 'POST','url'=>'user/account_info','style'=>'','id'=>'accountInfoForm']) !!}
								<div class="form-row">
									<div class="form-group col-md-6" style="text-align:left;">
										Name:{!! Form::text('name',$user_info->name, ['class'=>'form-control','required'=>'true']) !!}
									</div>
									 <div class="form-group col-md-6" style="text-align:left;">
										Email:{!! Form::text('email',$user_info->email, ['class'=>'form-control','required'=>'true']) !!}
									</div>
								</div>
								<!--<div class="form-row">
									<div class="form-group col-md-6">
										Email Address:{!! Form::text('email',$address['email'], ['class'=>'form-control','disabled']) !!}
									</div>
								</div>-->
								<div>
									{!! Form::submit('Update', ['class'=>'form-control btn btn-primary fz-18 font-weight-light border-0 rounded-0 px-3 w-auto', 'id'=>'accountInfoButton']) !!}
								</div>
																	
								{!! Form::close() !!}
							</div>
						</div>
	
					</div>
				</div>
				<!-- end my photo content -->
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->
	
	<div id="deleteProjectDialog" title="Delete Project"></div>
	
</div>
<script>
$("#accountInfoButton").on('click',function(){
	if($("#accountInfoForm input[name=name]").val() == ''){
		swal("Oops!", "Name Field can not be empty", "error");
	}else if($("#accountInfoForm input[name=email]").val() == ''){
		swal("Oops!", "Email field can not be empty", "error");
	}else{
		swal("Please Wait...!","Data Updating...!","warning");
	}
});
$("#addressBookButton").on('click',function(){
	if($("#addressBookForm input[name=first_name]").val()==''){
		swal("Oops!", "First name field can not be empty", "error");
	}else if($("#addressBookForm input[name=last_name]").val()==''){
		swal("Oops!", "Last name field can not be empty", "error");
	}else if($("#addressBookForm input[name=email]").val()==''){
		swal("Oops!", "Email name field can not be empty", "error");
	}else if($("#addressBookForm input[name=street]").val()==''){
		swal("Oops!", "Street name field can not be empty", "error");
	}else if($("#addressBookForm input[name=city]").val()==''){
		swal("Oops!", "City name field can not be empty", "error");
	}else if($("#addressBookForm input[name=state]").val()==''){
		swal("Oops!", "State name field can not be empty", "error");
	}else if($("#addressBookForm input[name=zipcode]").val()==''){
		swal("Oops!", "Zipcode name field can not be empty", "error");
	}else if($("#addressBookForm input[name=country]").val()==''){
		swal("Oops!", "Country name field can not be empty", "error");
	}else{
		swal("Please Wait...!","Data Updating...!","warning");
	}
});
function swalAlert(){
	swal("Please Wait...!","Data Processing...!","warning");
}
/* $(function(){
	$('a[data-toggle=tab]').click(function(){
		alert(this.id);
	});
	$('#oh').on('click',function(){
		alert('asdf');
		var order_count = "<?php echo count($orders);?>";
		if(order_count<=0){
			swal("Oops!", "You haven't placed any orders yet.", "error");
		}
	});
}); */
</script>
<style>
.basket-tag{
	float:right;
	width:115px;
	font-size:17px;
	padding-top:10px;
}
.order-tag{
	float:right;
	width:115px;
	font-size:17px;
	padding-top:10px;
}
</style>

@endsection