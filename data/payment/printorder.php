<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Đơn hàng Mada.vn</title>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_PATH_CSS; ?>style-printorder.css"/>
</head>

<body>
<div class="tbody">
  <div class="header">
    <div class="left"> <img src="<?php echo PATH_IMG_FLASH."mada-logo.png" ?>" onClick="window.print()" /> </div>
    <div class="right">
      <p class="lx">Website: www.mada.vn</p>
      <p class="lx">Hotline: (08) 3833 8888</p>
      <p class="lx">Đơn hàng số: #<?php echo $cus[0]['code'] ?></p>
    </div>
  </div>
  <div>
    <h1>ĐƠN HÀNG</h1>
    <table>
      <tr><strong>Thông tin khách hàng</strong></tr>
      <tr>
        <td class = 'title_td'>Họ & tên khách hàng: </td>
        <td><strong><?php echo $cus[0]['fullname'];?></strong></td>
      </tr>
      <tr>
        <td class = 'title_td'>Địa chỉ</td>
        <td><strong><?php echo $cus[0]['address'].", ".$cus[0]['district'].", ".$cus[0]['provinces'].", Việt Nam";?></strong></td>
      </tr>
      <tr>
        <td class = 'title_td'>Điện thoại</td>
        <td><strong><?php echo $cus[0]['phone'];?></strong></td>
      </tr>
    </table>
    <table>
      <tr>
        <td height="5"></td>
      </tr>
    </table>
    <table>
      <tr><strong>Thông tin đơn hàng</strong></tr>
      <tr>
        <td class = 'title_td'>Số đơn hàng: </td>
        <td><strong>#<?php echo $cus[0]['code']; ?></strong></td>
      </tr>
      <tr>
        <td class = 'title_td'>Ngày đặt hàng:</td>
        <td><strong><?php echo date('d-m-Y  H:i:s', $cus[0]['date']) ?></strong></td>
      </tr>
      <tr>
        <td class = 'title_td'>Phương thức thanh toán:</td>
        <td><strong><?php echo $cus[0]['methodpay']?></strong></td>
      </tr>
      <!--<tr>
        <td class = 'title_td'>Phương thức vận chuyển:</td>
        <td><strong><?php echo $cus[0]['phone'];?></strong></td>
      </tr>-->
    </table>
    <table>
      <tr>
        <td height="5"></td>
      </tr>
    </table>
    <table class="cart">
      <tr class="bg_tren">
        <th>STT</th>
        <th width="150">Tên Hàng</th>
        <th width="30">Số lượng</th>
        <th>Đơn giá</th>
        <th>Giảm giá</th>
        <th>Thành tiền</th>
      </tr>
      <?php
		$i=0;
		if(!empty($cart)){
			
			$tongcong = 0;$percent =0; $total_price_voucher = 0; $tongcong_sale=0; $tongcong_discount =0;
			
			foreach($cart as $item){
				$i++;
				if($item['deal']==1){
					$pro = $this->deal_model->get_Id($item['idpro']);
				}else{
					$pro = $this->product_model->get_Id($item['idpro']);
				}
				$price = $pro[0]['sale_price'];
				
				if($pro[0]['discount_code']=='2016MADA'){
					$tong = $price * $item['amount'];
					$tongcong_discount += $tong - 1000000;	
				}
				elseif($pro[0]['hot']==1){
					$tong_gia = $price * $item['amount'];
					$percent = $tong_gia * 20 / 100;
					$tongcong_sale += $tong_gia - $percent;
				}
				else{
					$tong = $price * $item['amount'];
					$tongcong += $tong;
				}
			$id_customer = $this->payment_model->get_id_customer($item['idcustomer']);
			$voucher_sale = $this->payment_model->check_code_voucher($id_customer['code']);
		?>
      <tr>
        <td align = 'center'><?php echo $i;?></td>
        <td><?php echo $pro[0]['title_vn'];?>
          <?php
				 if(!empty($item['color'])){
                     $color = $this->color_model->get_where((int)$item['color']);
					 echo '<p class="lnine">Màu sắc: <strong>'.$color[0]['title_vn'].'</strong></p>';
				 }
				 if(!empty($item['size'])){
                     $size = $this->size_model->get_where((int)$item['size']);
					 echo '<p class="lnine">Size:<strong> '.$size[0]['title_vn'].'</strong></p>';
				 }
				 
				?></td>
        <td align = 'center'><?php echo $item['amount'];?></td>
        <td align = 'right'><?php echo $this->page->bsVndDot($price);?></td>
        <td align = 'center'><?php if($pro[0]['hot']==1){echo $this->page->bsVndDot($percent);}else{ echo '-';}?></td>
        <td align = 'right'><?php 
			if($pro[0]['hot']==1){
				echo  $this->page->bsVndDot($tong_gia - $percent);
				}else 
			echo  $this->page->bsVndDot($tong);
			?></td>
      </tr>
      <?php }
	  		
	  		$total_price_voucher = $tongcong_sale + $tongcong;
			
	   }?>
      <tr>
        <td colspan = '5' align = 'right'><b>Cộng</b></td>
        <td align = 'right'><b>
          <?php 
			if($total_price_voucher!=''){	
				echo  $this->page->bsVndDot($total_price_voucher);
			}else 
			echo  $this->page->bsVndDot($tongcong);
			
		?>
          đ</b></td>
      </tr>
      <?php if($pro[0]['hot']!=1 && $voucher_sale['price']>20 ){?>
      <tr>
        <td colspan = '5' align = 'right'><b>Giá trị giảm giá</b></td>
        <td align = 'right'><b>
          <?php
			
			if($voucher_sale['price']=='2000'){echo '2000.000đ';}
			if($voucher_sale['price']=='1000'){echo '1000.000đ';}
			if($voucher_sale['price']=='500'){echo '500.000đ';}
			if($voucher_sale['price']=='200'){echo '200.000đ';}
			if($voucher_sale['price']=='100'){echo '100.000đ';}
			
        	if($voucher_sale['price']=='2000'){
				$total_price_voucher = $tongcong - 2000000;	
			}
			if($voucher_sale['price']=='1000'){
				$total_price_voucher = $tongcong - 1000000;	
			}
			if($voucher_sale['price']=='500'){
				$total_price_voucher = $tongcong - 500000;	
			}
			if($voucher_sale['price']=='200'){
				$total_price_voucher = $tongcong - 200000;	
			}
			if($voucher_sale['price']=='100'){
				$total_price_voucher = $tongcong - 100000;	
			}
		?>
          </b></td>
      </tr>
      <?php }?>
      <tr>
        <td colspan = '5' align = 'right'><b>Phí vận chuyển</b></td>
        <td align = 'right'><b>
          <?php
		  
		 if($voucher_sale!=''){
			 
				if($total_price_voucher>=300000){
					echo 'Miễn phí';
					$tongthanhtoan = $total_price_voucher;
				}else if(
					$total_price_voucher>=150000 && $cus[0]['free']==1){
					echo 'Miễn phí';
					$tongthanhtoan = $total_price_voucher;
				}else{
					echo bsVndDot($cus[0]['ship'])." đ";
					$tongthanhtoan = $total_price_voucher+$cus[0]['ship'];
				}
			
			}else{
					
				if($tongcong>=300000){
					echo 'Miễn phí';
					$tongthanhtoan = $tongcong;
				}else if(
					$tongcong>=150000 && $cus[0]['free']==1){
					echo 'Miễn phí';
					$tongthanhtoan = $tongcong;
				}else{
					echo bsVndDot($cus[0]['ship'])." đ";
					$tongthanhtoan = $tongcong+$cus[0]['ship'];
				}
			}
		?>
          </b></td>
      </tr>
      <tr>
        <td colspan = '5' align = 'right'><b>Tổng thanh toán</b></td>
        <td align = 'right'><b>
          <?php 
		if($voucher_sale!=''){
			echo bsVndDot($total_price_voucher);
		}else{
			echo  bsVndDot($tongthanhtoan);
		}
		?>
          đ</b></td>
      </tr>
    </table>
    <p class="money">(Số tiền bằng chữ:
      <?php 
	if($voucher_sale!=''){
		echo $this->page->readNumber12Digits($total_price_voucher); 
	}else{echo $this->page->readNumber12Digits($tongthanhtoan);}
	?> )</p>
    <p class="vat">(Quý khách có nhu cầu xuất hóa đơn VAT, vui lòng liên hệ hotline: (08) 3833  8888)</p>
    <p class="kygot">Mada.vn xin cảm ơn Quý Khách Hàng đã tin tưởng và sử dung dịch vụ của chúng tôi.</p>
  </div>
</div>
</body>
</html>