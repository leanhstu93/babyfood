var domain = window.location.protocol + "//" + window.location.host+"/";
$(document).ready(function(){
	$('.id-short-cache').click(function(){
		$('.id-short-cache').load(domain+"admincp/website/removecacheAjax");
	});
	// offer
	$('body').on('change','.js-card-type',function(){
		var type = parseInt($(this).val());
		switch (type)
		{
			case 1:
				// tat ca
				$('.js-tab-product').removeClass('active');
				$('.js-tab-category-product').removeClass('active');
				break;
			case 3:
				// danh muc
				$('.js-tab-category-product').addClass('active');
				$('.js-tab-product').removeClass('active');
				break;
			case 5:
				// san pham
				$('.js-tab-category-product').removeClass('active');
				$('.js-tab-product').addClass('active');
				break;
		}
	});
	//sumoselect
	$('.js-select-sumo').SumoSelect({
		search:true,
		placeholder: 'Nhập tên sản phẩm...',
	});
});
function ticlockactive(table,colum,id,value)
{
	document.getElementById(id).innerHTML = "<img src = '"+domain+"public/template/admin/images/load-ajax.gif'>";
	url = domain+"admincp/hidden/ticlock/"+table+"/"+colum+"/"+id+"/"+value;
	//alert(url);
	$(document).ready(function(){
		$('#'+id).load(url);
	});
}
function lockmongo(table,colum,id,value)
{
	document.getElementById(id).innerHTML = "<img src = '"+domain+"public/template/admin/images/load-ajax.gif'>";
	url = domain+"admincp/hidden/ticlock_mongo/"+table+"/"+colum+"/"+id+"/"+value;
	//alert(url);
	$(document).ready(function(){
		$('#'+id).load(url);
	}); 
}
function hideshow(table,colum,id,value,iddiv)
{
	document.getElementById(iddiv).innerHTML = "<img src = '"+domain+"public/template/admin/images/load-ajax.gif'>";
	var url = domain+"admincp/hidden/active/"+table+"/"+colum+"/"+id+"/"+value+"/"+iddiv;
	$(document).ready(function(){
		$('#'+iddiv).load(url);
	});
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
function FormatNumber(str){
    var strTemp = GetNumber(str);
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
function delFile(table,colum,id,value,iddiv,base_url)
{
	document.getElementById(iddiv).innerHTML =  "<img src = '"+domain+"public/template/admin/images/load-ajax.gif'>";
	http.open("get",base_url+"delfile.php?table="+table+"&colum="+colum+"&id="+id+"&value="+value,true);
	http.onreadystatechange=function(){
			if(http.readyState == 4 && http.status == 200){
				var kq = http.responseText; 
				if(kq == 0){
					document.getElementById(iddiv).innerHTML = "Error";
				}else{
					document.getElementById(iddiv).innerHTML = kq;
				}
			}
		};
	http.send("null");
}	

function delFlash(table,colum,id,value)
{
	var http;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	  http=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	  http=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById(colum).innerHTML =  "<img src = '"+domain+"public/template/admin/images/load-ajax.gif'>";
	var url = domain+"admincp/hidden/delflash/"+table+"/"+colum+"/"+id+"/"+value;
	http.open("get",url,true);
	http.onreadystatechange=function(){
		if(http.readyState == 4 && http.status == 200){
			var kq = http.responseText; 
			if(kq == 0){
				document.getElementById(colum).innerHTML = "Error";
			}else{
				document.getElementById(colum).innerHTML = kq;
			}
		}
	};
	http.send("null");
}
function thongbao(info)
{
	cf=confirm(info);
	if (cf)
		return true;
	return false;
}
function checkDelete(waring) {
    if (confirm(waring)) rowsForm.submit();
}

function confirmSave(waring,link) {
	cf = confirm(waring);
	if(cf)
	{
		document.getElementById("rowsForm").action = link;
		document.getElementById("rowsForm").submit();
		return true;
	}else{
		return false;
	}
}

function confirmDelete(mess,chk)
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
		alert("Bạn chưa chọn dữ liệu");
	}
	else
	{
		cf = confirm(mess);
		if(cf)
		{
			document.rowsForm.submit();
			return true;
		}
	}
}
function popitup(url) {
	newwindow = window.open(url,'Đơn hàng Mada.vn','height=480,width=530,top=100,left=250');
	if (window.focus) {newwindow.focus()}
	return false;
}
$(document).ready(function(){
	$('.box_link_list').click(function(){
		style = $(this).attr('style');
		if(style ==undefined){
			$(this).css('height','auto');
		}else{
			$(this).removeAttr('style');
		}
	});
	getOder();
});	
function getOder(){
	 $.ajax({
			type: "POST",
			url: "/admincp/payment/orderjson",
			data:"i=1",
			dataType:"json",
			success: function(res) {
				if(res.alert==true){
					var audio = new Audio('/public/template/mp3/notification.mp3');
					var pathname = window.location.pathname;
					if (pathname.indexOf('admincp/payment/edit') >= 0) {
						audio.pause();
					}
					else {
						audio.play();
					}
					if(res.donhang>0)
						$(".cl-26").find(".bage").html(res.donhang).show();
					if(res.lienhe>0)
						$(".cl-20").find(".bage").html(res.lienhe).show();
				}	
				setTimeout(getOder,1000);
			}
	  });
}	
function getDistrictByProvince(obj) {
    var iddistrict = $(obj).find('option:selected').val();
    var selectDistrict = document.getElementById('IdDistrict');
    $('#ajaxLoading').css('display', 'block');
    $.ajax({
        url: '/admincp/district/ajax_get',
        type: 'post',
        dataType: 'json',
        data: {idcat: iddistrict},
        complete: function() {
            $('#ajaxLoading').css('display', 'none');
        },
        success: function(res) {
            $('#IdDistrict').find('option').remove();
            $(res).each(function(key, item) {
               var opt = document.createElement("option");
               opt.value = item.Id;
               opt.text = item.title_vn;
               selectDistrict.add(opt);
               $('#ajaxLoading').css('display', 'none');
               //console.log(item.title_vn); 
            });
            //$('#IdDistrict').html(res);
        }
    })
}	
$(document).ready(function(){
   $('#lblAddress').dblclick(function() {
        $(this).hide();
        $('#inputAddress').show();
   }); 
   $(document).click(function(event) {
        if(!$(event.target).is('#inputAddress')){
            $('#lblAddress').text($('#inputAddress').val()).show();
            $('#inputAddress').hide();
        }
   });
}); 