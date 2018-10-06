<!--<div id="loading" style="text-align:center;"></div>-->
<ul id="image-gallery2" class="gallery list-unstyled cS-hidden">
	@foreach($savedProj as $key => $page)
		<li>{!! $page->page_content !!}</li>
	@endforeach
</ul>
