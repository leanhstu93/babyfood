// JavaScript Document
var domain = window.location.protocol + "//" + window.location.host+"/";
$(document).mouseup(function (e)
{
    var container = $(".bx-button");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
      $(".alert-added-to-cart").animate({bottom:-150},1000,function(){});
    }

});

$(document).ready(function(){
		tabs();
	$('.btn-menu-toggle').click(function(){
		if($(this).hasClass('active')){
			$('.slide-bar-menu').animate({'left':-270},90);
			$('.btn-menu-toggle').removeClass('active');
			$('.overlay-open-menu').hide();
			$('.header').css('position','relative');
		}else{
			$('.slide-bar-menu').animate({'left':0},90);
			$('.btn-menu-toggle').addClass('active');
			$('.overlay-open-menu').show();
			$('.header').css('position','static');
		}
	});
	$("#mada-button-addcart").click(function(){
		if($('input[name=color]').val()){ 
			if(!$('input[name=color]:checked', '#formorderdetail').val()){
				alert("Vui lòng chọn màu sản phẩm");
				return false;
			}
		}
		if($('input[name=size]').val()){ 
			if(!$('input[name=size]:checked', '#formorderdetail').val()){
				alert("Vui lòng chọn size sản phẩm");
				return false;
			}
		}
		if($('input[name=quanty]').val()<=0){
			alert("Chọn số lượng ");
			return false;
		}
		 data = $("#formorderdetail").serialize();
		 $.ajax({
				type: "POST",
				url: "/payment/addcartlg",
				data:data,
				success: function(res) {
					$(".count-number").html(res);
					$(".modal-dialog").html("<div class=\"mada-action-toast\"><div class=\"toast\"><div class=\"toast__container\"><div class=\"toast__icon\"><div class=\"shopee-action-toast__icon\"><svg class=\"shopee-svg-icon icon-tick-bold\" version=\"1.1\" id=\"Layer_1\" xmlns=\"http://www.w3.org/2000/svg\" data-svgreactloader=\"[[&quot;http://www.w3.org/2000/svg&quot;,&quot;xlink&quot;,&quot;http://www.w3.org/1999/xlink&quot;],[null,&quot;style&quot;,&quot;enable-background:new 0 0 12 12;&quot;],[&quot;http://www.w3.org/2000/svg&quot;,&quot;space&quot;,&quot;preserve&quot;]]\" x=\"0px\" y=\"0px\" viewBox=\"0 0 12 12\" xlink=\"http://www.w3.org/1999/xlink\" style=\"enable-background:new 0 0 12 12;\" space=\"preserve\"><g><path d=\"M5.2,10.9c-0.2,0-0.5-0.1-0.7-0.2L0.3,7c-0.4-0.4-0.5-1-0.1-1.4c0.4-0.4,1-0.5,1.4-0.1l3.4,3l5.1-7 c0.3-0.4,1-0.5,1.4-0.2c0.4,0.3,0.5,1,0.2,1.4l-5.7,7.9c-0.2,0.2-0.4,0.4-0.7,0.4C5.3,10.9,5.3,10.9,5.2,10.9z\"></path></g></svg></div></div><div class=\"toast__text\">Sản phẩm đã được thêm vào Giỏ hàng</div></div></div></div>");
					$('#myModal').addClass("mada-toast");
					$('#myModal').modal('show'); 
					setTimeout(function(){
						$('#myModal').removeClass("mada-toast");
						$(".modal-dialog").html("");
						$('#myModal').modal("hide");
					},3000);
				}
		  });
	}); 
	// ==============================trang giỏ hàng giao diện mobile====================================
	$("#mada-button-addcart-mobile").click(function(){
		if($('input[name=color]').val()){ 
			if(!$('input[name=color]:checked', '#formorderdetail').val()){
				swal({title: "Thông báo!", text: "Vui lòng chọn màu sản phẩm", animation: "slide-from-top"})
				return false;
			}
		}
		if($('input[name=size]').val()){ 
			if(!$('input[name=size]:checked', '#formorderdetail').val()){
				swal({title: "Thông báo!", text: "Vui lòng chọn size sản phẩm", animation: "slide-from-top"})
				return false;
			}
		}
		if($('input[name=quanty]').val()<=0){
			show_box_popup_alert("Chọn số lượng ",300,200);
			return false;
		}
		 data = $("#formorderdetail").serialize();
		 $.ajax({
				type: "POST",
				url: "/payment/addcartlg",
				data:data,
				success: function(res) {
					// $(".count-number").html(res);
					// $(".add-to-cart-success").show();
					window.location="/gio-hang-moblie.html";

				}
		  });
	});
// ==============================end trang giỏ hàng giao diện mobile====================================
	$('h2.title a.tab-ctr').click(function(){
		string = $(this).attr('href');
		netid = string.slice(6);
		$('.wp-ct-'+netid).find('a.tab-ctr').removeClass('selected');
		$(this).addClass('selected');
		$('.wp-ct-'+netid).find('.ct-tabs').hide();
		$(string).fadeIn();
		return false;
	});
	$('#btuntim').click(function(){
		keyword = $('#twotabsearchtextbox').val();
		if(keyword==""){
			return false;
		}else{
			window.location = domain+"tim-kiem.html?catelog=0&s="+keyword;
		}
	});
	$(".input-search").keypress(function(e){//khi nhan phim enter se dang nhap
		if (e.which==13)  $("#btuntim").click();	//13 la gia tri  cua enter 
		
	});
	$('.btnaddcart').click(function(){
		if($('input[name=color]').val()){ 
			if(!$('input[name=color]:checked', '#formorderdetail').val()){
				alert("Chọn màu sản phẩm");
				return false;
			}
		}
		if($('input[name=size]').val()){ 
			if(!$('input[name=size]:checked', '#formorderdetail').val()){
				alert("Chọn size sản phẩm");
				return false;
			}
		}
		 data = $("#formorderdetail").serialize();
		 $.ajax({
				type: "POST",
				url: "/payment/addcartlg",
				data:data,
				success: function(res) {
					$(".div-cart").find("span").html(res);
					$(".alert-added-to-cart").animate({bottom:0},1000,function(){});
				}
		  });
		  return false;
	});
	// $(".btn-cotinue-shopping").click(function(){$(".alert-added-to-cart").animate({bottom:-150},1000,function(){});});
	$(".btn-cotinue-shopping").click(function() {
		window.location="/";
	});
	$('.xcgheck').click(function(){
		if($(this).val()==1){
			$('.form-login').show();
			$('.form-register').hide();
		}else if($(this).val()==2){
			$('.form-login').hide();
			$('.form-register').show();
		}else if($(this).val()==3){
			window.location = domain+'thanh-toan.html/buoc-2';
		}
	}); 
	$('.dm-khac a').click(function(){
		$('.slide-bar-menu').animate({'left':0},90);
			$('.btn-menu-toggle').addClass('active');
			$('.overlay-open-menu').show();
		return false;
	});
	$('.product-quantity').change(function(){
		$('#form-edit-cart').submit();
	});
	$('.box-btn-filter label').click(function(){
		$('.overlay-open-menu').show();
		$('.slidebar-fillter').animate({'right':0},90);
	});
	$('.btn-filter').click(function(){
		$('.overlay-open-menu').hide();
		$('.slidebar-fillter').animate({'right':-270},90);
	});
	$('.overlay-open-menu').click(function(){
		$('.slide-bar-menu').animate({'left':-270},90);
		$('.btn-menu-toggle').removeClass('active');
		$('.overlay-open-menu').hide();
		$('.header').css('position','relative');
		$('.slidebar-fillter').animate({'right':-270},90);
	});
	$('.pino .arrow').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$(this).parent('li').children('ul').slideUp();
		}else{
			$(this).addClass('active');
			$(this).parent('li').children('ul').slideDown();
		}
	});
	$('.btn-toogle').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$('.menu-user').slideUp();
		}else{
			$(this).addClass('active');
			$('.menu-user').slideDown();
		}
	});
	$('.box-suggest-filter label').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$('.sub-filter-mobile').slideUp();
			$('.overlay-open-fillter').hide();
		}else{
			$(this).addClass('active');
			$('.sub-filter-mobile').slideDown();
			$('.overlay-open-fillter').show();
			$('.sub-views-mobile').hide();
		}
	});
	
	$('.box-sale-off-filter label').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$('.sub-views-mobile').slideUp();
			$('.overlay-open-fillter').hide();
		}else{
			$(this).addClass('active');
			$('.sub-views-mobile').slideDown();
			$('.overlay-open-fillter').show();
			$('.sub-filter-mobile').hide();
		}
	});
	$('.overlay-open-fillter').click(function(){
			$('.box-suggest-filter label').removeClass('active');
			$('.box-sale-off-filter label').removeClass('active');
			$('.sub-filter-mobile').slideUp();
			$('.sub-views-mobile').slideUp();
			$('.overlay-open-fillter').hide();
	});
	$('.div-info-footer ul>li>a').click(function(){
		$(this).parent('li').children('ul').toggle();
	});
	$('#TopScroll').click(function () {
		$('body,html').animate({
		scrollTop: 0
		}, 800);
		return false;
	});
	$('.readmore a').click(function(){
		ab = $(this);
		iddiv = ab.attr('href');
		status = $('#dang_xu_ly').val();
		ab.html("Đang tải ...");
		if(status==1){
			alert('Hệ thống đang xử lý ...');
		}else{
			$('#dang_xu_ly').val(1);
			numpage = $(this).attr('numpage');
			page = $(this).attr('page');
			ab.html("Đang tải ...");
			$.ajax({
				type: "POST",
				url: "/ajax/promotion",
				data:'numpage='+numpage+"&page="+page,
				success: function(data){ 
					if(data==0){
						ab.parent('.readmore').remove();
					}else{
						ab.attr('page',page+1);
						$(iddiv).append(data);
						ab.html("Xem thêm");
					}
					$('#dang_xu_ly').val(0);
				}
			});
		}
		return false;
	});
	$("body").delegate(".form-popup-login","keypress",function(e){
		if (e.which==13)  $('.btnlogin').click();	//13 la gia tri  cua enter 
	});
	$('.sub-views-mobile .view_list').click(function(){
		$('.sub-views-mobile span').removeClass('active');
		$('.sub-views-mobile span.view_list').addClass('active');
		$('.product-grid').addClass('product-list');
		$('.product-grid').removeClass('product-grid');
		$.get('/home/changeviews/list');
		$('.overlay-open-fillter').hide();
		$('.sub-views-mobile').slideUp();
	});
	$('.sub-views-mobile .view_grid').click(function(){
		$('.sub-views-mobile span').removeClass('active');
		$('.sub-views-mobile span.view_grid').addClass('active');
		$('.product-list').addClass('product-grid');
		$('.product-list').removeClass('product-list');
		$.get('/home/changeviews/grid');
		$('.sub-views-mobile').slideUp();
		$('.overlay-open-fillter').hide();
	});
	$('.btn-decrease').click(function(){
		id = $('.txtNumProd').val();
		if(id>1)
			$('.txtNumProd').val(id-1);
	});
	$('.btn-increase').click(function(){
		id = Number($('.txtNumProd').val());
		$('.txtNumProd').val(id+Number(1));
	});
	$('.readmore-desc').click(function(){
		if($(this).hasClass('active')){
			$('.box-description').css('max-height',120);
			$('.readmore-desc').removeClass('active');
			$('.readmore-desc').html('Xem thêm thông tin');
		}else{
			$('.box-description').css('max-height','none');
			$('.readmore-desc').html('Thu gọn thông tin');
			$('.readmore-desc').addClass('active');
		}
	});
	$('.readmore-desc-tech').click(function(){
		if($(this).hasClass('active')){
			$('.box-description-tech').css('max-height',120);
			$('.readmore-desc-tech').removeClass('active');
			$('.readmore-desc-tech').html('Xem thêm thông tin');
		}else{
			$('.box-description-tech').css('max-height','none');
			$('.readmore-desc-tech').html('Thu gọn thông tin');
			$('.readmore-desc-tech').addClass('active');
		}
	});
	$('.comment-add').click(function(){
		$('.form-comment-add-grid').toggle();
		return false;
	});
	
	
	$(".form-code-discount").submit(function(){
		var data = {"action": "check_code_discount"};
		data = $(this).serialize() + "&" + $.param(data);
		$.ajax({
		  type: "POST",
		  dataType: "json",
		  url: "/payment/discount", 
		  data: data,
		  success: function(data) {
			if(data.type=='error'){
				$(".result_alert_discount").html('<div class="alert alert-danger"><button data-dismiss="alert" class="close close-sm" type="button"> <i class="fa fa-times"></i></button>'+data.message+'</div>');	
			}else{
				location.reload();
			}
			$(".result_alert_discount").fadeIn(2700);
		  }
		});
		return false;
  	});
	
	$('.btn-sent-commnet').click(function(){
		data = $('.form-comment-data-add').serialize();
		 $.ajax({
		  type: "POST",
		  url: "/product/comment",
		  data: data,
			success: function(data){
				html = JSON.parse(data);
				if(html.err ==true){  
					alert(html.mess);
				}else{
					alert(html.mess);
					$('.form-comment-add input[type=text]').val(' ');
					$('.form-comment-add textarea').val(' ');
				}
			}
		});
	});
	$('.submit_btn_card').click(function(){
		$('.over_payment_watting').show();
		 $.ajax({
			  type: "POST",
			  url: "/payment/getnoidia",
				success: function(data){
					window.location = data;
				}
		 });
	});
	$('.submit_btn_visa').click(function(){
		$('.over_payment_watting').show();
		 $.ajax({
			  type: "POST",
			  url: "/payment/getvisa",
				success: function(data){
					window.location = data;
				}
		 });
	});
});
function sent_message(){
	id = $('input[name=idpro]').val();
	deal = $('input[name=deal]').val();
	if(id>0){
		$.get('home/message/'+id+'/'+deal,function(data){
			$(".modal-dialog").html(data);
			$('#myModal').modal('show'); 
		});
	}
	return false;
}
function loginfacebook(){
	var url=$(location).attr('protocol')+'//'+$(location).attr('host')+'/'
	window.open(url+"dang-nhap-facebook","_blank","width=800, height="+$(window).height());
	return false;
}
function logintwistter(){
	var url=$(location).attr('protocol')+'//'+$(location).attr('host')+'/'
	window.open(url+"dang-nhap-twitter","_blank","width=800, height="+$(window).height());
	return false;
}
function logingoogle(){
	var url=$(location).attr('protocol')+'//'+$(location).attr('host')+'/'
	window.open(url+"dang-nhap-google","_blank","width=800, height="+$(window).height());
	return false;
}
function sent_message_vi(){
	data = $('#sent-message').serialize();
	$('.error-ajax').hide();
	$.ajax({
		type: "POST",
		url: "/home/sentmessage",
		data: data,
		success: function(data){
			html = JSON.parse(data);
			if(html.err == true){  
			 	$.each (html.mess, function (key, item){
					$('#'+key).html(item).show();
				});
			}else{
				$('.form-content').html(html.mess);
			}
		}
	});
	return false;
}

