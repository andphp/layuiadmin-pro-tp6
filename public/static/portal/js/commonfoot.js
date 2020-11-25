$(function(){
		   
	$(".openmenu").click(function(event){		
		$('.toper ul').show();
		$(".toper .openmenu").hide();
		$(".toper .closemenu").show();
	});
	$(".closemenu").click(function(event){		
		$('.toper ul').hide();
		$(".toper .closemenu").hide();
		$(".toper .openmenu").show();		
	});
	
	 $(this).scroll(function() {
		var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
		if(scrollTop>0){
			$('.toperh').addClass("active");
			$('.toper').addClass("active2");
		}else{
			$('.toperh').removeClass("active");	
			$('.toper').removeClass("active2");
		}
	 });
	 
	$(".fixright .totop a").click(function()
	{
		$("html, body").animate({
			"scroll-top":0
		},"");
	});

	
})


// 联系我们留言///////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){ 
	$("#cname").focus(function(){	
		if($(this).val()=="请输入您的联系人姓名（必填）"){
			$(this).val("");
		}
	}).blur(function(){
		if($(this).val()==""){
			$(this).val("请输入您的联系人姓名（必填）");
		}
	});
	$("#ctel").focus(function(){	
		if($(this).val()=="请输入您的联系方式（必填）"){
			$(this).val("");
		}
	}).blur(function(){
		if($(this).val()==""){
			$(this).val("请输入您的联系方式（必填）");
		}
	});
	$("#caddress").focus(function(){	
		if($(this).val()=="请输入您的地址（必填）"){
			$(this).val("");
		}
	}).blur(function(){
		if($(this).val()==""){
			$(this).val("请输入您的地址（必填）");
		}
	});
	$("#cbeizu").focus(function(){	
		if($(this).val()=="请输入您的需求内容"){
			$(this).val("");
		}
	}).blur(function(){
		if($(this).val()==""){
			$(this).val("请输入您的需求内容");
		}
	});				   
   $("#cbtn").click(function(){           //当按钮button被点击时的处理函数   
		 if (document.getElementById("cname").value.length<2 || document.getElementById("cname").value=="请输入您的联系人姓名（必填）") {
		 	alert("请输入您的姓名"); 
			document.getElementById("cname").focus();
		 }
		 else if (document.getElementById("ctel").value.length<6 || document.getElementById("ctel").value=="请输入您的联系方式（必填）") {
		 	alert("请输入您的联系方式"); 
			document.getElementById("ctel").focus();
		 }
		 else if (document.getElementById("caddress").value.length<2 || document.getElementById("caddress").value=="请输入您的地址（必填）") {
		 	alert("请输入您的地址"); 
			document.getElementById("caddress").focus();
		 }
		 else
		 { postdata();}                                       //button被点击时执行postdata函数
   });   
});   
function postdata(){                              //提交数据函数   
   $.ajax({                                                 //调用jquery的ajax方法   
     type: "POST",                                      //设置ajax方法提交数据的形式   
     url: "/inc/save.php",                                       //把数据提交到ok.php   
     data: "cname="+$("#cname").val()+"&ctel="+$("#ctel").val()+"&caddress="+$("#caddress").val()+"&cbeizu="+$("#cbeizu").val()+"",     //输入框writer中的值作为提交的数据   
     success: function(msg){                  //提交成功后的回调，msg变量是ok.php输出的请输入您的邮箱。   
     alert("恭喜您留言成功！");                      //如果有必要，可以把msg变量的值显示到某个DIV元素中
	 document.getElementById("cname").value="请输入您的联系人姓名（必填）";
	 document.getElementById("ctel").value="请输入您的联系方式（必填）";
	 document.getElementById("caddress").value="请输入您的地址（必填）";
	 document.getElementById("cbeizu").value="请输入您的需求内容";
     } 
   });   
}