@extends("layouts.photobook")

@section("main-content")
  
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>

<!-- data table includes -->
<!--<style href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">-->
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap.min.js"></script>
<!-- end data table includes -->
<script>
$(function(){
	$("#tabs").tabs();
	$('#example').DataTable();
});
</script>

<style rel="stylesheet">
.pagination {
    padding-top: 24px;
}

.pagination li a {
    display: inline-block;
    padding: 0px 9px;
    margin-right: 4px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #e9e9e9;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}

.pagination li a:hover {
    background: #fefefe;
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FEFEFE), to(#f0f0f0));
    background: -moz-linear-gradient(0% 0% 270deg,#FEFEFE, #f0f0f0);
}

.pagination li.active {
    display: inline-block;
    padding: 0px 9px;
    margin-right: 4px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #616161;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #f0f0f0;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}
.pagination li.disabled{
	display: inline-block;
    padding: 0px 9px;
    margin-right: 4px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
	box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
	text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}
</style>

<div class="container">

	<!-- Calander Page Info Start -->
	<section class="mt-5 mb-3">
		<div class="row">
			<div class="col-12">
				@if(Session::has('success'))
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{Session::get('success')}}
					</div>
				@endif
				<h5 class="text-blue">My Section</h5>
				
<!-- my photo content -->
<div class="content-body">
					
<div id="tabs" style="min-height:300px;">
	<ul>
		<li><a href="#my_project">My Project</a></li>
		<li><a href="#order_history">Order History</a></li>
		<li><a href="#address_book">Address Book</a></li>
	</ul>
	<div id="my_project">
		<div style="float:left;">
		
		@foreach($all_my_project as $k => $value)
			<div class="albumBack" style="padding-bottom:15px;float:left;" id="{{$value->id}}">
				<table class="albumtable" style="padding:0px 0px 5px 0px" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td title="Default Album" align="left" style="width:238px;">
								<div style="text-align:left;border:1px solid #ccc;border-radius:5px;margin:10px 10px;background-color:#f1f1f1;">
									<div>
										<span class="contentInfo" style="padding-left:5px">
											<span class="contentName" style="font-weight:bold">
											@if($value['flag'] == 'Photobook')
												<a href="{{ URL::asset('photobooks/custom_path/project/'.$value->id) }}">{{$value->project_name}}</a>
											@elseif($value['flag'] == 'College Poster')
												<a href="{{ URL::asset('calendars/poster_editor/'.$value->calendar_style_id .'/'.$value->size_id .'/'. $value->calendar_category_id .'/'.$value->cyear) }}">{{$value->project_name}}</a>
											@else
											<a href="{{ URL::asset('calendars/cal_editor/'.$value->calendar_style_id .'/'.$value->size_id .'/'.$value->calendar_category_id .'/'.$value->cmonth .'/'.$value->cyear) }}">{{$value->project_name}}</a>
											@endif
											</span>
										</span>
										<a href="{{URL::asset('user/delete_project/'.$value->id .'/'.$value['flag'])}}" onclick="return confirm('Are you sure?');return false;"><i class="fa fa-trash-o" style="font-size:16px;color:red;float:right;margin:5px;"></i></a>
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
		<div style="float:left;">{!! $all_my_project->links() !!}</div>
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
			@foreach($orders as $k => $val)
            <tr>
				<td>{!! $k+1 !!}</td>
                <td>{!! $val['Project']['order_name'] !!} {!! $val['Project']['size'] !!}</td>
                <td>{!! $val['currency_code'] !!}{!! $val['amt'] !!}</td>
                <td>{!! $val['currency_code'] !!}{!! $val['shipping_amt'] !!}</td>
                <td>{!! $val['currency_code'] !!}{!! $val['amt']+$val['shipping_amt'] !!}</td>
                <td>{!! $val['txn_id'] !!}</td>
                <td>{!! $val['status'] !!}</td>
                <td>{!! date('Y-m-d H:i:s',strtotime($val['created_at'])) !!}</td>
            </tr>
			@endforeach
        </tbody>
    </table>
		<!-- end order table -->
		
	</div>
	
	<div id="address_book">
		<div>
			{!! Form::open(['method' => 'POST','url'=>'user/save_info','style'=>'']) !!}
				<div style="width:100%;">
					<div style="float:left;width:30%;">
						First Name:{!! Form::text('first_name',$address['UserAddressInfo']['first_name'], ['class'=>'form-control','style'=>'width:250px;']) !!}
					</div>
					<div style="float:left;width:30%;">
						Last Name:{!! Form::text('last_name',$address['UserAddressInfo']['last_name'], ['class'=>'form-control','style'=>'width:250px;']) !!}
					</div>
					<div style="float:left;width:30%;">
						Email Address:{!! Form::text('email',$address['email'], ['class'=>'form-control','style'=>'width:250px;','disabled']) !!}
					</div>
				</div>
				<div style="width:100%;">
					<div style="float:left;width:30%;">
						Address Street:{!! Form::text('street',$address['UserAddressInfo']['street'], ['class'=>'form-control','style'=>'width:250px;']) !!}
					</div>
					<div style="float:left;width:30%;">
						City:{!! Form::text('city',$address['UserAddressInfo']['city'], ['class'=>'form-control','style'=>'width:250px;']) !!}
					</div>
					<div style="float:left;width:30%;">
						State:{!! Form::text('state',$address['UserAddressInfo']['state'], ['class'=>'form-control','style'=>'width:250px;']) !!}
					</div>
				</div>
				<div style="width:100%;">
					<div style="float:left;width:30%;">
						Zipcode:{!! Form::text('zipcode',$address['UserAddressInfo']['zipcode'], ['class'=>'form-control','style'=>'width:250px;']) !!}
					</div>
					<div style="float:left;width:30%;">
						Country:{!! Form::text('country',$address['UserAddressInfo']['country'], ['class'=>'form-control','style'=>'width:250px;']) !!}
					</div>
					<div style="float:left;width:30%;">
						{!! Form::submit('Edit', ['class'=>'form-control btn btn-success','style'=>'width:100px;margin-top:25px;']) !!}
					</div>
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
	
</div>

<!--<style href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="stylesheet">-->



@endsection