function Login(){
	data = $('.form-popup-login').serialize();
	$('.error-ajax').hide();
	$.ajax({
		type: "POST",
		url: "/user/login",
		data: data,
		success: function(data){
			html = JSON.parse(data);
			if(html.err == true){  
			 	$.each (html.mess, function (key, item){
					$('#'+key).html(item).show();
				});
			}else{
				location.reload();
			}
		}
	});
	return false;
}
function Register(){
	data = $('.form-popup-register').serialize();
	$('.error-ajax').hide();
	$.ajax({
		type: "POST",
		url: "/user/register",
		data: data,
		success: function(data){
			html = JSON.parse(data);
			if(html.err == true){  
			 	$.each (html.mess, function (key, item){
					$('#'+key).html(item).show();
				});
			}else{
				//close_box_popup();
				//location.reload();
				window.location.replace('http://www.mada.vn/')
			}
		}
	});
	return false;
}
function getdistrict(id){
	if(id>0)
		$('.ship-district').load('/user/district/'+id,function(data){ $('.ship-district').removeAttr('disabled');});
}
function Filter_cat(url){
	window.location= url;
}
function cmt_pagination(idpro,page,task){
	$.ajax({
	  type: "POST",
	  url: "/product/loadcomment/"+idpro+"/"+page,
		success: function(data){
			
			$('.show-comment-list').html(data);
		}
	});
	return false;
}
function tabs() {
	$('.tab-common').hide();
	$('.tab-wrapper .tab-common:first').show();
	$('#tabs li:first').addClass('active');
	$('#tabs li a').click(function(){
	   var  id_content = $(this).attr("href"); 
	   $('.tab-common').hide();
	   $(id_content).fadeIn();
	   $('#tabs li').removeClass('active');
	   $(this).parent('li').addClass('active');
	   $('#tabs li').find('input').prop('checked', false);
	   $(this).find('input').prop('checked', true);
	   return false;
	});
}