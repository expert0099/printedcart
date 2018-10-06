@extends("layouts.photobook")

@section("main-content")

<div class="continer-fluid mmbSection">
	@include('photobook.size_crowsel_mmb')
</div>

<div class="container">
	<div class="row pt-2 pt-md-5 page-top-gapping">
		<div class="col-md-5 col-lg-4 col-xl-3 pt-0 mt-0">
			<aside class="calendar-sidebar">
				<div class="card text-white rounded-0">
					<div class="card-header bg-blue rounded-0">
						<div class="sidebar-filter float-left"><i class="fa fa-sliders" aria-hidden="true"></i> Filters</div>
						<div class="sidebar-filter-clear float-right">Clear</div>
					</div>
					<div class="card-body">
						<div id="exampleAccordion" data-children=".item">
							<div class="item mb-3 pb-2">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion1" aria-expanded="false" aria-controls="exampleAccordion1">Style</a>
								<div id="exampleAccordion1" class="collapse show" role="tabpanel">
									<div class="row pb-3">
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" name='photobook_filter' rel='Storytelling' class="custom-control-input">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">Storytelling Styles<br><span class="text-blue">What are Storytelling Styles?</span></span>
											</label>
										</div>
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
											<input type="checkbox" name='photobook_filter' rel='Standard' class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description fz-14">Standard Styles</span>
											</label>
										</div>											
									</div>
								</div>
							</div>
							<div class="item mb-3 pb-2">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion2" aria-expanded="false" aria-controls="exampleAccordion1">Book Ideas</a>
								<div id="exampleAccordion2" class="collapse show" role="tabpanel">
									<div class="calander-sidebar-all-style">
										<ul class="nav flex-column">
											@foreach($photobookstyles_top5 as $k => $value)
											<li class="nav-item"><a class="nav-link" href="javascript:void(0)" rel="{!! $value['id'] !!}">@if($value['photo_book_style']=='None') All Styles @else {!! $value['photo_book_style'] !!} @endif</a></li>
											@endforeach
											<li class="nav-item"><a class="nav-link" href="javascript:void(0)">----------</a></li>
											@foreach($photobookstyles_skip5 as $k => $val)
											<li class="nav-item"><a class="nav-link" href="javascript:void(0)" rel="{!! $value['id'] !!}">{!! $val['photo_book_style'] !!}</a></li>
											@endforeach
										</ul>
									</div>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</aside>
		</div>
		<!-- sidebar div end -->
		<div class="col-md-7 col-lg-8 col-xl-9">
			<div class="book-size-section mt-4 mt-md-0">
				<h4 class="fz-26 book-size-title pb-2" style="text-align:center;">Choose a style for your {!! $size['Size'][0]['Size'] !!} book</h4>
				<input type="hidden" name="choosed_size" id="choosed_size" value="{!! $size['Size'][0]['id'] !!}"/>
				<div class="custom-book-list">
					<div id="loading" style="text-align:center;"></div>
				</div>
			</div>
		</div>
		
		<!-- mmb dialog -->
		<div id="mmb_dialog" title="Printed Cart :: Make my book" style="display:none; height: 525px;">
			{!! Form::open(['method' => 'POST','url'=>'photobooks/mmb/store','name'=>'style_form','enctype'=>'multipart/form-data','id'=>'style_form']) !!}
			{!! Form::token() !!}
			<div class="form-group">
				<div>{!! Form::label('photobook_style_id','What occasion is captured in this book?',['class'=>'label'])!!}</div>
				<div>{!! Form::select('photobook_style_id', $photobook_style, 'null',['class'=>'form-control input_select', 'required'=>'true']) !!}</div>
			</div>
			<div class="form-group">
				<div>{!! Form::label('mybook_name','Name your book',['class'=>'label']) !!}</div>
				<div>{!! Form::text('mybook_name', null, ['class'=>'form-control input_text', 'placeholder'=>'Name your book', 'required'=>'true']) !!}</div>
			</div>
			<div class="form-group">
				<div>{!! Form::label('photos','Upload your photos',['class'=>'label']) !!}</div>
				<div>{!! Form::file('photos[]', ['id'=>'input_files','class'=>'form-control input_file', 'required'=>'true','multiple' => 'multiple']) !!}</div>
			</div>
			<div class="form-group">
				<div>{!! Form::label('special_instructions','Special Instructions',['class'=>'label']) !!}</div>
				<div>{!! Form::textarea('special_instructions', null, ['class'=>'form-control input_textarea', 'placeholder'=>'Special Instructions','rows'=>'3']) !!}</div>
			</div>
			<input type="hidden" id="photobook_id" name="photobook_id"/>
			<input type="hidden" id="size_id" name="size_id"/>
			<div class="form-group" style="cursor:pointer;">{!! Form::submit('Send to designer',['class'=>'btn btn-primary', 'id'=>'sendToDesignerButton']) !!}</div>
		{!! Form::close() !!}
		</div>
		<!-- end mmb dialog -->
		
	</div>
