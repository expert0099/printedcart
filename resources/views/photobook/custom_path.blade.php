@extends("layouts.photobook")

@section("main-content")

<div class="continer-fluid chooseBookSizeSec">
	@include('photobook.size_crowsel')
</div>

<div class="container">
	<div style="padding-top:20px;">
		@if($errors->has())
			<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
			  @foreach ($errors->all() as $error)
				{{ $error }}<br>
			  @endforeach
			</div>
		@endif
	</div>
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
							<!--<div class="item border-0">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion4" aria-expanded="false" aria-controls="exampleAccordion1">Recently viewed</a>
								<div id="exampleAccordion4" class="collapse show" role="tabpanel">
									<div class="row">
										<div class="col-12 text-center pt-3">
											<img class="img-fluid" src="{{URL::asset('public/images/recent-view-img.jpg')}}" alt="recent-view">
											<span class="fz-14 d-block text-blue text mt-3">Gallery Calendar</span>
										</div>
									</div>
								</div>
							</div>-->														
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
	</div>
</div>
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
			url: base_path+'photobooks/custom_path/'+default_style,
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
		url: base_path+'photobooks/custom_path/'+default_style,
		beforeSend: function(){$("#loading" ).html('<img src="'+loading+'"> <br>loading...');},
		success: function(data){
			$('.custom-book-list').html(data);
		},
		error: function(e) {
			var json = JSON.stringify(e);
			//alert('Error' + json);
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
            url: base_path+'photobooks/custom_path' + page,
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
			url: base_path+'photobooks/custom_path/'+default_style,
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
				//alert('Error' + json);
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
    /*background-color: #4CAF50;*/
    background-color: #687282;
    padding: 8px 8px;
    margin: 4px;
    color: white;
    border: 1px solid #4CAF50;
}
/*ul.pagination li a:hover:not(.active) {background-color: #ddd;}*/
ul.pagination li a:hover {background-color: #999999;}
ul.pagination li.disabled {
    /*background-color: #cccccc;*/
    color: #ddd;
    padding: 8px 8px;
    border: 1px solid #ddd;
    margin: 4px;
}
</style>
@endsection