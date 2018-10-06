<?php 
$up_wi = explode("x",$rel);
if($up_wi[0]>$up_wi[1]){
	$ratio = $up_wi[1]/$up_wi[0]*100;
	$width = 100;
	$height = round($ratio);
}else{
	$ratio = $up_wi[0]/$up_wi[1]*100;
	$width = round($ratio);
	$height = 100;
}
?>
<div class="uploaded_image">
	<img id="uploaded_image_{{$rel}}" src="{{$path}}" style="width:{{$width}}px;height:{{$height}}px;"><br/>
	{{$rel}} {{$sizeType}}
</div>