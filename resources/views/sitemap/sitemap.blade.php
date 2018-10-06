@extends("layouts.home")

@section("main-content")

<section class="page-feature-product m-40">
	
	<div class="w-96">
		<div class="text-center featured-title">
			<h1 class="bg-white d-inline-block pr-5 pl-5">Sitemap</h1>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 mb-12 mb-md-0">
					<div id="content"> 
						<?php 
						$contents = simplexml_load_file("http://printedcart.com/printedcart/public/sitemap.xml");
						?>
						<table id="sitemap" cellpadding="3">
							<thead>
								<tr>
									<td width="80%">This sitemap contains {!!count($contents)!!} URLs.</td>
								</tr>
								<tr>
									<th width="80%">URL</th>
									<th width="5%">Priority</th>
									<th width="15%">Change Freq.</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($contents->url as $k => $content){
									?>
									<tr>
										<td><a href="{{$content->loc}}">{!!$content->loc!!}</a></td>
										<td>{!!$content->priority!!} ({!! floatval($content->priority)*100 !!}%)</td>
										<td>{!!$content->changefreq!!}</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</section>

<style>
.m-40 {
    margin: 40px 0;
}
.w-80 {
	width: 92%;
}
#content {
    margin: 0 auto;
    width: 1000px;
}
body {
    font-family: Helvetica, Arial, sans-serif;
    font-size: 13px;
    color: #545353;
}
table {
    border: none;
    border-collapse: collapse;
}
thead th {
    border-bottom: 1px solid #000;
    cursor: pointer;
}
th {
    text-align: left;
    padding-right: 30px;
    font-size: 11px;
}
td {
    font-size: 11px;
}
a {
    color: #000;
    text-decoration: none;
}
</style>
@endsection


