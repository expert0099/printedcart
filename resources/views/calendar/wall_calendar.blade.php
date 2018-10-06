@extends("layouts.calendar")

@section("main-content")
<div class="container">
	<div class="row pt-2 pt-md-5 page-top-gapping">
		<!-- sidebar start -->
		<div class="col-md-5 col-lg-4 col-xl-3 pt-4 mt-0 mt-md-3">
			<aside class="calendar-sidebar">
				<div class="card text-white rounded-0">
					<div class="card-header bg-blue rounded-0">
						<div class="sidebar-filter float-left">All Styles</div>
					</div>
					<div class="card-body">
						<div class="calander-sidebar-all-style">
							<ul class="nav flex-column">
								@foreach($calendar_styles as $k => $val)
								<li class="nav-item">
									<a class="nav-link" href="javascript:void(0)" rel="{!! $val['id'] !!}">{!! $val['style_type'] !!}</a>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</aside>
		</div>
		<!-- sidebar div end -->

		<div class="col-md-7 col-lg-8 col-xl-9">
			<div class="calendar-liting-section mt-4 mt-md-0">
				<h4 class="fz-26">Choose a Style for your {!! $calendar_size !!} Calendar</h4>

				<div class="calendar-thumb-top-bar d-lg-flex">	
					<div class="col-12 col-md-12 col-lg-8 p-0 text-center text-lg-left mb-3 mb-lg-0"><p class="fz-14 m-0"><span class="font-weight-bold filter">All</span> | <span class='filter'>Standard</span> | <span class='filter'>Storytelling</span></p></div>
					<!--<div class="col-12 col-md-12 col-lg-4 ml-lg-auto text-center text-lg-right">
						<div class="calandar-fav-top-bar">
							<p class="fz-14 m-0 d-inline-block">58 of 58 styles</p>
						</div>
					</div>-->
				</div>
				<!-- calendar-thumb-top-bar end -->

				<div class="calendar-product-list">
					<div id="loading" style="text-align:center;"></div>
				</div>
			</div>
			<!-- calendar-liting-section end -->
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	var loading = "{{URL::asset('public/images/loader.gif')}}";
	var calendar_size_id = "<?php echo $calendar_size_id;?>";
	var calendar_month = "<?php echo $calendar_month;?>";
	var calendar_year = "<?php echo $calendar_year;?>";
	$('.filter').click(function(){
		var default_style = $(this).text();
		$.ajax({
			method: 'get',
			url: 'wall_calendars/'+default_style+'/'+calendar_size_id+'/'+calendar_month+'/'+calendar_year,
			beforeSend: function(){
				$("#loading" ).html('<img src="'+loading+'"> <br>loading...');
			},
			success: function(data){
				$('.calendar-product-list').html(data);
			},
			error: function(e) {
				var json = JSON.stringify(e);
				//alert('Error' + json);
			}
		});
	});
	$('.nav-link').click(function(){
		var default_style = $(this).attr('rel');
		$.ajax({
			method: 'get',
			url: 'wall_calendars/'+default_style+'/'+calendar_size_id+'/'+calendar_month+'/'+calendar_year,
			beforeSend: function(){
				$("#loading" ).html('<img src="'+loading+'"> <br>loading...');
			},
			success: function(data){
				$('.calendar-product-list').html(data);
			},
			error: function(e) {
				var json = JSON.stringify(e);
				//alert('Error' + json);
			}
		});
	});
	var default_style = 0;
	/*$.ajaxSetup({ 
		headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
	}); */
	$.ajax({
		method: 'get',
		url: 'wall_calendars/'+default_style+'/'+calendar_size_id+'/'+calendar_month+'/'+calendar_year,
		beforeSend: function(){
			$("#loading" ).html('<img src="'+loading+'"> <br>loading...');
		},
		success: function(data){
			$('.calendar-product-list').html(data);
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
		var page=$(this).attr('href').split('wall_calendars')[1];
		getData(page);
    });
	function getData(page){
        $.ajax({
            url: 'wall_calendars' + page,
            type: "get",
            datatype: "html",
			beforeSend: function(){
				$("#loading" ).html('<img src="'+loading+'"> <br>loading...');
			},
        })
        .done(function(data)
        {
            console.log(data);
            $(".calendar-product-list").empty().html(data);
            location.hash = page;
        })
        .fail(function(jqXHR, ajaxOptions, thrownError){
            alert('No response from server');
        });
	}
	/*** end ajax pagination ***/
});
</script>
<style>
.filter{cursor:pointer;}
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