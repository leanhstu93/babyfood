<?php
$money = 12;
$percent = 10;
$date_now = date('Y-m-d',time());
$dateOf = explode('-', $date_now); 
?>
<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    	<i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Quản lý nội dung / Thống kê</td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="space_10"></div>
<div class="head">
Lọc theo:	<a href="#yesterday">Hôm qua</a> <a href="#today">Hôm nay</a> <a href="#week">Tuần này</a>  <a href="#month">Tháng này</a> <a href="#all" class="tyview">Tất cả</a>
</div>
<div class="space_10"></div> 
<div class="sida-div">
	 <div class="conttab" id="today" >
    <p>Tổng click: <b><?php echo $this->page->bsVndDot($click_now); ?></b></p>
    <p>Tổng thành viên: <b><?php echo $this->page->bsVndDot($total_thanhvien); ?></b></p>
     <p>Thành viên đang hoạt động: <b><?php echo $this->page->bsVndDot($thanhvienactives); ?></b></p>
    <p>Thành viên chưa xác nhận: <b><?php echo $this->page->bsVndDot($thanhviennoact); ?></b></p>
    <p>Thành viên bị khoá: <b><?php echo $this->page->bsVndDot($thanhvienkhoa); ?></b></p>
    <p>Thu nhập: <b><?php echo $this->page->bsVndDot($click_now*$money)." đ"; ?></b></p>
    </div>
    
    <div class="conttab" id="yesterday" >  
    <p>Tổng click: <b><?php echo $this->page->bsVndDot($click_yesrerday); ?></b></p>
    <p>Tổng thành viên: <b><?php echo $this->page->bsVndDot($total_thanhvien); ?></b></p>
     <p>Thành viên đang hoạt động: <b><?php echo $this->page->bsVndDot($thanhvienactives); ?></b></p>
    <p>Thành viên chưa xác nhận: <b><?php echo $this->page->bsVndDot($thanhviennoact); ?></b></p>
    <p>Thành viên bị khoá: <b><?php echo$this->page-> bsVndDot($thanhvienkhoa); ?></b></p>
    <p>Thu nhập: <b><?php echo $this->page->bsVndDot($click_yesrerday*$money)." đ"; ?></b></p>
    </div>

    <div class="conttab" id="week" >
    <p>Tổng click:<b><?php echo $this->page->bsVndDot($click_week); ?></b></p>
    <p>Tổng thành viên: <b><?php echo $this->page->bsVndDot($total_thanhvien); ?></b></p>
     <p>Thành viên đang hoạt động: <b><?php echo $this->page->bsVndDot($thanhvienactives); ?></b></p>
    <p>Thành viên chưa xác nhận: <b><?php echo $this->page->bsVndDot($thanhviennoact); ?></b></p>
    <p>Thành viên bị khoá: <b><?php echo $this->page->bsVndDot($thanhvienkhoa); ?></b></p>
    <p>Thu nhập: <b><?php echo $this->page->bsVndDot($click_week*$money)." đ"; ?></b></p>
    </div>
     <div class="conttab" id="month" >
    <p>Tổng click: <b><?php echo $this->page->bsVndDot($click_month) ?></b></p>
    <p>Tổng thành viên: <b><?php echo $this->page->bsVndDot($total_thanhvien) ?></b></p>
     <p>Thành viên đang hoạt động: <b><?php echo $this->page->bsVndDot($thanhvienactives) ?></b></p>
    <p>Thành viên chưa xác nhận: <b><?php echo $this->page->bsVndDot($thanhviennoact) ?></b></p>
    <p>Thành viên bị khoá: <b><?php echo $this->page->bsVndDot($thanhvienkhoa) ?></b></p>
    <p>Thu nhập: <b><?php echo $this->page->bsVndDot($click_month*$money)." đ"  ?></b></p>
    </div>
    
     <div class="conttab" id="all" >
    <p>Tổng click: <b><?php echo $this->page->bsVndDot($totalclick) ?></b></p>
    <p>Tổng thành viên: <b><?php echo $this->page->bsVndDot($total_thanhvien) ?></b></p>  
     <p>Thành viên đang hoạt động: <b><?php echo $this->page->bsVndDot($thanhvienactives) ?></b></p>
    <p>Thành viên chưa xác nhận: <b><?php echo $this->page->bsVndDot($thanhviennoact) ?></b></p>
    <p>Thành viên bị khoá: <b><?php echo $this->page->bsVndDot($thanhvienkhoa) ?></b></p>
    <p>Hoa hồng: <b><?php echo $this->page->bsVndDot($hoahong[0]['hoahong'])." đ" ?></b></p>
    <p>Tổng thu nhập: <b><?php echo $this->page->bsVndDot($tongthunhap)." đ" ?></b></p>
    <p>Đã thanh toán: <b><?php echo $this->page->bsVndDot($dathanhtoan[0]['payment'])." đ" ?></b></p>
    </div>
 
