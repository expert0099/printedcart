@extends("layouts.calendar")

@section("main-content")

<div class="container">
	<div class="row pt-2 pt-md-5 calandar-listing-page page-top-gapping">
		<div class="col-md-5 col-lg-4 col-xl-3 pt-4 mt-0 mt-md-3">
			<aside class="calendar-sidebar">
				<div class="card text-white rounded-0">
					<div class="card-header bg-blue rounded-0">
						<div class="sidebar-filter float-left"><i class="fa fa-sliders" aria-hidden="true"></i> Filters</div>
						<div class="sidebar-filter-clear float-right">Clear</div>
					</div>
					<div class="card-body">
						<div id="exampleAccordion" data-children=".item">
							<div class="item mb-3 pb-2">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion3" aria-expanded="false" aria-controls="exampleAccordion1">Featured</a>
								<div id="exampleAccordion3" class="collapse show" role="tabpanel">
									<div class="row pb-3">
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="art_library" rel="1">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">Art Library</span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="item mb-3 pb-2">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion2" aria-expanded="false" aria-controls="exampleAccordion1"># of photos</a>
								<div id="exampleAccordion2" class="collapse show" role="tabpanel">
									<div class="row pb-3">
										<div class="col-2 pr-1 mr-2">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="of_photos" rel="0">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">0</span>
											</label>
										</div>	
										<div class="col-2 pl-2 pr-1">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="of_photos" rel="1">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">1</span>
											</label>
										</div>
										<div class="col-2 pl-2 pr-1">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="of_photos" rel="2">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">2</span>
											</label>
										</div>
										<div class="col-2 pl-2 pr-1">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="of_photos" rel="3">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">3</span>
											</label>
										</div>
										<div class="col-2 pl-2 pr-0">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="of_photos" rel="4">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">4+</span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="item poster-size-box mb-3 pb-2">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion1" aria-expanded="false" aria-controls="exampleAccordion1">Trim options</a>
								<div id="exampleAccordion1" class="collapse show" role="tabpanel">
									<div class="row flex-row pb-2">
										<div class="size-one text-center mb-2 px-3">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="corners" rel="reg_corner">
												<span class="custom-control-indicator"></span>
											</label>
										</div>
										<div class="size-two text-center mb-2 ">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="corners" rel="round_corner">
												<span class="custom-control-indicator"></span>
											</label>
										</div>
									</div>
								</div>
							</div>							
							<div class="item mb-3 pb-2">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion6" aria-expanded="false" aria-controls="exampleAccordion1">Designer</a>
								<div id="exampleAccordion6" class="collapse show" role="tabpanel">
									<div class="row pb-3">
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="designer" rel="float_paperie">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">Float Paperie</span>
											</label>
										</div>
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="designer" rel="paper_plains">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">Paper Plains</span>
											</label>
										</div>
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="designer" rel="potts_design">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">Pottsdesign</span>
											</label>
										</div>
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="designer" rel="yours_truly">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">Yours Truly</span>
											</label>
										</div>
									</div>
								</div>
							</div>	
							<!--<div class="item border-0">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion7" aria-expanded="false" aria-controls="exampleAccordion1">Recently viewed</a>
								<div id="exampleAccordion7" class="collapse show" role="tabpanel">
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
			<div class="calendar-liting-section mt-4 mt-md-0">
				<h4 class="fz-26">Easel Calendars</h4>
				<div class="calendar-thumb-top-bar d-lg-flex">	
					<div class="col-12 col-md-12 col-lg-8 p-0 text-center text-lg-left mb-3 mb-lg-0"><p class="fz-14 m-0">Sort by: <span class="font-weight-bold">Best sellers</span> | Price</p></div>
					<div class="col-12 col-md-12 col-lg-4 ml-lg-auto text-center text-lg-right">
						<!--<div class="calandar-fav-top-bar">
							<div class="cal-fav-icon-top position-relative d-inline-block mr-3">
								<i class="fa fa-heart-o fz-22" aria-hidden="true"></i>
								<span class="cal-fav-count-top fz-12 bg-blue rounded-circle text-center text-white">2</span>
							</div>
							<p class="fz-14 m-0 d-inline-block">My Favorites</p>
						</div>-->
					</div>
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
<script type="text/javascript">
$(function(){
	var loading = "{{URL::asset('public/images/loader.gif')}}";
	var art_library = $("input:checkbox[name='art_library']:checked").map(function(){
		return $(this).attr('rel');
	}).get().join(",");
	var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
		return $(this).attr('rel');
	}).get().join(",");
	var corners = $("input:checkbox[name=corners]:checked").map(function(){
		return $(this).attr('rel');
	}).get().join(",");
	var designer = $("input:checkbox[name=designer]:checked").map(function(){
		return $(this).attr('rel');
	}).get().join(",");
	$.ajaxSetup({ 
		headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
	});
	$.ajax({
		method: 'post',
		url: 'easel_calendars',
		data: {art_library:art_library, of_photos:of_photos, corners:corners, designer:designer},
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
		var page=$(this).attr('href').split('easel_calendars')[1];
		getData(page);
    });
	function getData(page){
		var art_library = $("input:checkbox[name='art_library']:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var corners = $("input:checkbox[name=corners]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var designer = $("input:checkbox[name=designer]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
        $.ajax({
            url: 'easel_calendars' + page,
            type: "post",
            datatype: "html",
			data: {art_library:art_library, of_photos:of_photos, corners:corners, designer:designer},
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
	
	/*** filter sidebar ***/
	$("input:checkbox[name='art_library']").on("click",function(){ //art_library
		var art_library = $("input:checkbox[name='art_library']:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var corners = $("input:checkbox[name=corners]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var designer = $("input:checkbox[name=designer]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
			method: 'post',
			url: 'easel_calendars',
			data: {art_library:art_library, of_photos:of_photos, corners:corners, designer:designer},
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
	
	$("input:checkbox[name='of_photos']").on("click",function(){ // of_photos
		var art_library = $("input:checkbox[name='art_library']:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var corners = $("input:checkbox[name=corners]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var designer = $("input:checkbox[name=designer]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
			method: 'post',
			url: 'easel_calendars',
			data: {art_library:art_library, of_photos:of_photos, corners:corners, designer:designer},
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
	
	$("input:checkbox[name='corners']").on("click",function(){ //corners
		var art_library = $("input:checkbox[name='art_library']:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var corners = $("input:checkbox[name=corners]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var designer = $("input:checkbox[name=designer]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
			method: 'post',
			url: 'easel_calendars',
			data: {art_library:art_library, of_photos:of_photos, corners:corners, designer:designer},
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
	
	$("input:checkbox[name='designer']").on("click",function(){
		var art_library = $("input:checkbox[name='art_library']:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var corners = $("input:checkbox[name=corners]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var designer = $("input:checkbox[name=designer]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		$.ajaxSetup({ 
			headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
		});
		$.ajax({
			method: 'post',
			url: 'easel_calendars',
			data: {art_library:art_library, of_photos:of_photos, corners:corners, designer:designer},
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
	/*** end filter sidebar ***/
});
</script>
@endsection