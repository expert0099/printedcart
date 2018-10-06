@extends("layouts.home")

@section("main-content")



<div class="container">

	<?php /*@include('pages.myphoto_banner')*/?>
	
	<!-- Calander Page Info Start -->
	<section class="clander-page-info mt-5 mb-3">
		<div class="row">
			<div class="col-12">
			
				@foreach($errors->all() as $error)
					<p class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
					{{ $error }}
					</p>
				@endforeach
				
				
				@if(session('success_msg'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="cursor:pointer;"><span aria-hidden="true">×</span></button>
						{{ session('success_msg') }}
					</div>
				@endif
				
							
				
				
				<!-- my photo content -->
				<div class="content-body">
					<h5>Google Photos</h5>
					<div class="grid">
						<div class="cap-mid">
							<h6 class="text-blue"><a href="{{URL::asset('user/my_photos')}}" style="text-decoration:underline;">Back to My Photos</a></h6>
							{!! Form::open(['method' => 'POST', 'url' => ['user/add_google_photo'],'enctype'=>'multipart/form-data']) !!}
							<div class="row">
								<input type="checkbox" id="checkAll"/> Check All
							</div>
							<div class="row">
								@if(count($list_album)>0)
									@foreach($list_album['Album'] as $k => $o)
										<div class="albumBack col-sm-6 col-md-2" style="padding-top:15px; padding-bottom:15px;">
											<table class="albumtable" style="padding:0px 0px 5px 0px" cellspacing="0" cellpadding="0" border="0">
												<tbody>
													<tr>
														<td class="albumcell">
															<div class="albumlink position-relative">
																<img src="{{$o['media_items']['baseUrl']}}" style="vertical-align:middle;text-align:center; border-radius: 10px" p="{{$o['media_items']['id']}}" rel="{{ $o['media_items']['productUrl'] }}" alt="Google Photo" class="fancybox coverImage">
																<span><input type="checkbox" class="cb-element" name="google_photo[{{$o['media_items']['baseUrl']}}]"/></span>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									@endforeach
									
									<div>
										{!! Form::label('album_name', 'Album Name', ['class' => 'control-label']) !!}
										{!! Form::select('album_id', $album, ['class' => 'form-control', 'required'=>'true']) !!}
										
										{!! Form::submit('Add photo', ['id' => 'insta_add','class' => 'btn btn-primary']) !!}
									</div>
								@else
									<hr style="width:100%;"/>
									<div style="color:red;text-align:center; min-height:300px;width:100%;">Google photos not found at this moment.</div>
								@endif
							</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				<!-- end my photo content -->
				
			
			</div>
		</div>
	</section>
	<!-- Calander Page Info End -->

</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
$(function(){
	setTimeout(function() {
        $('.alert-success').fadeOut('fast');
    }, 10000); 
	setTimeout(function(){
        $('.alert-danger').fadeOut('fast');
    }, 20000);
	
	$("#checkAll").change(function (){
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});
	
	$("#insta_add").on('click',function(){
		if($('.cb-element:checkbox:checked').length == 0){
			//alert('Check Atleast One Checkbox');
			swal("Oops!", "Check Atleast One Checkbox...!", "error");
			return false;
		}else{
			return true;
		}
	});
	
});
/* $(document).ready(function(){
    $('.check:button').toggle(function(){
        $('input:checkbox').attr('checked','checked');
        $(this).val('uncheck all')
    },function(){
        $('input:checkbox').removeAttr('checked');
        $(this).val('check all');        
    })
}) */
</script>
<style>
.coverImage {
	height: 144px;
}
</style>
<!-- start fancybox -->
<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css" />
<style type="text/css">
a.fancybox img {
	border: none;
	box-shadow: 0 1px 7px rgba(0,0,0,0.6);
	-o-transform: scale(1,1); -ms-transform: scale(1,1); -moz-transform: scale(1,1); -webkit-transform: scale(1,1); transform: scale(1,1); -o-transition: all 0.2s ease-in-out; -ms-transition: all 0.2s ease-in-out; -moz-transition: all 0.2s ease-in-out; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out;
} 
a.fancybox:hover img {
	position: relative; z-index: 999; -o-transform: scale(1.03,1.03); -ms-transform: scale(1.03,1.03); -moz-transform: scale(1.03,1.03); -webkit-transform: scale(1.03,1.03); transform: scale(1.03,1.03);
}
.ui-dialog .ui-dialog-buttonpane button {
    background-color: #40b3d9 !important;
    color: #fff;
}
.ui-dialog .ui-dialog-buttonpane button:hover {
    background-color: #0062cc !important;
}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.pack.min.js"></script>
<script type="text/javascript">
$(function($){
	var addToAll = false;
	var gallery = true;
	var titlePosition = 'inside';
	$(addToAll ? 'img' : 'img.fancybox').each(function(){
		var $this = $(this);
		var title = $this.attr('title');
		var src = $this.attr('data-big') || $this.attr('src');
		var a = $('<a href="#" class="fancybox"></a>').attr('href', src).attr('title', title);
		$this.wrap(a);
	});
	if (gallery)
		$('a.fancybox').attr('rel', 'fancyboxgallery');
	$('a.fancybox').fancybox({
		titlePosition: titlePosition
	});
});
$.noConflict();
</script>
<!-- end fancybox -->
@endsection