@extends("layouts.calendar")

@section("main-content")

<div class="container">
	<div class="row pt-2 pt-md-5 page-top-gapping">
		<div class="col-md-5 col-lg-4 col-xl-3 pt-4 mt-0 mt-md-3">
			<aside class="calendar-sidebar">
				<div class="card text-white rounded-0">
					<div class="card-header bg-blue rounded-0">
						<div class="sidebar-filter float-left"><i class="fa fa-sliders" aria-hidden="true"></i> Filters</div>
						<div class="sidebar-filter-clear float-right">Clear</div>
					</div>
					<div class="card-body">
						<div id="exampleAccordion" data-children=".item">
							<div class="item poster-size-box mb-3 pb-2">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion1" aria-expanded="false" aria-controls="exampleAccordion1">Poster Size</a>
								<div id="exampleAccordion1" class="collapse show" role="tabpanel">
									<div class="row">
										@foreach($sizes as $k => $v)
										<div class="col-4 size-one text-center mb-2">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="design_size" rel="{!! $v['Size'] !!}">
												<span class="custom-control-indicator"></span>
											</label>
											<span class="custom-control-description fz-14 d-block mt-2">{!! $v['Size'] !!}</span>
										</div>
										@endforeach
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
							<div class="item mb-3 pb-2">
								<a data-toggle="collapse" data-parent="#exampleAccordion" href="#exampleAccordion3" aria-expanded="false" aria-controls="exampleAccordion1">Style</a>
								<div id="exampleAccordion3" class="collapse show" role="tabpanel">
									<div class="row pb-3">
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
											<input type="checkbox" class="custom-control-input" name="design_style" rel="Classic">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description fz-14">Classic</span>
											</label>
										</div>
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
											<input type="checkbox" class="custom-control-input" name="design_style" rel="Art Collection">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description fz-14">Art Collection</span>
											</label>
										</div>											
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
											<input type="checkbox" class="custom-control-input" name="design_style" rel="Calendars">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description fz-14">Calendars</span>
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
												<input type="checkbox" class="custom-control-input" name="designer" rel="disney">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">Disney</span>
											</label>
										</div>
										<div class="col-12">
											<label class="custom-control custom-checkbox m-0">
												<input type="checkbox" class="custom-control-input" name="designer" rel="printedcart">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description fz-14">Printedcart</span>
											</label>
										</div>
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
			@if($errors->any())
				@foreach ($errors->all() as $error)
					<div class="alert alert-dismissable alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button" style="cursor:pointer;">×</button> 
						<strong>Error</strong>: {{ $error }}
					</div>	
				@endforeach
			@endif 
			<div class="calendar-liting-section mt-4 mt-md-0">
				<h4 class="fz-26">College Posters</h4>
				<div class="calendar-thumb-top-bar d-lg-flex">	
					<div class="col-12 col-md-12 col-lg-8 p-0 text-center text-lg-left mb-3 mb-lg-0"><p class="fz-14 m-0">Sort by: <span class="font-weight-bold">Best sellers</span> | Price</p></div>
					<div class="col-12 col-md-12 col-lg-4 ml-lg-auto text-center text-lg-right">
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
.pagination li a {
    display: inline-block;
    padding: 0px;
    margin-right: 4px;
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
    width: 30px;
	text-align: center;
	line-height: 30px;
}
.pagination li span {
    display: inline-block;
    font-size: .875em;
    font-weight: bold;
    line-height: 30px;
    width: 30px;
    text-align: center;
    padding: 0;
}

.pagination li a:hover {
    display: inline-block;
	background: #0099cc;
	color: #fff;
	padding: 0;
	width: 30px;
	text-align: center;
	line-height: 30px;
}

.pagination li.active {
    display: inline-block;
    padding: 0px;
    margin-right: 4px;
    background: #0099cc;
    font-size: .875em;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    width: 30px;
    text-align: center;
    line-height: 30px;
}
.pagination li.disabled{
	display: inline-block;
    padding: 0px;
    margin-right: 4px;
}
</style>
<script type="text/javascript">
$(function(){
	var loading = "{{URL::asset('public/images/loader.gif')}}";
	var design_size = $("input:checkbox[name=design_size]:checked").map(function(){
		return $(this).attr('rel');
	}).get().join(",");
	var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
		return $(this).attr('rel');
	}).get().join(",");
	var design_style = $("input:checkbox[name=design_style]:checked").map(function(){
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
		url: 'college_poster',
		data: {design_size:design_size, of_photos:of_photos, design_style:design_style, designer:designer},
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
		var page=$(this).attr('href').split('college_poster')[1];
		getData(page);
    });
	function getData(page){
		var design_size = $("input:checkbox[name=design_size]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var design_style = $("input:checkbox[name=design_style]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var designer = $("input:checkbox[name=designer]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
        $.ajax({
            url: 'college_poster' + page,
            type: "post",
            datatype: "html",
			data: {design_size:design_size, of_photos:of_photos, design_style:design_style, designer:designer},
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
	$("input:checkbox[name=design_size]").on("click",function(){ //design_size
		var design_size = $("input:checkbox[name=design_size]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var design_style = $("input:checkbox[name=design_style]:checked").map(function(){
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
			url: 'college_poster',
			data: {design_size:design_size, of_photos:of_photos, design_style:design_style, designer:designer},
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
	
	$("input:checkbox[name=of_photos]").on("click",function(){ // of_photos
		var design_size = $("input:checkbox[name=design_size]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var design_style = $("input:checkbox[name=design_style]:checked").map(function(){
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
			url: 'college_poster',
			data: {design_size:design_size, of_photos:of_photos, design_style:design_style, designer:designer},
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
	
	$("input:checkbox[name=design_style]").on("click",function(){ //design_style
		var design_size = $("input:checkbox[name=design_size]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var design_style = $("input:checkbox[name=design_style]:checked").map(function(){
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
			url: 'college_poster',
			data: {design_size:design_size, of_photos:of_photos, design_style:design_style, designer:designer},
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
	
	$("input:checkbox[name=designer]").on("click",function(){
		var design_size = $("input:checkbox[name=design_size]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var of_photos = $("input:checkbox[name=of_photos]:checked").map(function(){
			return $(this).attr('rel');
		}).get().join(",");
		var design_style = $("input:checkbox[name=design_style]:checked").map(function(){
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
			url: 'college_poster',
			data: {design_size:design_size, of_photos:of_photos, design_style:design_style, designer:designer},
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