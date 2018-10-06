$(document).ready(function()
{
	var area1,area2,area3,areaone,areatwo,areathree,areafour,area5,area5l;     
	
	function sort_unique(arr)
	{
		arr = arr.sort(function (a, b)
		{
			return a*1 - b*1;
		}
		);
		var ret = [arr[0]];
		for (var i = 1; i <arr.length; i++)
		{
			if(arr[i]!=0)
			{
				if (arr[i-1] !== arr[i])
				{
					ret.push(arr[i]);
				}
			}
		}
		return ret;
	}
	


$(".images").draggable();	
	
	window.onkeyup = function (event) {
		if (event.keyCode == 27) {
			$("#saverInform").hide('slow');
		}
	}

$("#addMore").click(function(){

	$("#saverInform").show();
   var wholepage=$("#every_content").html();
					var color=$("#currentcolor").val();
					var currentpage=$("#currentpage").val();
					var totalpages=$("#totalpages").val();
					var ppp=$("#ppp").val();
					$.ajax({
						type:"POST",
						url:'save_everything.php',
						data:'content='+wholepage+'&totalpages='+totalpages+'&color='+color+'&currentpage='+currentpage+'&ppp='+ppp
						}).done(function()
					{
						$("#saverInform").hide();
						if(confirm("Click OK to add more photos"))
						{
							sl=0;
							var urllink=baseDir+'modules/photobook/addmore.php';
							window.location.href=urllink;
							//window.close();
						}
						else
						{
							return false;
						}
						});
});
	
	
	$("#rightPanleSelect").click(function()
	{
		$("#leftSlidingDiv").hide('slow');
		var cpg=$("#currentpage").val();
		if(cpg!="last")
		{
			$("#rightSlidingDiv").toggle('slow');
		}

		
	}); 
	$("#leftPanelSelect").click(function()
	{
		var cpg=$("#currentpage").val();
		$("#rightSlidingDiv").hide('slow');
		if(cpg!="first")
		{
			$("#leftSlidingDiv").toggle('slow');
		}
	
		
	}); 

	var sl=1;
	$("#addtocart").click(function()
	{
	 closealltext();
		$("#saverInform").show();
		savethepage();
		var totalslides=parseInt($("#totalpages").val())+1;
		var i=1;
		var inc=1;
		for(i=1;i<=totalslides;i++)
		{
			var url = "save_image.php"; 
			var lastnot='&last=false';		
			if(i==1)
			{
				var is='first';
				var lid="left_lay_"+is;
				var rid="right_lay_"+is;
			}
			else if(i==totalslides)
			{
				var is='last';
				var lastnot='&last=true';
				var lid="left_lay_last";
				var rid="right_lay_last";
			}
			else
			{
				var is=i;
				var lid="left_lay_"+is;
				var rid="right_lay_"+is;
			}
			var leftcontent='left'+is;
			var rightcontent='right'+is;
			var imageCont1=$('#'+leftcontent).html();
			var imageCont2=$('#'+rightcontent).html();   
			var leftlayoutid=$("#"+lid).val();
			var rightlayoutid=$("#"+rid).val();
			var lefttext=getText(is,'left',leftlayoutid);
			var righttext=getText(is,'right',rightlayoutid);
			var colorselected=$("#currentcolor").val();	 
			if(i==totalslides)
			{
				var is=i;
			}
			$.ajax({
				type: "POST",
				url: url,
				data: 'left='+imageCont1+'&right='+imageCont2+'&pageid='+is+'&inputLeft='+lefttext+'&inputRight='+righttext+lastnot+'&rightlayoutid='+rightlayoutid+'&leftlayoutid='+leftlayoutid+'&color='+colorselected
				}).done(function(response)
			{
				if(response=='lastpage')
				{
					var wholepage=$("#every_content").html();
					var color=$("#currentcolor").val();
					var currentpage=$("#currentpage").val();
					var totalpages=$("#totalpages").val();
					var ppp=$("#ppp").val();
					$.ajax({
						type:"POST",
						url:'save_everything.php',
						data:'content='+wholepage+'&totalpages='+totalpages+'&color='+color+'&currentpage='+currentpage+'&ppp='+ppp
						}).done(function()
					{
						$("#saverInform").hide();
						if(confirm("Are you sure to proceed Cart"))
						{
							sl=0;
							var urllink=baseDir+'modules/photobook/addtocart.php';
							window.location.href=urllink;
							//window.close();
						}
						else
						{
							return false;
						}
						});
				}
				});
		}
		});
	
	function showPrices()
	{
		var tp=$("#totalpages").val();
		var ppp=$("#ppp").val();
		var pri=parseFloat(ppp)*parseFloat(tp);
		$("#calcualtePrice").html(pri);
	}
	var preventUnloadPrompt;
	$(window).bind("beforeunload", function(e)
	{
		if(sl==1)
		{
			window.opener.location.href=baseDir+'Photobook';
			var rval;
			if(preventUnloadPrompt)
			{
				return;
			}
			else {   
				return false;
			}
			return rval;
		}
		})	
	$("#saveExit").click(function()
	{
	   closealltext();
		$("#saverInform").show();
		var wholepage=$("#every_content").html();
		var color=$("#currentcolor").val();
		var currentpage=$("#currentpage").val();
		var totalpages=$("#totalpages").val();
		var ppp=$("#ppp").val();
		$.ajax({
			type:"POST",
			url:'save_everything.php',
			data:'content='+wholepage+'&totalpages='+totalpages+'&color='+color+'&currentpage='+currentpage+'&ppp='+ppp
			}).done(function()
		{
			$("#saverInform").hide();
			if(confirm("Are you sure to exit Window"))
			{
				sl=0;
				var urllink=baseDir+'Photobook';
				window.location.href=urllink;
				//window.close();
			}
			else
			{
				return false;
			}
			});
	}
	);
	$("#NextPage").click(function()
	{
		var cpg=$('#totalpages').val();
		var nid=parseInt(cpg)+1;
		var pagesallowed=$("#pagesallowed").val();			
		if(nid<=pagesallowed)
		{
			var slnme='slide'+nid;    		
			var left='left'+nid;
			var right='right'+nid;    		
			var btnid='button'+nid;    		
			var color=$("#currentcolor").val();
			var nextpage='<div id="'+slnme+'" class="slides"><input id="left_lay_'+nid+'" type="hidden" value="1"/><input id="right_lay_'+nid+'" type="hidden" value="1"/> <div class="leftPanel" id="'+left+'">'+layout1(nid,'left')+'</div>  <div class="rightPanel" id="'+right+'">'+layout1(nid,'right')+'</div> </div>';    		
			$(".mainbook").append(nextpage);     		
			var newbutton= '<div class="buttonsIn"><input type="button" value="'+nid+'" class="pageButtons"  style="width:30px" id="'+btnid+'"/></div>';    		
			$("#numberButtons").append(newbutton);    		
			$(".slides").hide();
			$("#"+slnme).show();
			$("#currentpage").val(nid);
			$("#totalpages").val(nid); 
			$(".leftPanel").css('background-color',color);
			$(".rightPanel").css('background-color',color);
			$(".areas").css('background-color',color);
			colorit(nid);
			hidelayoutselector();
			hide11thlayout();
			savethepage();
			showPrices();
			closealltext();
		}
		else
		{
			$("#pagesError").html("Maximum Pages reached");
		}
		});
	$(".pageButtons").live('click',function()
	{
		var fc=this.value;
		if(fc=='Front Cover')
		{
		fc='first'}
		if(fc=='Back Cover')
		{
		fc='last'}
		var slnme='slide'+fc;
		$(".slides").hide();
		$("#"+slnme).show();
		$("#currentpage").val(fc);
		closealltext();
		colorit(fc);
		hidelayoutselector();
		hide11thlayout();
		savethepage();
		showPrices();
		
	}
	);	
	
	function setLayout(pageno,layoutid,side)
	{
	
		var prev_id='#left_lay_'+pageno;
		var previd=$(prev_id).val();
		if(previd==11 && layoutid!=11)
		{
			splitwidth(pageno,side);
		}
		if(side=='left')
		{
			var inputid='left_lay_'+pageno;
		}
		else
		{
			var inputid='right_lay_'+pageno;
		}
		
		$("#"+inputid).val(layoutid);
		
			borderColoring();
				
	}
	
	
	function borderColoring()
	{
		var colorcode=$("#currentcolor").val();
		if(colorcode=="#ffffff") {
		$('.leftPanel').css('color','#000000');
		$('.rightPanel').css('color','#000000');
			$(".areas").css('border','1px dashed #000000');
			$('.textinside').css('color','#000000');			
			$('.txtcolor').css('color','#000000');
			$('.nicEdit-main').css('color','#000000');
			$('.txtcolor').css('border','1px dotted #000000');
		} else {
		$('.leftPanel').css('color','#ffffff');
		$('.rightPanel').css('color','#ffffff');
			$(".areas").css('border','1px dashed #ffffff');
			$('.textinside').css('color','#ffffff');
			$('.txtcolor').css('color','#ffffff');
			$('.nicEdit-main').css('color','#ffffff');
			$('.txtcolor').css('border','1px dotted #ffffff');
		}
		
	}
	
	// Layout right one creation
	$(".right_slide_layout1").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp;    
		 	
		var insideCont=layout1(cp,'right');
		$('#'+rightpanel).html(insideCont);
		
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,1,'right');
		
	}
	);
	$(".right_slide_layout2").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp;    	
		var insideCont=layout2(cp,'right');  
		
		$('#'+rightpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,2,'right'); 
	}
	);
	$(".right_slide_layout3").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp;    
		var insideCont=layout3(cp,'right');
		 	
		$('#'+rightpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,3,'right');    
	}
	);
	$(".right_slide_layout4").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp;   
		var insideCont=layout4(cp,'right');
			
		$('#'+rightpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,4,'right');     
	}
	);
	$(".right_slide_layout5").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp; 
		var insideCont=layout5(cp,'right'); 
		
		$('#'+rightpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,5,'right');   	
	}
	);
	$(".right_slide_layout6").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp; 
		var insideCont=layout6(cp,'right'); 
		 	
		$('#'+rightpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,6,'right');   
	}
	);
	$(".right_slide_layout7").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp; 
		var insideCont=layout7(cp,'right'); 
		
		$('#'+rightpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,7,'right');   	
	}
	);
	$(".right_slide_layout8").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp; 
		var insideCont=layout8(cp,'right');   
		
		$('#'+rightpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,8,'right');  	
	}
	);
	$(".right_slide_layout9").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp; 
		var insideCont=layout9(cp,'right'); 
		
		$('#'+rightpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,9,'right');    	
	}
	);
	$(".right_slide_layout10").live('click',function()
	{
		var cp=$("#currentpage").val();
		var rightpanel="right"+cp; 
		var insideCont=layout10(cp,'right'); 
			
		$('#'+rightpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,10,'right');    
	}
	);
	// Layout left one creation
	$(".left_slide_layout1").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		var insideCont=layout1(cp,'left'); 
		  	
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,1,'left');  
	}
	);
	$(".left_slide_layout2").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		var insideCont=layout2(cp,'left');
			
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,2,'left');     
	}
	);
	$(".left_slide_layout3").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp; 
		var insideCont=layout3(cp,'left');
			
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,3,'left');     
	}
	);
	$(".left_slide_layout4").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		var insideCont=layout4(cp,'left');   
			
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,4,'left'); 
	}
	);
	$(".left_slide_layout5").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		var insideCont=layout5(cp,'left');  
		 	
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,5,'left'); 
	}
	);
	$(".left_slide_layout6").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		
		var insideCont=layout6(cp,'left');   
		
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,6,'left');  	
	}
	);
	$(".left_slide_layout7").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		
		var insideCont=layout7(cp,'left');    	
		
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,7,'left'); 
	}
	);
	$(".left_slide_layout8").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp; 
		
		var insideCont=layout8(cp,'left');  
		 	
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,8,'left');  
	}
	);
	$(".left_slide_layout9").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		
		var insideCont=layout9(cp,'left');    
		
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,9,'left'); 	
	}
	);
	$(".left_slide_layout10").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		
		var insideCont=layout10(cp,'left');   
		
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,10,'left');  	
	}
	);
	$(".left_slide_layout11").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		
		var insideCont=layout11(cp,'left');  
		 	
		$('#'+leftpanel).html(insideCont);
		$("#leftSlidingDiv").toggle('slow');
		setLayout(cp,11,'left'); 
		setLayout(cp,11,'right');  
	}
	);
	$(".right_slide_layout11").live('click',function()
	{
		var cp=$("#currentpage").val();
		var leftpanel="left"+cp;  
		
		var insideCont=layout11(cp,'left'); 
		  	
		$('#'+leftpanel).html(insideCont);
		$("#rightSlidingDiv").toggle('slow');
		setLayout(cp,11,'left'); 
		setLayout(cp,11,'right'); 
	}
	);
	//format <div class=''zooming' id='zooming_leftbox"+id+"'> <div id='zoom_leftbox"+id+"'	class=''zooming_Slider'></div>     <div id='rot_leftbox"+id+"' class='rotating_Slider'></div>     											</div>   
	//Layout functions
	
	function  splitwidth(id,side)
	{
		$("#right"+id).css('width','49%');
		$("#left"+id).css('width','50%');
		$("#right"+id).empty();
		$("#left"+id).empty();
		if(side=="left")
		{
			var panel="right"+id;  
			var insideCont=layout1(id,'right');    	
			$('#'+panel).html(insideCont);
		}
		else{
			var panel="left"+id;  
			var insideCont=layout1(id,'left');    	
			$('#'+panel).html(insideCont);
		}
	}
	
	function layout1(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><div class='areas layout1' id='leftbox_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox_"+id+"'> <div id='zoom_leftbox_"+id+"'	class='zooming_Slider'></div>     <div id='rot_leftbox_"+id+"' class='rotating_Slider'></div>     											</div> </div><div align='center' class='inputBox'><div class='textcontleft txtcolor'  id='inputleft"+id+"'> Click Here to add content</div><div class='closeTxtleft' id='cinputleft"+id+"' title='Save And Close'></div></div>";
		}
		else
		{
			var html="<div class='imageContent'><div class='areas layout1' id='rightbox_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox_"+id+"'> <div id='zoom_rightbox_"+id+"'	class='zooming_Slider'></div>     <div id='rot_rightbox_"+id+"' class='rotating_Slider'></div>     											</div> </div><div align='center' class='inputBox'><div class='textcontright txtcolor'  id='inputright"+id+"'> Click Here to add content</div><div class='closeTxtright' title='Save And Close' id='cinputright"+id+"'></div></div>";
		}
		return html;
	}
	
	function layout2(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><div class='areas layout2' id='leftbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox1_"+id+"'> <div id='zoom_leftbox1_"+id+"'	class=''zooming_Slider'></div>     <div id='rot_leftbox1_"+id+"' class='rotating_Slider'></div>     											</div><div class='areas layout2' id='leftbox2_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox2_"+id+"'> <div id='zoom_leftbox2_"+id+"'	class='zooming_Slider'></div>     <div id='rot_leftbox2_"+id+"' class='rotating_Slider'></div>     											</div></div><div align='center' class='inputBox'><div class='textcontleft txtcolor'  id='inputleft"+id+"'> Click Here to add content </div><div class='closeTxtleft' id='cinputleft"+id+"'></div></div>";
		}
		else
		{
			var html="<div class='imageContent'><div class='areas layout2' id='rightbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox1_"+id+"'> <div id='zoom_rightbox1_"+id+"'	class=''zooming_Slider'></div>     <div id='rot_rightbox1_"+id+"' class='rotating_Slider'></div>     											</div><div class='areas layout2' id='rightbox2_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox2_"+id+"'> <div id='zoom_rightbox2_"+id+"' class='zooming_Slider'></div>     <div id='rot_rightbox2_"+id+"' class='rotating_Slider'></div>     											 </div></div><div align='center' class='inputBox'><div class='textcontright txtcolor'  id='inputright"+id+"'> Click Here to add content </div><div class='closeTxtright' id='cinputright"+id+"'></div></div>";
		}
		return html;
	}
	
	function layout3(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><table width='300px'><tr><td  align='left'><div class='areas layout3 eighty' id='leftbox1_"+id+"' style='float:left;'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox1_"+id+"'> <div id='zoom_leftbox1_"+id+"'	class=''zooming_Slider'></div><div id='rot_leftbox1_"+id+"' class='rotating_Slider'></div>     											</div></td></tr><tr><td align='center'>" +
			"<div class='areas layout3 eighty' id='leftbox2_"+id+"' style='float:left;margin-left:85px;'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox2_"+id+"'> <div id='zoom_leftbox2_"+id+"'	class=''zooming_Slider'></div>     <div id='rot_leftbox2_"+id+"' class='rotating_Slider'></div>     											</div>" +
			"</td></tr><tr><td align='right'><div class='areas layout3 eighty' id='leftbox3_"+id+"' style='float:right;'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox3_"+id+"'> <div id='zoom_leftbox3_"+id+"'	class=''zooming_Slider'></div>  <div id='rot_leftbox3_"+id+"' class='rotating_Slider'></div>     											</div></table>" +
			"</div><div align='center' class='inputBox'><div class='textcontleft txtcolor'  id='inputleft"+id+"'> Click Here to add content </div><div class='closeTxtleft' id='cinputleft"+id+"'></div></div>";
		}
		else
		{
			var html="<div class='imageContent'><table width='300px'><tr><td  align='left'><div class='areas layout3 eighty' id='rightbox1_"+id+"' style='float:right;'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox1_"+id+"'> <div id='zoom_rightbox1_"+id+"'	class='zooming_Slider'></div>     <div id='rot_rightbox1_"+id+"' class='rotating_Slider'></div>     											</div></td></tr><tr><td align='center'>" +
			"<div class='areas layout3 eighty' id='rightbox2_"+id+"' style='float:right;margin-right:85px;'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox2_"+id+"'> <div id='zoom_rightbox2_"+id+"'	class=''zooming_Slider'></div>     <div id='rot_rightbox2_"+id+"' class='rotating_Slider'></div>     											</div>" +
			"</td></tr><tr><td align='left'><div class='areas layout3 eighty' id='rightbox3_"+id+"' style='float:left;'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox3_"+id+"'> <div id='zoom_rightbox3_"+id+"'	class=''zooming_Slider'></div>  <div id='rot_rightbox3_"+id+"' class='rotating_Slider'></div>     											</div></table>" +
			"</div><div align='center' class='inputBox'><div class='textcontright txtcolor'  id='inputright"+id+"'> Click Here to add content </div><div class='closeTxtright' id='cinputright"+id+"'></div></div>";
		}
		return html;
	}
	
	function layout4(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><table width='300px'><tr><td><div class='areas layout4 four' id='leftbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox1_"+id+"'> <div id='zoom_leftbox1_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox1_"+id+"' class='rotating_Slider'></div> </div></td>"+
			"<td><div class='areas layout4 four' id='leftbox2_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox2_"+id+"'> <div id='zoom_leftbox2_"+id+"'	class='zooming_Slider'></div><div id='rot_leftbox2_"+id+"' class='rotating_Slider'></div></td></tr>"+
			"<tr><td><div class='areas layout4 four' id='leftbox3_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox3_"+id+"'> <div id='zoom_leftbox3_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox3_"+id+"' class='rotating_Slider'></div></div></td><td>"+
			"<div class='areas layout4 four' id='leftbox4_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox4_"+id+"'> <div id='zoom_leftbox4_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox4_"+id+"' class='rotating_Slider'></div></div></td></table>"+
			"</div><div align='center' class='inputBox'><div class='textcontleft txtcolor'  id='inputleft"+id+"'> Click Here to add content </div><div class='closeTxtleft' id='cinputleft"+id+"'></div></div>";
		}
		else
		{
			var html="<div class='imageContent'><table width='300px'><tr><td><div class='areas layout4 four' id='rightbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox1_"+id+"'> <div id='zoom_rightbox1_"+id+"' class='zooming_Slider'></div><div id='rot_rightbox1_"+id+"' class='rotating_Slider'></div> </div></td>"+
			"<td><div class='areas layout4 four' id='rightbox2_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox2_"+id+"'> <div id='zoom_rightbox2_"+id+"'	class='zooming_Slider'></div><div id='rot_rightbox2_"+id+"' class='rotating_Slider'></div></td></tr>"+
			"<tr><td><div class='areas layout4 four' id='rightbox3_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox3_"+id+"'> <div id='zoom_rightbox3_"+id+"' class='zooming_Slider'></div><div id='rot_rightbox3_"+id+"' class='rotating_Slider'></div></div></td><td>"+
			"<div class='areas layout4 four' id='rightbox4_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox4_"+id+"'> <div id='zoom_rightbox4_"+id+"' class='zooming_Slider'></div><div id='rot_rightbox4_"+id+"' class='rotating_Slider'></div></div></td></table>"+
			"</div><div align='center' class='inputBox'><div class='textcontright txtcolor'  id='inputright"+id+"'> Click Here to add content </div><div class='closeTxtright' id='cinputright"+id+"'></div></div>";
		}
		return html;
	}
	
	function layout5(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><table width='300px'><tr><td valign='top'><div class='areas layout5 five1' id='leftbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox1_"+id+"'> <div id='zoom_leftbox1_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox1_"+id+"' class='rotating_Slider'></div> </div></td>"+
			"<td><table><tr><td><div class='areas layout5 five' id='leftbox2_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox2_"+id+"'> <div id='zoom_leftbox2_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox2_"+id+"' class='rotating_Slider'></div> </div></td></tr>"+
			"<tr><td><div class='areas layout5 five' id='leftbox3_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox3_"+id+"'> <div id='zoom_leftbox3_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox3_"+id+"' class='rotating_Slider'></div> </div></td></tr>"+
			"</table></td></tr></table>"+
			"</div><div align='center' class='inputBox'><div class='textcontleft txtcolor'  id='inputleft"+id+"'> Click Here to add content </div><div class='closeTxtleft' id='cinputleft"+id+"'></div></div>";
		}
		else
		{
			var html="<div class='imageContent'><table width='300px'><tr><td><div class='areas layout5 five1' id='rightbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox1_"+id+"'> <div id='zoom_rightbox1_"+id+"' class='zooming_Slider'></div><div id='rot_rightbox1_"+id+"' class='rotating_Slider'></div> </div></td>"+
			"<td><table><tr><td><div class='areas layout5 five' id='rightbox2_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox2_"+id+"'> <div id='zoom_rightbox2_"+id+"' class='zooming_Slider'></div><div id='rot_rightbox2_"+id+"' class='rotating_Slider'></div> </div></td></tr>"+
			"<tr><td><div class='areas layout5 five' id='rightbox3_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox3_"+id+"'> <div id='zoom_rightbox3_"+id+"' class='zooming_Slider'></div><div id='rot_rightbox3_"+id+"' class='rotating_Slider'></div> </div></td></tr>"+
			"</table></td></tr></table>"+
			"</div><div align='center' class='inputBox'><div class='textcontright txtcolor'  id='inputright"+id+"'> Click Here to add content </div><div class='closeTxtright' id='cinputright"+id+"'></div></div>";
		}
		return html;
	}
	
	function layout6(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><div class='areas layout6' id='leftbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox1_"+id+"'> <div id='zoom_leftbox1_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox1_"+id+"' class='rotating_Slider'></div> </div><div class='txtcontainer'><div class='textlayout6 twotext txtcolor' id='inputleft"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxl2 closeboxbutton' id='cinputleft"+id+"'></div></div></div>";
		}
		else
		{
			var html="<div class='imageContent'><div class='areas layout6' id='rightbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox1_"+id+"'> <div id='zoom_rightbox1_"+id+"' class='zooming_Slider'></div><div id='rot_rightbox1_"+id+"' class='rotating_Slider'></div> </div><div class='txtcontainer'><div class='textlayout6 fourtext txtcolor' id='inputright"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxr2 closeboxbutton' id='cinputright"+id+"'></div></div></div>";
		}
		return html;
	}
	
	function layout7(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><div class='textlayout7 textboxs txtcolor' id='leftbox"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxl  closeboxbutton' id='cleftbox"+id+"'></div></div>";
		}
		else
		{
			var html="<div class='imageContent'><div class='textlayout7 textboxs txtcolor' id='rightbox"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxr closeboxbutton' id='crightbox"+id+"'></div></div>";
		}
		return html;
	}
	
	function layout8(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><div class='txtcontainer'><div class='textlayout8 onetext txtcolor' id='leftbox1_"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxl1 closeboxbutton' id='cleftbox1_"+id+"'></div></div><div class='txtcontainer'><div class='textlayout8 twotext txtcolor' id='leftbox2_"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxl2 closeboxbutton' id='cleftbox2_"+id+"'></div></div></div></div>";
		}
		else
		{
			var html="<div class='imageContent'><div class='txtcontainer'><div class='textlayout8 threetext txtcolor' id='rightbox1_"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxr1 closeboxbutton' id='crightbox1_"+id+"'></div></div><div class='txtcontainer'><div class='textlayout8  fourtext txtcolor' id='rightbox2_"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxr2 closeboxbutton' id='crightbox2_"+id+"'></div></div></div></div>";
		}
		return html;
	}
	
	function layout9(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><div class='txtcontainer'><div class='textlayout9 onetext txtcolor' id='inputleft"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxl1 closeboxbutton' id='cinputleft"+id+"'></div></div><div class='areas layout9' id='leftbox2_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox2_"+id+"'> <div id='zoom_leftbox2_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox2_"+id+"' class='rotating_Slider'></div> </div></div>";
		}
		else
		{
			var html="<div class='imageContent'><div class='txtcontainer'><div class='textlayout9 threetext txtcolor' id='inputright"+id+"'><div class='textEdit'>Click Here to add content</div></div><div class='closeBoxr1 closeboxbutton' id='cinputright"+id+"'></div></div><div class='areas layout9' id='rightbox2_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox2_"+id+"'> <div id='zoom_rightbox2_"+id+"' class='zooming_Slider'></div><div id='rot_rightbox2_"+id+"' class='rotating_Slider'></div> </div></div>";
		}
		return html;
	}
	
	function layout10(id,side)
	{
		if(side=='left')
		{
			var html="<div class='imageContent'><div class='areas layout10' id='leftbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox1_"+id+"'> <div id='zoom_leftbox1_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox1_"+id+"' class='rotating_Slider'></div> </div><div class='txtcontainer' style='margin-top:250px;'><div class='textlayout10 fivetextl txtcolor' id='inputleft"+id+"'> Click Here to add content </div><div class='closeBoxl3 closeboxbutton' id='cinputleft"+id+"'></div></div></div>";
		}
		else
		{
			var html="<div class='imageContent'><div class='areas layout10' id='rightbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_rightbox1_"+id+"'> <div id='zoom_rightbox1_"+id+"' class='zooming_Slider'></div><div id='rot_rightbox1_"+id+"' class='rotating_Slider'></div></div><div class='txtcontainer' style='margin-top:250px;'><div class='textlayout10 fivetext txtcolor' id='inputright"+id+"'> Click Here to add content </div><div class='closeBoxr3 closeboxbutton' id='cinputright"+id+"'></div></div></div>";
		}
		return html;
	}
	
	function layout11(id,side)
	{
		$("#right"+id).css('width','1%');
		$("#right"+id).empty();  
		$("#left"+id).css('width','99%');  
		var html="<div class='imageContent'><div class='areas layout11' id='leftbox1_"+id+"'><div class='textinside'><table height='100%' width='100%'><tr><td align='center'>Drag and drop your Image here</td></tr></table></div></div><div class='zooming' id='zooming_leftbox1_"+id+"'> <div id='zoom_leftbox1_"+id+"' class='zooming_Slider'></div><div id='rot_leftbox1_"+id+"' class='rotating_Slider'></div> </div></div>";
		return html;
	}
	
	
	$(".mainbook").live('mouseover', function()
	{
		$(".areas").droppable({
			drop: function(event, ui)
			{
				var thisid=this.id;            
				
				dropHere(thisid);
			}
			});
	}
	)
		
	function getNatural (DOMelement)
	{
		var img = new Image();
		img.src = DOMelement.src;
		return {width: img.width, height: img.height};
	}
	$(".images").draggable({
		helper: 'clone'
		})
		
		

		dropHere('updateCart');
		
	function dropHere(divid)
	{
		if(divid!="")
		{
		$(".zooming").hide();
			$(".images").draggable({
				helper: 'clone', 
				appendTo: 'body',
				zIndex: 10000,
				stop: function(event, ui)
				{
					var imageused=$(this).attr('src');	
					imageused = imageused.replace("/small/","/org/"); 
					
					
photograf = new Image();
photograf.src = imageused;
var w = photograf.width;
var h = photograf.height;

if(w==0)
{
	w=200;
}


if(h==0)
{
	h=200;
}
					
					var divwidth=$("#"+divid).width();
					var divheight=$("#"+divid).height();
					var colorsel=$("#currentcolor").val();
					$('#zoom_'+divid).empty();
					$('#rot_'+divid).empty();
					$('#rot_'+divid).empty();
					var cropzoom = $('#'+divid).cropzoom({		   
						width:divwidth,
						height:divheight,
						bgColor: colorsel,
						enableRotation:true,
						enableZoom:true,
						zoomSteps:10,
						rotationSteps:10,
						expose:{
							slidersOrientation: 'horizontal',
							zoomElement: '#zoom_'+divid,
							rotationElement: '#rot_'+divid,
							elementMovement:'#movement_'+divid
							},
						selector:{        
							centered:true,
							borderColor:'blue',
							borderColorHover:'red'
							},
						image:{
							source:imageused,
							width:w,
							height:h,
							minZoom:50,
							maxZoom:300,
							startZoom:0
							}        
						});
				}
				});
				borderColoring();
		}
	}
	$("#previousPage").click(function()
	{
		var cp=$("#currentpage").val();	
		var mp=$("#totalpages").val();
		var fc=parseInt(cp)-1;
		if(cp=="last")
		{
			cp=parseInt(mp);
			var fc=parseInt(cp);
		}
		if(fc>0)
		{
			if(fc==1)
			{
				fc='first';
			}
			var slnme='slide'+fc;
			$(".slides").hide();
			$("#"+slnme).show();
			$("#currentpage").val(fc);	
			colorit(fc);
			hidelayoutselector();
			hide11thlayout();
			savethepage();
			closealltext();
		}
		});
	$("#nextPage").click(function()
	{
		var cp=$("#currentpage").val();
		if(cp=="first")
		{
			cp=1;
		}
		var fc=parseInt(cp)+1;
		var mp=$("#totalpages").val();
		if(fc>0)
		{
			if(fc>mp)
			{
				fc='last';
			}
			var slnme='slide'+fc;
			$(".slides").hide();
			$("#"+slnme).show();
			$("#currentpage").val(fc);	
			closealltext();
			colorit(fc);
			hidelayoutselector();
			hide11thlayout();
			savethepage();
			
		}
		});
	
	function getText(page,side,layoutid)
	{
	
	
		switch (parseInt(layoutid))
		{
			case 1:
			   var idofelement='input'+side+page;
			  
			break;
			
			case 2:
			   var idofelement='input'+side+page;
			break;
			
			case 3:
			 	var idofelement='input'+side+page;
			break;
			
			case 4:
				var idofelement='input'+side+page;
			break;
			
			case 5:
				var idofelement='input'+side+page;
			break;
			
			case 6:
				var idofelement='input'+side+page;
			break;
			
			case 7:
				 var idofelement=side+'box'+page;
			break;
			
			case 8:
				 var idofelement='input'+side+page;		 
			break;
			
			case 9:
				var idofelement='input'+side+page;
			break;
			
			case 10:
				var idofelement='input'+side+page;
			break;
			
		}
		
		
		var htm=$("#"+idofelement).html();
		return htm;
	}
	
	function sleep(milliSeconds)
	{
		var startTime = new Date().getTime(); // get the current time
		while (new Date().getTime() < startTime + milliSeconds); // hog cpu
	}
	$("#preview").live('click',function()
	{
		savethepage();
		$("#saverInform").show();
		var totalslides=parseInt($("#totalpages").val())+1;
		var i=1;
		var inc=1;
		for(i=1;i<=totalslides;i++)
		{
			var url = "save_image.php"; 
			var lastnot='false';		
			if(i==1)
			{
				var is='first';
				var lid="left_lay_"+is;
				var rid="right_lay_"+is;
			}
			else if(i==totalslides)
			{
				var is='last';
				var lastnot='true';
				var lid="left_lay_last";
				var rid="right_lay_last";
			}
			else
			{
				var is=i;
				var lid="left_lay_"+is;
				var rid="right_lay_"+is;
			}
			var leftcontent='left'+is;
			var rightcontent='right'+is;
			var imageCont1=$('#'+leftcontent).html();
			var imageCont2=$('#'+rightcontent).html();   
			var leftlayoutid=$("#"+lid).val();
			var rightlayoutid=$("#"+rid).val();
			
			var lefttext=getText(is,'left',leftlayoutid);
			var righttext=getText(is,'right',rightlayoutid);

			
			
			
			if(leftlayoutid==8)
			{
			var sr='#leftbox1_'+is;
			var box1=$(sr).html();
			var sr='#leftbox2_'+is;
			var box2=$(sr).html();			
			var acr=box1+'||SEPARATOR||'+box2;			
			lefttext=acr;
							
			}		
						
			if(rightlayoutid==8)
			{
			var sr='#rightbox1_'+is;
			var htm1=$(sr).html();
			var sr='#rightbox2_'+is;
			var htm2=$(sr).html();
			var acr=htm1+'||SEPARATOR||'+htm2;			
			righttext=acr;
							
			}
			

			
			var colorselected=$("#currentcolor").val();
			if(i==totalslides)
			{
				var is=i;
			}
			$.ajax({
				type: "POST",
				url: url,
				//{ name: "John", time: "2pm" },
				data: {left: imageCont1,
				        right:imageCont2,
						pageid:is,
						inputLeft:lefttext,
						inputRight:righttext,
						last:lastnot,
						rightlayoutid:rightlayoutid,
						leftlayoutid:leftlayoutid,
						color:colorselected}
						
				}).done(function(response)
			{
			
			//alert(response);
				if(response=='lastpage')
				{
					$("#saverInform").hide();
					$.colorbox({opacity:0.5,href:"sample.php",width:"1024px", height:"512px",iframe:true});
				}
				});
		}
		})
		
	function savethepage()
	{
		closealltext();
		var wholepage=$("#every_content").html();
		var color=$("#currentcolor").val();
		var currentpage=$("#currentpage").val();
		var totalpages=$("#totalpages").val();
		var ppp=$("#ppp").val();
		if(wholepage!="" && color!="" && currentpage!="" && totalpages!="" && ppp!="")
		{
			$.ajax({
				type:"POST",
				url:'save_everything.php',
				data:'content='+wholepage+'&totalpages='+totalpages+'&color='+color+'&currentpage='+currentpage+'&ppp='+ppp
				});
		}
		else
		{
			$("#pagesError").html('Some internal error occured');
		}
	}
	
	function colorit(cp)
	{
		var btnid='button'+cp;
		$(".pageButtons").css('background-color','#fff');
		$(".pageButtons").css('border','none');
		//$('#'+btnid).css('background-color','#fff000');
		$('#'+btnid).css('background-color','#f6d47a');
		//$('#'+btnid).css('border','1px solid #000000');
	}
	$(".areas").live('click', function()
	{
		var getclickid=this.id;
		var zoomcontainer="#zooming_"+getclickid;
		var st_op=$(zoomcontainer).css('display');
		if(st_op=="none")
		{
			$(".zooming").hide();	
			$(zoomcontainer).show();
		}
		else
		{
			$(".zooming").hide();
		}
	})
		
		
	function toggleArea1(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		addtonic(areas,'toggleArea1');  
			area1=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight:45}).panelInstance(areas,{hasPanel : true});
		}
		else
		{
		removefromnic(areas,'toggleArea1');
		
		 var con=nicEditors.findEditor(areas).getContent();
	
		
		
			area1.removeInstance(areas);
			area1 = null;
			removeExtra(areas,30);
	  
		}
		}  
	
	function toggleArea2(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		addtonic(areas,'toggleArea2');
			area3=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight:45}).panelInstance(areas,{hasPanel : true});
		}
		else
		{
		removefromnic(areas,'toggleArea2');
		
		
		 var con=nicEditors.findEditor(areas).getContent();
		
	  
			area3.removeInstance(areas);
			area3 = null;
			removeExtra(areas,30);
			
	  
		}
		}  
	
	function toggleAreaboxone(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		addtonic(areas,'toggleAreaboxone');
			areaone=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight : 320}).panelInstance(areas,{hasPanel : true});
		}
		else
		{
		removefromnic(areas,'toggleAreaboxone');
		
			areaone.removeInstance(areas);
			areaone = null;
			removeExtra(areas,300);
		}
		} 
	
	function toggleAreaboxtwo(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		addtonic(areas,'toggleAreaboxtwo');
			areatwo=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight : 320}).panelInstance(areas,{hasPanel : true});
		}
		else
		{
		removefromnic(areas,'toggleAreaboxtwo');
		   
			areatwo.removeInstance(areas);
			areatwo = null;
			removeExtra(areas,300);
		}
		} 
	
	function toggleAreaboxthree(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		addtonic(areas,'toggleAreaboxthree');
			areathree=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight : 320}).panelInstance(areas,{hasPanel : true});
		}
		else
		{
		removefromnic(areas,'toggleAreaboxthree');
		
			areathree.removeInstance(areas);
			areathree = null;
			removeExtra(areas,300);
		}
		} 
	
	function toggleAreaboxfour(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		addtonic(areas,'toggleAreaboxfour');
			areafour=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight : 320}).panelInstance(areas,{hasPanel : true});
		}
		else
		{
		removefromnic(areas,'toggleAreaboxfour');
		
			areafour.removeInstance(areas);
			areafour = null;
			removeExtra(areas,300);
		}
		} 
	
	function toggleAreabox(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		addtonic(areas,'toggleAreabox');
			area3=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight : 320}).panelInstance(areas,{hasPanel : true});
		}
		else
		{
		   removefromnic(areas,'toggleAreabox');
		   
			area3.removeInstance(areas);
			area3 = null;
			removeExtra(areas,300);
		}
		} 
	
	function toggleAreaboxfive(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		addtonic(areas,'toggleAreaboxfive');
			area5l=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight : 60}).panelInstance(areas,{hasPanel : true});
		}
		else
		{
		removefromnic(areas,'toggleAreaboxfive');
		
			area5l.removeInstance(areas);
			area5l = null;
			removeExtra(areas,50);
		}
		} 
	
	function toggleAreaboxr(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		addtonic(areas,'toggleAreaboxr');
			area5=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight : 60}).panelInstance(areas,{hasPanel : true});
		}
		else
		{
		removefromnic(areas,'toggleAreaboxr');
		
			area5.removeInstance(areas);
			area5 = null;
			removeExtra(areas,300);
		}
		} 
	
	function toggleAreaboxr5(areas,ins)
	{
		
		if(ins==1)
		{
		closealltext();
		 addtonic(areas,'toggleAreaboxr5');
			area5l=new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight : 60}).panelInstance(areas,{hasPanel : true});
		}
		else
		{	removefromnic(areas,'toggleAreaboxr5');		    
			area5l.removeInstance(areas);
			area5l = null;
			removeExtra(areas,300);
		}
		} 
	
	function addtonic(qno,func)
	{	
	var inhtml=$("#"+qno).html();
	if(inhtml=='<div class="textEdit">Click Here to add content</div>' || inhtml==' Click Here to add content ')
	{
		inhtml=$("#"+qno).empty();
	}
	
	
		if(qno!='')
		{
			var allnic=$("#niceditors").val();
			var nics = allnic.split(",");
			nics.push(qno+':'+func);
			nics=sort_unique(nics);	
			$("#niceditors").val(nics);
		}
	}
	
	function removefromnic(qno,func)
	{
		var inhtml=$("#"+qno).html();
		var ne=inhtml.replace(' ','');
		
	if(ne=='' || ne=='<br>')
	{
		$("#"+qno).html("<div class='textEdit'>Click Here to add content</div>");
	}
		var allnic=$("#niceditors").val();
		var nics = allnic.split(",");
	var newarr=new Array();
	var tocheck=qno+':'+func;
	for(i = 0; i < nics.length; i++)
	{
		if(nics[i]!=tocheck && nics[i]!='')
		{
		 newarr.push(nics[i]);
		}	
	}	
	newarr=sort_unique(newarr);	
	$("#niceditors").val(newarr);
		
	}
	
	
	function closealltext()
	{
		var allmarks=$("#niceditors").val();
		$("#niceditors").val('');
		var markarr = allmarks.split(",");
		var newarr=new Array();
		for(i = 0; i < markarr.length; i++)
		{
			if(markarr[i]!='')
			{
				var cone = markarr[i].split(":");
				var closebuttoonid='#c'+cone[0];
				$(closebuttoonid).hide();
				switch(cone[1])
				{
					case 'toggleArea1':				  
					toggleArea1(cone[0],0);
					break;				
					case 'toggleArea2':
					toggleArea2(cone[0],0);
					break;
					case 'toggleAreaboxone':
					toggleAreaboxone(cone[0],0);
					break;
					case 'toggleAreaboxtwo':
					toggleAreaboxtwo(cone[0],0);
					break;
					case 'toggleAreaboxthree':
					toggleAreaboxthree(cone[0],0);
					break;
					case 'toggleAreaboxfour':
					toggleAreaboxfour(cone[0],0);
					break;
					case 'toggleAreabox':
					toggleAreabox(cone[0],0);
					break;
					case 'toggleAreaboxfive':
					toggleAreaboxfive(cone[0],0);
					break;
					case 'toggleAreaboxr':
					toggleAreaboxr(cone[0],0);
					break;
					case 'toggleAreaboxr5':
					toggleAreaboxr5(cone[0],0);
					break;
					default:
					break;
				}
			}
			}	
	}
	$(".textcontleft").live('click', function()
	{
		var gettypeid=this.id;	
		var  clid='#c'+gettypeid;
		$(clid).show();
		toggleArea1(gettypeid,1);
	}
	)
		$(".closeTxtleft").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleArea1(srcid,0);
		$("#"+gettypeid).hide();
	}
	)
		$(".textcontright").live('click', function()
	{
		var gettypeid=this.id;	
		var  clid='#c'+gettypeid;
		$(clid).show();
		toggleArea2(gettypeid,1);
	}
	)
		$(".closeTxtright").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleArea2(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)
		$(".onetext").live('click', function()
	{
		var gettypeid=this.id;	
		var bgc=$("#currentcolor").val();
		$("#".gettypeid).css('background-color',bgc);
		var  clid='#c'+gettypeid;
		$(clid).show();
		toggleAreaboxone(gettypeid,1);
	}
	)
		$(".closeBoxl1").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleAreaboxone(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)
		$(".twotext").live('click', function()
	{
		var gettypeid=this.id;	
		var bgc=$("#currentcolor").val();
		$("#".gettypeid).css('background-color',bgc);
		var  clid='#c'+gettypeid;
		$(clid).show();
		toggleAreaboxtwo(gettypeid,1);
	}
	)
		$(".closeBoxl2").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleAreaboxtwo(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)
		$(".threetext").live('click', function()
	{
		var gettypeid=this.id;	
		var bgc=$("#currentcolor").val();
		$("#".gettypeid).css('background-color',bgc);
		var  clid='#c'+gettypeid;
		$(clid).show();
		toggleAreaboxthree(gettypeid,1);
	}
	)
		$(".closeBoxr1").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleAreaboxthree(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)
		$(".fourtext").live('click', function()
	{
		var gettypeid=this.id;	
		var bgc=$("#currentcolor").val();
		$("#".gettypeid).css('background-color',bgc);
		var  clid='#c'+gettypeid;
		$(clid).show();
		toggleAreaboxfour(gettypeid,1);
	}
	)
		$(".closeBoxr2").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleAreaboxfour(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)
		$(".fivetext").live('click', function()
	{
		var gettypeid=this.id;	
		var bgc=$("#currentcolor").val();
		$("#".gettypeid).css('background-color',bgc);
		var  clid='#c'+gettypeid;
		$(clid).show();
		toggleAreaboxfive(gettypeid,1);
	}
	)
		$(".closeBoxr3").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleAreaboxfive(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)
		$(".closeBoxl3").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleAreaboxfive(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)
    $(".textboxs").live('click', function()
	{
		var gettypeid=this.id;	
		var bgc=$("#currentcolor").val();
		$("#".gettypeid).css('background-color',bgc);
		var  clid='#c'+gettypeid;
		$(clid).show();
		toggleAreabox(gettypeid,1);
	}
	)
		$(".closeBoxl").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleAreabox(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)
		$(".closeBoxr").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleAreabox(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)
		$(".fivetextl").live('click', function()
	{
		var gettypeid=this.id;	
		var bgc=$("#currentcolor").val();
		$("#".gettypeid).css('background-color',bgc);
		var  clid='#c'+gettypeid;
		$(clid).show();
		toggleAreaboxr5(gettypeid,1);
	}
	)
		$(".closeBoxl3").live('click', function()
	{
		var gettypeid=this.id;	
		var srcid=gettypeid.slice(1);
		toggleAreaboxr5(srcid,0);	
		$("#"+gettypeid).hide();
	}
	)

	function hidelayoutselector()
	{
		var cpg=$("#currentpage").val();
		$("#leftPanelSelect").show();
		$("#rightPanleSelect").show();
		if(cpg=="last")
		{
			$("#rightPanleSelect").hide();
		}
		else if(cpg=="first")
		{
			$("#leftPanelSelect").hide();
		}
		else
		{
			$("#leftPanelSelect").show();
			$("#rightPanleSelect").show();
		}
	}
	$(".changebg").live('click',function()
	{
		var colorcode=this.id;	
		var lp='.leftpanel';
		var rp='.rightpanel';
		$('.leftPanel').css('background-color',colorcode);
		$('.rightPanel').css('background-color',colorcode);
		$("#currentcolor").val(colorcode);	
		$(".areas").css('background-color',colorcode);
		 borderColoring();
		
	}
	);
	
	function hide11thlayout()
	{
		var cp=$("#currentpage").val();
		if(cp=='1' || cp=="last" || cp=="first")
		{
			$(".left_slide_layout11").hide();
			$(".right_slide_layout11").hide();
		}
		else
		{
			$(".left_slide_layout11").show();
			$(".right_slide_layout11").show();
		}
	}
	hide11thlayout();
	hidelayoutselector();
	colorit('first');
	
	function pageload()
	{
		$(".slides").hide();
		$("#slidefirst").show();
		$(".zooming").hide();
	}
	showPrices();
	pageload();
      
	function removeExtra(areas,aheight)
	{
	
	  var cinput=$("#"+areas).height();
	 
	
$('#error_load'+areas).remove();
	  if(aheight==cinput)
	  {	
	  	  $('<div id="error_load'+areas+'" class="error_load"><span class="error_display">Text more than the specified box will be truncated</span></div>').insertAfter("#"+areas);	 
	  }
	  else
	  {
	  	$('#error_load'+areas).remove();
	  }
	  
	}
	
	

