var domain = window.location.protocol + "//" + window.location.host+"/";
$(document).mouseup(function (e)
{
    var container = $("#mbox-search");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
       $('.shopee-popover').hide();
    }
	var container = $(".orderlist");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
       $('.add-to-cart-success').hide();
    }

});
$(window).on('scroll', function(){
	if($(window).scrollTop() > 50) {
		$('.nav-center').addClass('is-fixed');	
		setTimeout(function() {
            $('.nav-center').addClass('animate-children');
            $('#cd-logo').addClass('slide-in');
			$('.cd-btn').addClass('slide-in');
        }, 50);
	} else {
		$('.nav-center').removeClass('is-fixed');
		setTimeout(function() {
            $('.nav-center').removeClass('animate-children');
            $('#cd-logo').removeClass('slide-in');
			$('.cd-btn').removeClass('slide-in');
        }, 50);
	}
});

function show_modal(content, title){
	// Generate the HTML and add it to the document
	var html_modal ='<div class="modal fade" id="myModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Modal title</h4></div><div class="modal-body"></div></div></div></div>';

	 //$('body').append(html_modal);
	 $('.modal-title').text(title);
	 $('#myModal').modal('show'); 
	 $('.modal-body').html(content);  
};	

function p_register(title){
	$.get('user/formregister',function(data){
		show_modal(data, title);
		loadcapcha();	
	});
	return false;	
}
function p_login(title){
	$.get('user/formlogin',function(data){
		show_modal(data, title);
	});
	return false;	
}
function p_check_order(title){
	$.get('payment/getformcheckorder',function(data){
		show_modal(data, title);
	});
	return false;	
}
// =========================thông số kỹ thuật===================================
function show_modal_infotech(digital){
	// Generate the HTML and add it to the document
	var html_modal_infotech ='<div class="modal fade" id="info-tech" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true"><div>X</div><div>Đóng</div></span></button><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Modal title</h4></div><div class="modal-body"></div></div></div></div>';

	 $('body').append(html_modal_infotech);
	 $('.modal-title').text("Thông số kỹ thuật");
	 $('#info-tech').modal('show'); 
	 $('.modal-body').html(digital);
};
function p_info_tech(digital){
	show_modal_infotech(digital);
	return false;
}

// =========================end thông số kỹ thuật===================================
function loadcapcha(){
	$(".captcha-image").load( "/captcha/created" ); 
	return true; 	
}

function captcha(){
    $("a.refresh").click(function() {
        jQuery.ajax({
            type: "POST",
            url: "/captcha/created",
            success: function(res) {
            if (res)
                {
                    jQuery("span.image").html(res);
                }
           }
      });
 });
	
} 
function suggetsearch(){
	$('#xtwotabsearchtextbox').keyup(function(){
		a = $(this).val();
		if(a.length>0){
			 jQuery.ajax({
				type: "POST",
				url: "/ajax/keyword",
				data:"q="+a,
				dataType:"json",
				success: function(res) {
					if(res.error==false){
						$(".shopee-popover").html(res.data).show();
					}else{
						$(".shopee-popover").hide();
					}
			   }
		  });
		}
	});
}
function get_fb_share(title, links, images){
	$.ajax({
		type: "POST",
		cache: false,
		url:"/user/checklogin",
		success: function(data){
			html = JSON.parse(data);
			if(html.type==0){
				swal({title: "Thông báo!", text: html.msg, animation: "slide-from-top", type: "error"},
				function(){
						p_login('Đăng nhập');
					}
				)		
			}
			if(html.check_status==1){
				swal({title: "Thông báo!", text: html.msg, animation: "slide-from-top", type: "error"})
			}
			if(html.type==1){	
				FB.ui( {
				 method: 'feed',
				 mobile_iframe: true,
				 name: title,
				 link: links,
				 picture: images,
				 caption: 'Share link sản phẩm nhận quà từ mada.vn',
				 message: 'Facebook Dialogs are easy!'
			   },
			   function(response) {
					
				 if (response && response.post_id) {
				   
				   	$.ajax({
						type: "POST",
						cache:false,
						url:"/gifts/receiving",
						success: function(data){
							html = JSON.parse(data);
							if(html.type==1){
								swal({title: "Thông báo!", text: html.msg , animation: "slide-from-top",  type: "success"});
							}
								
						}	
					})
				   
				 } else {
					 
				  	swal({title: "Thông báo!", text: "Chia sẻ sản phẩm thất bại!" , animation: "slide-from-top"})
				 }
			   }
			 );
				
			}	
		}	  
		  
	})
}


