$(document).ready(function()
{
	var area1;
	function toggleArea1(areas,ins){
		alert(areas);
		alert(ins);
		if(ins==1){
			closealltext();
			addtonic(areas,'toggleArea1');  
			area1 = new nicEditor({buttonList : ['fontSize','bold','italic','underline','forecolor','bgcolor'],maxHeight:45}).panelInstance(areas,{hasPanel : true});
		}else{
			removefromnic(areas,'toggleArea1');
			var con=nicEditors.findEditor(areas).getContent();
			area1.removeInstance(areas);
			area1 = null;
			removeExtra(areas,30);
		}
	}
	function closealltext(){
		var allmarks = $("#niceditors").val();
		$("#niceditors").val('');
		var markarr = allmarks.split(",");
		var newarr = new Array();
		for(i = 0; i < markarr.length; i++){
			if(markarr[i]!=''){
				var cone = markarr[i].split(":");
				var closebuttoonid='#c'+cone[0];
				$(closebuttoonid).hide();
				switch(cone[1]){
					case 'toggleArea1':				  
					toggleArea1(cone[0],0);
					break;				
					default:
					break;
				}
			}
		}	
	}
	function addtonic(qno,func){	
		alert(func);
		var inhtml = $("#"+qno).html();
		if(inhtml == 'Click Here to add content'){
			inhtml = $("#"+qno).html('');
		}
		if(qno!=''){
			var allnic=$("#niceditors").val();
			var nics = allnic.split(",");
			nics.push(qno+':'+func);
			nics=sort_unique(nics);	
			$("#niceditors").val(nics);
		}
	}
	function removefromnic(qno,func){
		var inhtml = $("#"+qno).html();
		var ne = inhtml.replace(' ','');
		if(ne == '' || ne == '<br>'){
			$("#"+qno).html("<div class='textEdit'>Click Here to add content</div>");
		}
		var allnic=$("#niceditors").val();
		var nics = allnic.split(",");
		var newarr = new Array();
		var tocheck = qno+':'+func;
		for(i = 0; i < nics.length; i++){
			if(nics[i]!=tocheck && nics[i]!=''){
				newarr.push(nics[i]);
			}	
		}	
		newarr = sort_unique(newarr);	
		$("#niceditors").val(newarr);
	}
	function removeExtra(areas,aheight){
		var cinput = $("#"+areas).height();
		$('#error_load'+areas).remove();
		if(aheight == cinput){	
			$('<div id="error_load'+areas+'" class="error_load"><span class="error_display">Text more than the specified box will be truncated</span></div>').insertAfter("#"+areas);	 
		}else{
			$('#error_load'+areas).remove();
		}
	}
	$(".textcontleft").click(function(){
		var gettypeid = this.id;	
		var clid = '#c'+gettypeid;
		$(clid).show();
		toggleArea1(gettypeid,1);
	});
	$(".closeTxtleft").click(function(){
		var gettypeid = this.id;	
		var srcid = gettypeid.slice(1);
		toggleArea1(srcid,0);	
		$("#"+gettypeid).hide();
	})
	
	
	
	
});