$(".areas").each(function() {    
	var thisid=this.id;
	var imag=$('#'+thisid).find('image').attr('xlink:href');
	var rot=$('#'+thisid).find('image').attr('data-rotate');
	var zoom=$('#'+thisid).find('image').attr('data-zoom');
	var xax=$('#'+thisid).find('image').attr('data-posX');
	var yax=$('#'+thisid).find('image').attr('data-posY');

var wid=$('#'+thisid).width();
var heit=$('#'+thisid).height();


photograf = new Image();
photograf.src = imag;
var w = photograf.width;
var h = photograf.height;

$('#zoom_'+thisid).empty();
$('#rot_'+thisid).empty();
$('#rot_'+thisid).empty();

if(h>0 && w>0)
{

$('#'+thisid).find('image').attr('data-rotate',rot);
	$('#'+thisid).find('image').attr('data-zoom',zoom);
	$('#'+thisid).find('image').attr('data-posX',xax);
$('#'+thisid).find('image').attr('data-posY',yax);

/*
var colorsel=$("#currentcolor").val();
var cropzoom = $('#'+thisid).cropzoom({
            width:wid,
            height:heit,
            bgColor: colorsel,
            enableRotation:true,
            enableZoom:true,
			restoreTransform:true,
            zoomSteps:10,
            rotationSteps:10,
			expose:{
			slidersOrientation: 'horizontal',
			zoomElement: '#zoom_'+thisid,
			rotationElement: '#rot_'+thisid,
			elementMovement:'#movement_'+thisid
			},
            selector:{        
              centered:true,
              borderColor:'blue',
              borderColorHover:'red'
            },
            image:{
                source:imag,
                width:w,
                height:h,
                minZoom:50,
                maxZoom:300,
				rotation:rot,
				startZoom:zoom,
				x: xax,
				y: yax
            }
        });
      
		*/
}
    });


})