$(document).ready(function(){
	
	tab();
	opentmenu();
	tabs();
	suggetsearch();
	checkheightdesc();
	$('.inner-html').click(function(){
		$(this).parent('.txt-innser-select').find('.ul-selected').toggle(100);
	});
	$(".captcha").load( "/captcha/created" );
	$("#mada-button-addcart").click(function(){
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
					window.location="/gio-hang.html";

				}
		  });
	}); 
	 $(".abate").click(function(){
    t = parseInt($(this).parent(".choosenumber").find(".number").html())-1;
    if(t<=1){
        t=1;
        $(this).removeClass("active");
        $(this).addClass("disable");
      
    }else{
        $(this).addClass("active");
        $(this).removeClass("disable");
    }
    if(t<=5){
        $(this).parent(".choosenumber").find(".augment").removeClass("disable");
        $(this).parent(".choosenumber").find(".augment").addClass("active");
    }
    $(this).parent(".choosenumber").find(".number").html(t);
    $(this).parent(".choosenumber").find("input[type=hidden]").val(t);
    $("#form-cart").submit();
  });

  $("#paymentarea .pay-config .choosepayment").click(function(){
	  window.location="/";
/*	$(".choosepayment").hide();
	$(".btnOrder").hide();
	$("#paymentarea .onlinemethod").show();*/
  });
  $(".rechoose").click(function(){
	$(".choosepayment").show();
	$(".btnOrder").show();
	$("#paymentarea .onlinemethod").hide();
  });
 $("input[name=ReceiptMethod]").click(function(){
 	if($("#Delivery").is(':checked')){
		$(".area_address").removeClass("hide");
		$(".area_market").addClass("hide");
	 }
	else{
		$(".area_address").addClass("hide");
		$(".area_market").removeClass("hide");
	}
	
	
 });
  $(".augment").click(function(){
    t = parseInt($(this).parent(".choosenumber").find(".number").html())+1;
    if(t>5){
        t=5;
        $(this).removeClass("active");
        $(this).addClass("disable");
        
    }else{
        $(this).addClass("active");
        $(this).removeClass("disable");
       
    }
    if(t>1){
         $(this).parent(".choosenumber").find(".abate").removeClass("disable");
        $(this).parent(".choosenumber").find(".abate").addClass("active");
    }
    $(this).parent(".choosenumber").find(".number").html(t);
    $(this).parent(".choosenumber").find("input[type=hidden]").val(t);
    $("#form-cart").submit();
  });
  $("#form-cart").submit(function(){
    data = $(this).serialize();
    $.ajax({
				type: "POST",
				url: "payment/editcart",
				data:data,
				success: function(res) {
          console.log("edit cart successful");
				}
		  });
      return false;
  });
  $("button.del").click(function(){
		window.location = "/payment/delcart/"+$(this).attr("data-id");
	});
	$("a.newcap").click(function() {
		$.ajax({
			type: "POST",
			url: "/captcha/created",
			success: function(res) {
			if (res)
				{
					$("span.image").html(res);
				}
		   }
	  });
	});
	 if($(window).width()>769){
        $('.navbar .dropdown').hover(function() {
            $(this).find('.dropdown-menu').first().stop(true, true).delay(200).slideDown();

        }, function() {
            $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();

        });

        $('.navbar .dropdown > a').click(function(){
            location.href = this.href;
        });

    } 
	 
 // Top pages
    $(window).scroll(function () {
	if ($(this).scrollTop() > 50) {
			$('#back-to-top').fadeIn();
		} else {
		$('#back-to-top').fadeOut();
		}
	});
	// scroll body to 0px on click
	$('#back-to-top').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});	
	/*$("img.lazy").lazyload({
    	effect : "fadeIn"
	}); */
	//var nice = $("html").niceScroll(); 
	//$('.boxmenu ul.menu').niceScroll();
	//$('.boxcolor ul.bxmanu').niceScroll();
	//$('.box-xsize .bxleft-scroll').niceScroll();
	//$('.box-xcolor .bxleft-scroll').niceScroll();
	/*$('.ul-selected li').click(function(){
		html = $(this).html();
		$('.inner-html').html(html+'<i class="fa fa-caret-down" ></i>');
		$('.searchcatelog').val($(this).attr('value'));
		$('.ul-selected').hide();
		$('.twotabsearchtextbox').css('padding-left',$('.inner-html').innerWidth()+10);
		
	});*/
	$('.sort_change span').click(function(){
		$(this).parent('.sort_change').find('ul.dropdown').toggle();
	});
	$('.box-option input[type=text]').focus(function(){
		$('.border-box').removeClass('active');
		$(this).parents('.border-box').addClass('active');
	});
	$('.boxfcolor span').click(function(){
		val = $(this).attr('value');
		$(this).parents('.border-box').find('input[type=hidden]').val(val);
		$(this).parents('.border-box').find('input[type=text]').val($(this).html());
		$(this).parents('.border-box').removeClass('active');
	});
	$('.btnbuy').click(function(){
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
		$('.formorderdetail').submit();
	});
		
	$('.btnbByPro').click(function(){
		idpro = $(this).attr('idpro');
		 $.ajax({
		  type: "POST",
		  url: "/payment/addcartajax",
		  data:'idpro='+idpro+"&quanty=1",
			success: function(data){ 
				show_box_popup(data,930,365);
			}
		});
		return false;
	});
	
	$("body").delegate(".btndeletecart","click",function(){
		idpro = $(this).attr('data');
		 $.ajax({
		  type: "POST",
		  url: "/payment/delcartajax",
		  data:'id='+idpro,
			success: function(data){ 
				$('.div-log-Ajax').html(data);
			}
		});
		return false;
	});
	$('.js-customer-button').click(function(){
		$('.overload').show();
		 $.ajax({
		  type: "POST",
		  url: "/product/getformcomment",
			success: function(data){
				$('.overload').hide();
				if(data =='1'){  
					swal("Thông báo!", "Vui lòng đăng nhập để đánh giá sản phẩm")
					//show_box_popup_alert("Vui lòng đăng nhập để đánh giá sản phẩm",300,200);
				}else{
					$('.form-comment-add').animate({'bottom':0},400);
				}
			}
		});
	});
	$('#btuntim').click(function(){
		keyword = $('#twotabsearchtextbox').val();
		idcat = $('#s-catelog').val();
		if(keyword==""){
			return false;
		}else{
			window.location = domain+"tim-kiem.html?catelog="+idcat+"&s="+keyword;
		}
	});
	$(".mall-search").keypress(function(e){//khi nhan phim enter se dang nhap
		if (e.which==13)  $("#btuntim").click();	//13 la gia tri  cua enter 
		
	});
	$(".sbar-scroll .mall-search").keypress(function(e){//khi nhan phim enter se dang nhap
		if (e.which==13) {  $("#xbtuntim").click();	//13 la gia tri  cua enter 
		//alert('mada');
		}
	});
	$('#xbtuntim').click(function(){
		keyword = $('#xtwotabsearchtextbox').val();
		idcat = $('#x-catelog').val();
		if(keyword==""){
			return false;
		}else{
			window.location = domain+"tim-kiem.html?catelog="+idcat+"&s="+keyword;
		}
	});
	
	$('.cartquantity').change(function(){
		document.formdathang.action = domain+"payment/editcart";
		document.formdathang.submit();
	});
	$(".fileupload").on('change', function () {
		 //Get count of selected files
		 var imgPath = $(this)[0].value;
		 var fileinput = $(this);
		 var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
		 if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
			 if (typeof (FileReader) != "undefined") {
					 var reader = new FileReader();
					 reader.onload = function (e) {
						 fileinput.parents('div.privew-block').find('.preivews').html('<span class="fa fa-times-circle del-images"></span><img src="'+e.target.result+'" width="104" height="104"  />');
						  fileinput.hide();
					 }
					 reader.readAsDataURL($(this)[0].files[0]);
				 
	
			 } else {
				 alert("Trình duyệt của bạn không trợ upload");
			 }
		 } else {
			 alert("Vui lòng chỉ chọn hình ảnh ");
		 }
	 });
	$("body").delegate(".del-images","click",function(){
		ab = $(this);
		ab.parents(".preivews").parents("div.privew-block").find('.fileupload').show();
		ab.parents(".preivews").parents("div.privew-block").find('.fileupload').val("");
		ab.parents(".preivews").html('<i class="fa fa-cloud-upload"></i> <span>Chọn hình</span>');
	});
	$('.commnet-fb').click(function(event) {
		$('html, body').animate({ scrollTop: $('#tab_review').offset().top -0}, 1000);
		return false;
	});
	$('.content-fk').click(function(event) {
		$('html, body').animate({ scrollTop: $('#tab_congtent').offset().top -0}, 1000);
		return false;
	});
	$('#etalage li').click(function(){
		url = $(this).find('a').attr("rel");
		$('.large-images img').attr('src',url);
		$('#etalage li').removeClass('selected');
		$(this).addClass('selected');
	});
	$('.etalage-gallery li').click(function(){
		url = $(this).find('a').attr("rel");
		$('.gallery__image  img').attr('src',url);
		$('.etalage-gallery li').removeClass('selected');
		$(this).addClass('selected');
	});
	$('.views_change .view_list').click(function(){
		$('.views_change span').removeClass('active');
		$('.views_change span.view_list').addClass('active');
		$('.gridview').addClass('gridlist');
		$('.gridview').removeClass('gridview');
		$.get('/home/changeviews/list');
	});
	$('.views_change .view_grid').click(function(){
		$('.views_change span').removeClass('active');
		$('.views_change span.view_grid').addClass('active');
		$('.gridlist').addClass('gridview');
		$('.gridlist').removeClass('gridlist');
		$.get('/home/changeviews/grid');
	});
	     
	$('.btn-sent-commnet').click(function(){
		data = $('.form-comment-data-add').serialize();
		 $.ajax({
		  type: "POST",
		  url: "/product/comment",
		  data: data,
			success: function(data){
				$('.overload').hide();
				html = JSON.parse(data);
				if(html.err ==true){  
					swal({title: "Thông báo!", text: html.mess, animation: "slide-from-top"})
					//show_box_popup_alert(html.mess,300,200);
				}else{
					swal({title: "Thông báo!", text: html.mess, animation: "slide-from-top"})
					//show_box_popup_alert(html.mess,300,200);
					$('.form-comment-add').animate({'bottom':-225},90);
					$('.form-comment-add input[type=text]').val(' ');
					$('.form-comment-add textarea').val(' ');
				}
			}
		});
	});
	$('.btnemaildk').click(function(){
		dang_xu_ly = $('.dang_xu_ly').val();
		if(dang_xu_ly==0){
			$('.dang_xu_ly').val(1);
			 email= $('.emailrequire_sent').val();
			 $.ajax({
			  type: "POST",
			  url: "/home/email",
			  data:'email='+email,
				success: function(data){
					html = JSON.parse(data);
					swal({title: "Thông báo!", text: html.mess, animation: "slide-from-top"})
					//show_box_popup_alert(html.mess,300,200);
					$('.dang_xu_ly').val(0);
				}
			});
		}else{
			swal({title: "Thông báo!", text: "Hệ thống đăng xử lý...", animation: "slide-from-top"})
			//show_box_popup_alert("Hệ thống đang xử lý...",300,200);
		}
		return false;
	});
	$('.Wishlist').click(function(){
		idpro = $(this).attr('idpro');
		type = $(this).attr('data');
		dang_xu_ly = $('.dang_xu_ly').val();
		ab = $(this);
		if(dang_xu_ly==0){
			$('.dang_xu_ly').val(1);
			 $.ajax({
			  type: "POST",
			  url: "/user/follow/"+idpro+"/"+type,
				success: function(data){
					html = JSON.parse(data);
					if(html.err == true){  
					swal({title: "Thông báo!", text: html.mess, animation: "slide-from-top"})
						//show_box_popup_alert(html.mess,300,200);
					}else{
						if(type == 1){
							ab.removeClass('active');
							ab.attr('data',0);
						}else{
							ab.addClass('active');
							ab.attr('data',1);
						}
					}
					$('.dang_xu_ly').val(0);
				}
			});
		}else{
			swal({title: "Thông báo!", text: "Hệ thống đăng xử lý...", animation: "slide-from-top"})
			//show_box_popup_alert("Hệ thống đang xử lý...",300,200);
		}
		return false;
	});
	
	$("body").delegate(".popup-overlay","click",function(){
		close_box_popup();
	});
	$("body").delegate(".form-popup-login","keypress",function(e){
		if (e.which==13)  $('.btnlogin').click();	//13 la gia tri  cua enter 
	});
	
	$('.dfi-desc').click(function(){
		if($(this).hasClass('open-desc')){
			$('.indesc').css('max-height','none');
			$(this).removeClass('open-desc');
			$('.dfi-desc').html('Rút gọn <i class="fa fa-chevron-up" ></i>');
		}else{
			$('.indesc').css('max-height','60px');
			$(this).addClass('open-desc');
			$('.dfi-desc').html('Xem thêm <i class="fa fa-chevron-down" ></i>');
		}
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
	$('#provinces').change(function(){
		id = $(this).val();
		$('#district').load('payment/district/'+id,function(){$('#district').removeAttr('disabled');})
	});
	$(window).scroll(function() {
		var windowpos = $(window).scrollTop();
		if(windowpos>400){
			$('.sbar-scroll').addClass('actives');
		}else{
			$('.sbar-scroll').removeClass('actives');

		}
	
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
	
	
	$('.submit_btn_card').click(function(){
		var check_nd = $('#check_nd').is(':checked');
				if (check_nd){
					$('.over_payment_watting').show();
					 $.ajax({
						  type: "POST",
						  url: "/payment/getnoidia",
							success: function(data){
								window.location = data;
							}
					 });
				}else{
					
					$('.alert').text("Bạn chưa chọn đồng ý điều khoản thanh toán!" ).css({"color":"red", "display":"block"}); 
					$("html, body").animate({ scrollTop: 0 }, "slow");
     				return false;
			}
	});
	
	$('.submit_btn_visa').click(function(){
		
		var check_visa = $('#check_vs').is(':checked');
				if (check_visa){
	 					$('.over_payment_watting').show();	
							
						 $.ajax({
							  type: "POST",
							  url: "/payment/getvisa",
								success: function(data){
									window.location = data;
							}
						});
  				 }else{
						 
					$('.alert').text("Bạn chưa chọn đồng ý điều khoản thanh toán!" ).css({"color":"red", "display":"block"}); 
					$("html, body").animate({ scrollTop: 0 }, "slow");
					return false;
			}
	});
	
});
function getdistrict(id){
	if(id>0)
		$('.ship-district').load('/user/district/'+id,function(data){ $('.ship-district').removeAttr('disabled');});
}
function loadFormShip(){
	$('.bix-address-ship').load('/payment/formship');
	return false;
}
function getInfoShip(id){
	$('.bix-address-ship').load('/payment/shipinfo/'+id);
}
function Filter_price(url){
	to = $('#toprice').val();
	from = $('#fromprice').val();
	window.location= url+'&max='+to+'&min='+from;
}
function Filter_cat(url){
	window.location= url;
}
function CheckMail(email) {
	var rs = new RegExp("([A-Za-z0-9_.-]){2,}@([A-Za-z0-9_.-]){2,}.([A-Za-z0-9_.-]){2,}");
	if(email.match(rs) == null)
		return false;
	return true;
}

function locdau(str) {  
   str= str.toLowerCase();  
   str= str.replace(/Ã |Ã¡|áº¡|áº£|Ã£|Ã¢|áº§|áº¥|áº­|áº©|áº«|Äƒ|áº±|áº¯|áº·|áº³|áºµ/g,"a");  
   str= str.replace(/Ã¨|Ã©|áº¹|áº»|áº½|Ãª|á»|áº¿|á»‡|á»ƒ|á»…/g,"e");  
   str= str.replace(/Ã¬|Ã­|á»‹|á»‰|Ä©/g,"i");  
   str= str.replace(/Ã²|Ã³|á»|á»|Ãµ|Ã´|á»“|á»‘|á»™|á»•|á»—|Æ¡|á»|á»›|á»£|á»Ÿ|á»¡/g,"o");  
   str= str.replace(/Ã¹|Ãº|á»¥|á»§|Å©|Æ°|á»«|á»©|á»±|á»­|á»¯/g,"u");  
   str= str.replace(/á»³|Ã½|á»µ|á»·|á»¹/g,"y");  
   str= str.replace(/Ä‘/g,"d");     
   return str;  
}
function FormatNumber(str){
    var strTemp = GetNumber(str);
	//alert(strTemp);
    if(strTemp.length <= 3)
        return strTemp;
    strResult = "";
    for(var i =0; i< strTemp.length; i++)
        strTemp = strTemp.replace(".", "");
        strTemp = strTemp.replace(",", "");

    for(var i = strTemp.length; i>=0; i--)
    {
        if(strResult.length >0 && (strTemp.length - i -1) % 3 == 0)
            strResult = "." + strResult;
        strResult = strTemp.substring(i, i + 1) + strResult;
    }	
    return strResult;
}
function FormatNumberNO(strTemp){
    if(strTemp.length <= 3)
        return strTemp;
    strResult = "";
    for(var i =0; i< strTemp.length; i++)
        strTemp = strTemp.replace(".", "");
      strTemp = strTemp.replace(",", "");
	
    for(var i = strTemp.length; i>=0; i--)
    {
        if(strResult.length >0 && (strTemp.length - i -1) % 3 == 0)
            strResult = "." + strResult;
        strResult = strTemp.substring(i, i + 1) + strResult;
    }	
    return strResult;
}
function GetNumber(str)
{
    for(var i = 0; i < str.length; i++)
    {	
        var temp = str.substring(i, i + 1);		
        if(!(temp == "," || temp == "." || (temp >= 0 && temp <=9)))
        {
            alert("Giá chỉ được nhập vào là số từ 0-9");
            return str.substring(0, i);
        }
        if(temp == " ")
            return str.substring(0, i);
    }
    return str;
}

 function IsNumberInt(str)
{
    for(var i = 0; i < str.length; i++)
    {	
        var temp = str.substring(i, i + 1);		
        if(!(temp == "," || temp == "." || (temp >= 0 && temp <=9)))
        {
            alert("Giá chỉ được nhập vào là số từ 0-9");
            return str.substring(0, i);
        }
        if(temp == " " || temp == ",")
            return str.substring(0, i);
    }
    return str;
}

function Format_Price(strTemp)
{             
	strTemp        = strTemp.replace(/,/g, "");
	var priceTy    = parseInt(strTemp/1000000000,0)
	var priceTrieu = parseInt((strTemp % 1000000000)/1000000,0)
	var priceNgan  = parseInt(((strTemp % 1000000000))%1000000/1000,0)
	var priceDong  = parseInt(((strTemp % 1000000000))%1000000%1000,0)
	var strTextPrice = ""

	if(priceTy > 0 && parseInt(strTemp,0) > 900000000)
		strTextPrice = strTextPrice  + "<b>" + priceTy + "</b> Tỷ "
    if(priceTrieu > 0)
    	strTextPrice = strTextPrice  + "<b>" + priceTrieu + "</b> Triệu "
    if(priceNgan > 0)
    	strTextPrice = strTextPrice  + "</b>" + priceNgan + "</b> Ngàn "
    if(priceDong > 0)
    	strTextPrice = strTextPrice  + "<b>" + priceDong + "</b> Đồng "

    if(document.getElementById("currency").value == "VNĐ")
    {
        if(priceTy > 0 || priceTrieu > 0 || priceNgan > 0 || priceDong > 0)
            strTextPrice = strTextPrice  + "<b> VNĐ</b>"
    }


	if(document.getElementById("unit").value == "tổng diện tích")
	{
        strTextPrice = strTextPrice + "<b> / Tổng diện tích</b>";
	}
	if(document.getElementById("unit").value == "m2")
	{
        strTextPrice = strTextPrice + "<b> / m2</b>";
	}
    if(document.getElementById("unit").value == "tháng")
    {
        strTextPrice = strTextPrice + "<b> / Tháng</b>";
    }             
    document.getElementById("priceText").innerHTML = strTextPrice

	return strTextPrice;
}
function CheckAll(chk)
{
	for (i = 0; i < chk.length; i++)
	chk[i].checked = true ;
	document.rowsForm.Check_ctr.checked =true;
}
function UnCheckAll(chk)
{
	for (i = 0; i < chk.length; i++)
	chk[i].checked = false ;
	document.rowsForm.Check_ctr.checked =false;
}

function Check(chk)
{
	if(document.rowsForm.Check_ctr.checked==true){
	for (i = 0; i < chk.length; i++)
	chk[i].checked = true ;
	}else{

	for (i = 0; i < chk.length; i++)
	chk[i].checked = false ;
	}
}
function update_autoup(chk)
{
	var dem=0;
	for(var i =0; i < chk.length; i++)
	{
		if(chk[i].checked==true)
		{
			dem++;
		}
	}
	if(dem ==  0)
	{
		alert("Chọn sản phẩm cần đặt lịch up");
		return false;
	}
	else
	{
		document.rowsForm.submit();
		return true;
	}
}
function tab() {
	$('.texttab').hide();
	$('.texttab:first').show();
	$('.tabs li:first').addClass('active');
	$('.tabs li').click(function(){
	   var  id_content = $(this).find('a').attr("href"); 
	   $('.texttab').hide();
	   $(id_content).fadeIn();
	   $('.tabs li').removeClass('active');
	   $(this).addClass('active');
	   return false;
	});
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

function flyToElement(flyer, flyingTo) {
	var $func = $(this);
	var divider = 3;
	var flyerClone = $(flyer).clone();
	$(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
	$('body').append($(flyerClone));
	var gotoX = $(flyingTo).offset().left;
	var gotoY = $(flyingTo).offset().top;
	 
	$(flyerClone).animate({
		opacity: 0.4,
		left: gotoX+100,
		top: gotoY+5,
		width: 40,
		height: 40
	}, 700,
	function () {
		$(flyingTo).fadeOut('fast', function () {
			$(flyingTo).fadeIn('fast', function () {
				$(flyerClone).fadeOut('fast', function () {
					$(flyerClone).remove();
				});
			});
		});
	});
}
function show_box_popup(v_html,width,height,fix_size) {
	
	fix_size = fix_size || false;
    v_top = 10;
	v_left = 10;
	//Opera Netscape 6 Netscape 4x Mozilla
	if (window.innerWidth || window.innerHeight){
		docwidth = window.innerWidth;
		docheight = window.innerHeight;
	}
	
	//IE Mozilla
	if (document.body.clientWidth || document.body.clientHeight){
		docwidth = document.body.clientWidth;
		docheight = document.body.clientHeight;
	}
	
	v_top = (f_clientHeight()-height)/2;
	if(v_top < 0){
		v_top = 0;
	}
	v_left = (docwidth-width)/2;
	if(v_left < 0){
		v_left = 0;
	}
	
	if (!document.getElementById('_box_popup')) {
		
		var v_popup_overlay = '<div class="popup-overlay" id="_box_overlay"></div><div class="box-popup"  id="_box_popup" style="left:'+v_left+'px;top:'+v_top+'px;"></div>';
		$("body").append(v_popup_overlay);
	} 
	$("#_box_popup").html(v_html);
	$('#_box_overlay').show();
	$('#_box_popup').show();
    if (fix_size) {
        document.getElementById('_box_popup').style.width = width+'px';
        document.getElementById('_box_popup').style.height = height+'px';
    }
	document.getElementById('_box_popup').style.left = v_left+'px';
	document.getElementById('_box_popup').style.top = v_top+'px';
}
function close_box_popup() {
	$("#_box_popup").html('');
	$('#_box_overlay').hide();
	$('#_box_popup').hide();
}
function f_clientWidth() {
	return f_filterResults (
		window.innerWidth ? window.innerWidth : 0,
		document.documentElement ? document.documentElement.clientWidth : 0,
		document.body ? document.body.clientWidth : 0
	);
}
function f_clientHeight() {
	return f_filterResults (
		window.innerHeight ? window.innerHeight : 0,
		document.documentElement ? document.documentElement.clientHeight : 0,
		document.body ? document.body.clientHeight : 0
	);
}
function f_filterResults( n_win, n_docel, n_body) {
	var n_result = n_win ? n_win : 0;
	if (n_docel && (!n_result || (n_result > n_docel)))
		n_result = n_docel;
	return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}
function show_box_popup_alert(data,w,h) {
	vhtml = '<div class="header_pop" >Thông báo</div><div class="content_pop">'+data+'</div><div class="action"><button onClick="javascript:close_box_popup()" class="btnCancel" style="display: inline-block;">Đóng</button></div>';
	show_box_popup(vhtml,w,h);	
}
function show_box_modal(data) {
	vhtml = '<div class="header_pop" >Thông báo</div><div class="content_pop">'+data+'</div><div class="action"><button onClick="javascript:close_box_popup()" class="btnCancel" style="display: inline-block;">Đóng</button></div>';
	show_box_popup(vhtml,w,h);	
}
function cmt_pagination(idpro,page,task){
	$.ajax({
	  type: "POST",
	  url: "/product/loadcomment/"+idpro+"/"+page,
		success: function(data){
			if(task==true){
				$('html, body').animate({ scrollTop: $('#tabs-commnet').offset().top -0}, 1000);
			}
			$('.show-comment-list').html(data);
		}
	});
	return false;
}

function opentmenu(){
	$('.menga_menu:first').show();
	$('.menu-home-default li:first').addClass('selected');
	$('.menu-home-default li').hover(function(){
		if(!$(this).hasClass('selected')){
			id = $(this).find('h3').find('a').attr('data-href');
			$('.menu-home-default li').removeClass('selected');
			$(this).addClass('selected');
			$('.menga_menu').fadeOut(0);
			$(id).fadeIn(0);
		}
	});
}
function show_popup_login(){
	$.get('user/formlogin',function(data){
		show_box_popup(data,700,410);	
	});
	return false;
}
function show_popup_register(){
	$.get('user/formregister',function(data){
		show_box_popup(data,625,410);
	});
	return false;
}
function sent_message(){
	id = $('input[name=idpro]').val();
	deal = $('input[name=deal]').val();
	if(id>0){
		$.get('home/message/'+id+'/'+deal,function(data){
			show_box_popup(data,500,490);
		});
	}
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
				
				close_box_popup();
				location.reload();
			
			}
		}
	});
	return false;
}
function CheckOrder(){
	$.get("/payment/getformcheckorder",function(data){
		show_box_popup(data,400,370);
	});
	return false;
}
function checkorder(){
	codepro = document.formcheckorder.codepro.value;
	phone = document.formcheckorder.phone.value;
	$('.error-ajax').hide();
	if(codepro==""){ $('#codepro-check-order').html("Vui lòng nhập mã đơn hàng").show(); return false; }
	if(phone=="") { $('#phone-check-order').html("Vui lòng nhập số điện thoại").show(); return false; }
	document.formcheckorder.submit();
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
function sharefacebook(url){
	window.open("https://www.facebook.com/sharer/sharer.php?u="+url,"_blank","width=500, height=200");
	return false;
}
function sharegoogle(url){
	window.open("https://plus.google.com/share?url="+url,"_blank","width=500, height=200");
	return false;
}
function sharetpinterest(url,img){
	window.open("https://www.pinterest.com/pin/create/button/?url="+url+"&media="+img,"_blank","width=500, height=200");
	return false;
}
function sharetwitter(url){
	window.open("https://twitter.com/intent/tweet?text="+url,"_blank","width=500, height=200");
	return false;
}
function checkheightdesc(){
	if($('.script-height').innerHeight()<81) $('.dfi-desc').remove();
}
function shortpayment(){
	
	/*$.get('user/fastpayment',function(data){
		show_box_popup(data,820,410);	
	});*/
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

function feedback(id){

	$.get('home/feedback/'+id,function(data){
		show_box_popup(data,500,400);
	});
	return false;
}

			