</div>
<style>
.input_select{
	width:50%;
}
.input_text{
	width:50%;
}
.input_file{
	width: 50%;
	background-color: #ccc;
}
.input_textarea{
	width:50%;
}
</style>

<!-- lib for dialog -->
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>



<script>
if(top !== self){
	$.ui.dialog.prototype._focusTabbable = $.noop;
}
</script>
<!-- end lib for dialog -->

<script type="text/javascript">
$(function(){
	var base_path = "<?php echo config('app.url');?>";
	$('.img-fluid').click(function(){
		var size = $(this).attr('rel');
		var p = $(this).attr('p');
		var html = "Choose a style for your "+size+" book";
		var loading2 = "{{URL::asset('public/images/loader.gif')}}";
		$(".fz-26" ).html('<img src="'+loading2+'"> <br>loading...');
		setTimeout(function(){ 
			$('.fz-26').html(html);
		}, 2000);
		$('#choosed_size').val(p);
		$("#loading2" ).html().remove();
	});
	
	var loading = "{{URL::asset('public/images/loader.gif')}}";
	$('.nav-link').click(function(){
		var default_style = $(this).attr('rel');
		$.ajax({
			method: 'get',
			url: base_path+'photobooks/mmb/'+default_style,
			beforeSend: function(){
				$(".custom-book-list" ).html('');
				$(".custom-book-list" ).append("<div id='loading' style='text-align:center;'></div>");
				$("#loading" ).html('<img src="'+loading+'" style="text-align:center;"> <br>loading...');
			},
			success: function(data){
				$('.custom-book-list').html(data);
			},
			error: function(e) {
				var json = JSON.stringify(e);
			}
		});
	});
	
	var default_style = "<?php echo $default_style['id'];?>";
	/*$.ajaxSetup({ 
		headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
	}); */
	$.ajax({
		method: 'get',
		async:false,
		url: base_path+'photobooks/mmb/'+default_style,
		beforeSend: function(){$("#loading" ).html('<img src="'+loading+'"> <br>loading...');},
		success: function(data){
			$('.custom-book-list').html(data);
		},
		error: function(e) {
			var json = JSON.stringify(e);
		}
	});
	/*** ajax pagination ***/
	$(document).on('click', '.pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var myurl = $(this).attr('href');
		var page=$(this).attr('href').split('custom_path')[1];
		getData(page);
    });
	function getData(page){
        $.ajax({
            url: base_path+'mmb' + page,
            type: "get",
            datatype: "html",
        })
        .done(function(data)
        {
            console.log(data);
            $(".custom-book-list").empty().html(data);
            location.hash = page;
        })
        .fail(function(jqXHR, ajaxOptions, thrownError){
            alert('No response from server');
        });
	}
	/*** end ajax pagination ***/
	$("input:checkbox[name='photobook_filter']").on("click",function(){
		var checkedValues = $("input[name=photobook_filter]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		if(checkedValues){
			var default_style = checkedValues;
		}else{
			var default_style = "<?php echo $default_style['id'];?>";
		}
		$.ajax({
			method: 'get',
			async:false,
			url: base_path+'photobooks/mmb/'+default_style,
			beforeSend: function(){
				$(".custom-book-list" ).html('');
				$(".custom-book-list" ).append("<div id='loading' style='text-align:center;'></div>");
				$("#loading" ).html('<img src="'+loading+'" style="text-align:center;"> <br>loading...');
			},
			success: function(data){
				$('.custom-book-list').html(data);
			},
			error: function(e) {
				var json = JSON.stringify(e);
			}
		});
		
	});
});
</script>
<style>
ul.pagination{
	display:table;
}
ul.pagination li {
    display: inline;
    font-size: 12px;
    font-weight: bold;
}
ul.pagination li a {
    color: black;
    padding: 8px 8px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
    margin: 4px;
}
ul.pagination li a.active {
    background-color: #4CAF50;
    padding: 8px 8px;
    margin: 4px;
    color: white;
    border: 1px solid #4CAF50;
}
ul.pagination li.active {
    background-color: #687282;
    padding: 8px 8px;
    margin: 4px;
    color: white;
    border: 1px solid #4CAF50;
}
ul.pagination li a:hover {background-color: #999999;}
ul.pagination li.disabled {
    color: #ddd;
    padding: 8px 8px;
    border: 1px solid #ddd;
    margin: 4px;
}
</style>
@endsection