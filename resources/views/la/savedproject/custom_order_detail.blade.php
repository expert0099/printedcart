@extends('la.layouts.app')

@section("contentheader_title", "Order Details")

@section('main-content')

<meta name="_token" content="{{ csrf_token() }}" />

<link rel="stylesheet" href="{{URL::asset('public/css/photobook_custom_editor.css')}}"/>
<link rel="stylesheet" href="{{URL::asset('public/css/custom.css')}}"/>
		
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.svg.js"></script>

<div style="width:100%;float:left;border-bottom:1px solid #ccc;padding-bottom:20px;">
	<a href="{{ url(config('laraadmin.adminRoute') . '/saved_project') }}"><button class="btn btn-success">Back</button></a>
</div>

<div class="profile2 content-body" style="overflow-x: auto; padding-top:20px;">
	<div>
		<h3>Order Detail</h3>
		<div><b>Txn ID :- </b>{{$order->txn_id}}</div>
		<div><b>Order Amount :- </b>{{$order->currency_code.$order->amt}}</div>
		<div><b>Order Shipping Amount :- </b>{{$order->currency_code.$order->shipping_amt}}</div>
		<div><b>Order Total :- </b>{{$order->currency_code.($order->amt+$order->shipping_amt)}}</div>
		<div><b>Order Date :-</b> {{$order->created_at}}</div>
		<hr/>
		<h3>Print of set</h3>
		<?php 
		/* echo '<pre>';
		print_r($savedProj); */
		?>
		<table style="width:100%;border:1px solid #ccc;">
			<tr style="line-height: 30px; background-color: #ccc; font-weight: bold;">
				<td></td>
				<td>print of set</td>
				<td>qty.</td>
				<td>price</td>
				<td>type</td>
				<td>border color</td>
				<td>border</td>
				<td>print message</td>
			</tr>
			@foreach($savedProj as $k => $pset)
			<?php 
			if($k%2 == 0){
				$class = 'even';
			}else{
				$class = 'odd';
			}
			?>
			<tr class="{{$class}}">
				<td><img src="{{URL::asset('public/'.$pset->image_path)}}" style="width:100px;"></td>
				<td>{{$pset->size}}</td>
				<td>{{$pset->qty}}</td>
				<td>{{$pset->price}}</td>
				<td>{{$pset->size_type}}</td>
				<td>{{$pset->border_color}}</td>
				<td>{{$pset->border}}</td>
				<td>{{$pset->print_message}}</td>
			</tr>
			@endforeach
		</table>
		<hr/>
		<h3>Customer Detail</h3>
		<div><b>Name :-</b>{{$userinfo->first_name}} {{$userinfo->last_name}}</div>
		<div><b>Email :-</b>{{$userinfo->email}}</div>
		<div><b>Address :-</b>{{$userinfo->street}}, {{$userinfo->city}}<br>{{$userinfo->state}}, {{$userinfo->zipcode}}, {{$userinfo->country}}</div>
	</div>
</div>
<style>
.odd{
	background-color:#f9f9f9;
}
</style>
@endsection
