<html>
	<head>
		<title>Printed Cart :: Download PDF</title>
	</head>
	<body>
		@foreach($order_pdf as $k => $pdf)
		<div><img src="{{URL::asset('public/canvas_upload/'.$user_id.'/'.$pdf->image_name)}}"></div>
		@endforeach
	</body>
</html>