@extends("layouts.sharesite")

@section("main-content")

<div class="container">
	<section style="margin-top: 100px; margin-bottom: 50px;">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="category-heading">Choose a design for your site</h3>
					@foreach($errors->all() as $error)
						<p class="alert alert-danger">{{ $error }}</p>
					@endforeach
				</div>
				
			</div>
			<!--<div class="row">
				<div class="col-sm-12">
					<ul class="designs-type">
						<span>See: </span>
						<li class="active"><a href="">Recommended</a></li>
						<li><a href="">Colors</a></li>
						<li><a href="">Patterns</a></li>
						<li><a href="">Seasonal</a></li>
						<li><a href="">All</a></li>
					</ul>
				</div>
			</div>-->
			<form id="choose_design" name="choose_design" method="post" action="{{URL::asset('sharesite/choose_design')}}">
			<div class="row design-themes">
				{{csrf_field()}}
				<input type="hidden" name="sharesite_id" value="{{$sharesite_id}}"/>
				
				@if(count($template)>0)
								
				@foreach($template as $k => $v)
				<div class="col-sm-3">
					<article class="article @if($k==0)select @endif">
						<span>{{$v->template_name}}</span>
						<figure>
							<img src="{{ URL::asset($v->template_photo) }}">
							<input type="radio" name="img" value="1" checked>
							<figcaption><a href="">View Larger</a></figcaption>
						</figure>
						<input type="radio" name="template_design" value="{{$v->id}}" @if($k==0) checked @endif />
					</article>
					
				</div>
				@endforeach
				
				@else
					<div class="col-sm-3" style="color:red;text-align:center;">No template found!</div>
				@endif
				
			</div>
	
			<div class="row">
				<div class="col-sm-12">
					<a href="javascript:history.back()" class="btn btn-primary">Back</a>
					<!--<a href="" class="btn-create-site">Create Site</a>-->
					<input type="submit" name="submit" value="Create Site" class="btn btn-primary">
				</div>
			</div>
			</form>
		</div>
	</section>	
</div>
<script>
$(function(){
	$('input[name=template_design]').on('click',function(){
		$('.article').removeClass('select');
		$(this).parent('.article').addClass('select');
	});
});
</script>
@endsection