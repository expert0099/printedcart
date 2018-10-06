@extends("layouts.sharesite")

@section("main-content")

<div class="container">

	<section style="margin-top: 100px; margin-bottom: 50px;">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4>Share sites</h4>
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
				</div>
			</div>
			
			<div class="row">
				
				<div class="col-sm-8">
					
					<div class="row">
					@if(count($created_sites)>0)
						@foreach($created_sites as $k => $v)
						<div class="col-sm-3 sharesite-box" style="margin-bottom: 15px;">
						<form id="sharesite_{{$v->id}}" name="sharesite" class="sharesite" method="post" action="{{URL::asset('sharesite/delete_site')}}">
						{{csrf_field()}}
							<div class="share-items">
								<a href="{{url($protocol.$v->website_url .'?sid='.base64_encode($v->id))}}" target="_blank"><div class="share-items-img">
									<img src="{{URL::asset($v->template_photo)}}">
								</div></a>
								<div class="site_title">
									{{$v->site_name}}
									<select name="site" id="site" rel="{{$v->id}}">
										<option value="">-- Select --</option>
										<option value="share_to_friend">Share site to friend</option>
										<option value="delete_site">Delete this site</option>
									</select>			
								</div>
								<input type="hidden" name="sharesite_id" value="{{$v->id}}"/>
								<div class="share-site-date">
									<p>Updated {{$v->updated_at}}</p>
								</div>
							</div>
						</form>
						</div>
						@endforeach
					@else
						<div class="col-sm-3 sharesite-box" style="color:red;text-align: left;margin-bottom: 5px;">Share site not found!</div>
					@endif
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<a href="{{URL::asset('sharesite/index')}}" class="btn btn-primary">Create a site</a>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="shareMod" id="profile">
						<div class="share-profile-avatar">
							<span>
								<img class="avatar" src="{{URL::asset('public/images/procserv.jpg')}}">
							</span>
						</div>
						<div class="share-profile-right">
							<div class="share-profile-alias">
								<span>{{ Auth::user()->name }}</span>
							</div>
							<div>
								Member since {{ date('Y',strtotime(Auth::user()->created_at)) }}
							</div>
						</div>
						<br style="clear: both;">
					</div>
				</div>
			</div>
			
			<!-- share site dialog -->
			<div id="share_to_friend" title="Printed Cart : Share to friend" style="display:none; text-align:center;">
				<form name="share_form" id="share_form" method="post" action="{{URL::asset('sharesite/share_to_friend')}}">
				{{csrf_field()}}
				<input type="hidden" name="sharesite_id" id="sharesite_id"/>
				<label>Share to your friend </label>
				<input class="form-control" type="text" name="email" id="email" placeholder="Input email id (multiple emails support with comma separatted)" required="true"/>
				<label>Message for your friend</label>
				<textarea name="message" id="message" placeholder="Message" required="true" cols="60" rows="3"></textarea>
				<div style="text-align:center;margin-top:15px;">
					<button type="submit" id="proj" class="btn btn-primary">Send</button>
				</div>
				</form>
			</div>
			<!-- end share site dialog -->
			
		</div>
	</section>
</div>	

<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/redmond/jquery-ui.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->

<script>
$(function(){
	setTimeout(function() {
        $('.alert-success').fadeOut('slow');
    }, 5000); 
	setTimeout(function(){
        $('.alert-danger').fadeOut('slow');
    }, 5000);
	
	$('.sharesite select[name=site]').on('change', function(){
		var value = $(this).val();
		var sharesite_id = $(this).attr('rel');
		if(value=='delete_site'){
			if(confirm('Are you sure want to delete this site?')){
				$('#sharesite_'+sharesite_id).submit();
			}else{
				return false;
			}
		}else if(value=='share_to_friend'){
			$("#share_to_friend").dialog({
				width: 500,
				height: 300,
				dialogClass: 'dlgfixed',
				position: "center",
				modal: true,
				resizable: false,
			});
			$('#sharesite_id').val(sharesite_id);
		}
	});
});
</script>
<style>
.dlgfixed{
	top: 50%;
	left: 50%;
	-webkit-transform: translateY(-50%) translateX(-50%);
	-ms-transform: translateY(-50%) translate(-50%);
	transform: translateY(-50%) translate(-50%);
}
</style>
@endsection