</div>
<div class="space_10"></div> 


<div class="box-general" style="width:53%; margin-right:5%;">
<h2>LINK TRUY CẬP NHIỀU NHẤT</h2>
<table class="view" >
 <tr >
    <th>STT</th>
    <th width="100">Link</th>
    <th>Thành viên</th>
    <th>view</th>
    <th>Thu nhập</th>
</tr>
<?php
	$k= 0;
	foreach($toplink as $item){
		$k++;
?>
<tr>
	<td><?php echo $k ?></td>
    <td><h3><?php echo BASE_URL.$item->code; ?></h3>
    	<p style="width:300px; font-size:11px; white-space:nowrap; overflow:hidden; white-space:nowrap"><?php echo $item->link; ?></p>	
    </td>
    <td><?php echo $item->username;?></td>
    <td><?php echo $this->page->bsVndDot($item->click); ?></td>
    <td><?php echo $this->page->bsVndDot($item->click*$money)." đ" ?></td>
</tr>
<?php } ?>
</table>
</div>
<div class="box-general">
<h2>THÀNH VIÊN NĂNG ĐỘNG NHẤT</h2>
<table class="view" >
 <tr >
    <th>STT</th>
    <th>Username</th>
    <th>Tổng view</th>
    <th>Doanh thu</th>
    <th>Hoa hồng</th>
    <th>Tổng doanh thu</th>
</tr>
<?php
$l=0;
foreach($topuser as $row){
     $l++;
?>
<tr>
    <td align="center"><?php echo $l ?></td>
    <td align="center">
        <h4><?php echo $row['username']; ?></h4>
    </td>
    <td align="center">
        <?php echo $this->page->bsVndDot($row['clicktotal']);  ?>
    </td>
     <td align="center">
        <?php echo $this->page->bsVndDot($row['tongthunhap']-$row['hoahong']) ?> đ
    </td>
	<td align="center">
        <?php echo $this->page->bsVndDot($row['hoahong'])." đ" ?>
    </td>
    <td align="center">
        <?php echo $this->page->bsVndDot($row['tongthunhap'])." đ" ?>    
    </td>
</tr>
<?php } ?>
</table>
<p style="font-size:11px; text-align:left; font-style:italic">* Bắt đầu từ tháng 3 </p> 
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	 var domain = window.location.protocol + "//" + window.location.host + '/';
	tab3();
	/* $.ajax({
		type: "POST",
		url: domain + "sadmin/updatemoney.php",
		success: function(html) {
			
		}
	});*/
	
});
function tab3() {
    $('.conttab').hide();
    $('.conttab:last').show();
	$('.head a:last').addClass('tyview');
    $('.head a').click(function(){
       var  id_content = $(this).attr("href"); 
	   //alert(id_content);
       $('.conttab').hide();
       $(id_content).fadeIn();
       $('.head a').removeClass('tyview');
       $(this).addClass('tyview');
       return false;
    });

}

</script>   