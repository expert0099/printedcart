@extends("layouts.photobook")

@section("main-content")

<div class="continer-fluid">
	@include('photobook.banner_mmb')
</div>

<div class="container">
	<div class="row pb-4">
		<div class="col-lg-12 pt-4">
			<h3>Congratulations</h3>
			<p>Our designers will create your photo book for you and place it in your account by <?php echo date('d-m-Y',strtotime('+7 Days'))?>. We will send you an email when it is ready. You can order the book as-is or add your own finishing touches.</p>
			<h4>Order details</h4>
			<p><i class="icon-check"></i> Size: {!!$book_size!!}</p>
			<p><i class="icon-check"></i> Style: {!!$style_name!!}</p>
			<p><i class="icon-check"></i> Ref Book: {!!$photobook_name!!}</p>
			<p><i class="icon-check"></i> Title: {!!$mybook_name!!}</p>
			<p><i class="icon-check"></i> Photos: {!!$photo!!}</p>
		</div>
	</div>
</div>
<style>
.icon-check {
	background-image: url(../../public/images/sprite.png);
	background-position: -1142px -317px;
	width: 28px;
	height: 25px;
	display: inline-block;
}
</style>
@endsection