	var t = n = 0, count;
	$(document).ready(function(){	
		count=$("#banner_list a").length;
		$("#banner_list a:not(:first-child)").hide();
		$("#bannerPic li").click(function() {
			var i = $(this).text() - 1;
			n = i;
			if (i >= count) return;
			/*$("#banner_info").html($("#banner_list a").eq(i).find("img").attr('alt'));*/
			/*$("#banner_info").unbind().click(function(){window.open($("#banner_list a").eq(i).attr('href'), "_blank")})*/
			$("#banner_list a").filter(":visible").fadeOut(1000).parent().children().eq(i).fadeIn(1000);
			document.getElementById("bannerPic").style.background="";
			$(this).toggleClass("on");
			$(this).siblings().removeAttr("class");
		});
		t = setInterval("showAuto()", 10000);
		$("#bannerPic").hover(function(){clearInterval(t)}, function(){t = setInterval("showAuto()", 10000);});
	})
	
	function showAuto()
	{
		n = n >=(count - 1) ? 0 : ++n;
		$("#bannerPic li").eq(n).trigger('click');
	}