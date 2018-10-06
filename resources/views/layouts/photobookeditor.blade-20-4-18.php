<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="_token" content="{{ csrf_token() }}" />
		<title>Printedcart: Shop</title>
		<style type="text/css">
		#wrapper{ width: 80%; text-align: center; margin: 0 auto; }
		.thumbimage {
			float:left;
			width:100px;
			position:relative;
			padding:5px;
		}
		</style>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/custom.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/common-page.css') }}">
			
		<!-- Bootstrap Script -->
		<script type="text/javascript" src="{{ URL::asset('public/js/jquery-3.2.1.slim.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('public/js/bootstrap.min.js') }}"></script>
		
		<!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="{{ asset('public/extras/modernizr.2.5.3.min.js') }}"></script>-->
		
		<script type="text/javascript">
		$(document).ready(function() {
			$("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
				e.preventDefault();
				$(this).siblings('a.active').removeClass("active");
				$(this).addClass("active");
				var index = $(this).index();
				$("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
				$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
			});
		});

		
		</script>
	</head>
	
	<body>
		<header>
			@include('layouts.partials.editorheader')
		</header>
		
		@yield('main-content')
		
<!-- 		<footer>
<div id="preview-uploaded-image" class="drag-elements droppable multipleChildren hasChild" style="height: 100px;"></div>
		</footer> -->
 <!-- Modal for upload image -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Upload Photos</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <form id="UploadImgForm" name="UploadImgForm" enctype="multipart/form-data">
          <div class="form-group"> 
            <label for="albums">Select Album:</label>
            <select id="albums" name="albums" class="form-control" required="">
              <option value="">Select Album</option>
              @foreach($albums as $album)
              <option value="{{$album->id}}">{{$album->album_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group"> 
            <a class="nav-link" href="#" data-toggle="modal" data-target="#NewAlbum"><i class="fa fa-picture-o" aria-hidden="true"></i> New Album</a>
          </div>
          <div class="form-group"> 
            <label for="imageupload">Select Image:</label>
            <input id="imageupload" type="file" name="files[]" multiple  class="form-control"/>
          </div>
          <div class="form-group"> 
              <div id="preview-image" style="height: 100px;"></div>
          </div>
          <div class="form-group"> 
              <input type="submit" name="Upload" id="Upload" value="Upload" style="display: block;">
          </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal for new album -->
<div class="modal fade" id="NewAlbum" role="dialog" style="background: #000">
    <div class="modal-dialog modal-lg">
      <form id="NewAlbumForm" name="NewAlbumForm" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">New Album</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>          
          </div>
          <div class="modal-body"> 
            <div class="form-group">  
                <label for="albumName">Name:</label>      
                <input type="text" name="albumName" id="albumName" class="form-control" required="">
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit"  class="btn btn-default" name="Upload" id="Upload" value="OK" >
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<!--<script type="text/javascript" src="{{ URL::asset('public/js/jquery.min.js') }}"></script>	
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>-->
<script type="text/javascript">
/*preview image on upload */
 $("#imageupload").on('change', function () { 
     //Get count of selected files
     var countFiles = $(this)[0].files.length; 
     var imgPath = $(this)[0].value;
     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
     var image_holder = $("#preview-image");
     image_holder.empty();
 
     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
          if (typeof (FileReader) != "undefined") {
 
             //loop for each file selected for uploaded.
             for (var i = 0; i < countFiles; i++) {
 
                 var reader = new FileReader();
                 reader.onload = function (e) {
                     $("<img />", {
                         "src": e.target.result,
                             "class": "thumbimage"
                     }).appendTo(image_holder);
                 }
 
                 image_holder.show();
                 $("#Upload").show();
                 reader.readAsDataURL($(this)[0].files[i]);
             }
 
         } else {
             alert("This browser does not support FileReader.");
         }
     } else {
         alert("Pls select only images");
     }
 });

/*submit form and upload images on click uploaded pics*/
$("#UploadImgForm").submit(function(){
    var frmData = new FormData($(this)[0]); 
    // alert(frmData);   
    $.ajaxSetup({ 
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
    });
    $.ajax({
            url : 'upload_new_images',            
            type : 'POST',
            data : frmData,
            processData: false,
            contentType: false,
            cache:false,
            success : function(data){
				//alert(data);
                $("#preview-image").html("");
                $("#UploadImgForm").trigger("reset");
				// dragImg("#preview-uploaded-image", "#dvDest");
				$('.ui-dialog-titlebar-close').trigger('click');
				window.location.reload();
			}
        });

    return false;

})

/*submit form and upload images on click uploaded pics*/
$("#NewAlbumForm").submit(function(){
    var frmData = new FormData($(this)[0]); 
    // alert(frmData);   
    $.ajaxSetup({ 
		headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') } 
    });
    $.ajax({
		url : 'add_new_album',            
		type : 'POST',
		data : frmData,
		processData: false,
		contentType: false,
		cache:false,
		success : function(data){
			$("#albums").append(data); 
			$("#NewAlbumForm").trigger("reset");
			$('#NewAlbumForm .close').trigger('click');
			$('#myModal').dialog({
				width: 600,
				height: 600,
				modal: true,
				resizable: false
			}); 
		}
	});
    return false;
});

$("#albumListsLi li").click(function(){
    var cid = $(this).attr("label");
    var cln = $("#"+cid).html();
    $("#SelectAlbumPics").html(cln);  
}); 
 </script>
	</body>
</html>