<div class="main_area">
  <div class="breakcrumb">
    <table border="0">
      <tbody>
        <tr>
          <td width="25"><i class="fa icon-23 fa-windows"></i></td>
          <td> Hệ thống / Đơn hàng / Chi tiết</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="content">
  <div class="content_i">
    <form method="post" name="add-new" action="" enctype="multipart/form-data">
      <table>
      <tr>
        <td style="text-align:left" width="500" valign="top"><h2> <img alt="" src="<?php  echo  ADMIN_PATH_IMG ?>icon-16-info.png"> Thông tin khách hàng </h2>
          <table>
            <tr>
              <td class = 'title_td'>Họ tên</td>
              <td><?php echo $cus[0]['fullname'];?></td>
            </tr>
            <tr>
              <td class = 'title_td'>Địa chỉ</td>
              <td>
                <label id="lblAddress" style="cursor: pointer;display: block;border:1px solid #ccc;"><?php echo $cus[0]['address'];?></label>
                <input id="inputAddress" name="address" style="display: none;width:196px;border:1px solid #ccc;" value="<?php echo $cus[0]['address'];?>" />
              </td>
            </tr>
            <tr>
              <td class = 'title_td'>Quận/ Huyện</td>
              <td style="position: relative;">
                <select name="iddistrict" id="IdDistrict">
                <option value="0">--Quận/Huyện--</option>
                <?php
                $districts = $this->db->query("SELECT Id,title_vn FROM mn_district WHERE idcat='".$cus[0]['idprovinces']."'")->result();
                foreach($districts as $district) :
                ?>
                <option value="<?=$district->Id?>" <?php if($district->Id == $cus[0]['iddistrict']) echo 'selected';?>><?=$district->title_vn?></option>
                <?php endforeach; ?>
                </select>
                <img style="position: absolute;right:-20px;top:7px;display: none;" src="/public/template/admin/images/load-ajax.gif" id="ajaxLoading">
              </td>
            </tr>
            <tr>
              <td class = 'title_td'>Tỉnh/Thành phố</td>
              <td>
                <select name="idprovinces" id="IdProvinces" onchange="javascript:getDistrictByProvince(this);">
                <option value="0">--Tỉnh/TP--</option>
                <?php
                $provinces = $this->db->query("SELECT Id,title_vn FROM mn_provinces")->result();
                foreach($provinces as $province) :
                ?>
                <option value="<?=$province->Id?>" <?php if($province->Id == $cus[0]['idprovinces']) echo 'selected';?>><?=$province->title_vn?></option>
                <?php endforeach; ?>
                </select>
              </td>
            </tr>
            <tr>
              <td class = 'title_td'>Điện thoại</td>
              <td><?php echo $cus[0]['phone'];?></td>
            </tr>
            <tr>
              <td class = 'title_td'>Email</td>
              <td><?php echo $cus[0]['email'];	
		?></td>
            </tr>
            <tr>
              <td class = 'title_td'>Thanh toán</td>
              <td><?php echo $cus[0]['methodpay'];	
		?></td>
            </tr>
            <tr>
              <td class = 'title_td'>Ngày đặt hàng</td>
              <td><?php echo date("d-m-Y",$cus[0]['date']);?></td>
            </tr>
            <tr>
              <td class = 'title_td'>Ghi chú</td>
              <td><?php echo $cus[0]['note'];?></td>
            </tr>
            <tr>
                <td class="" colspan="2">
                    <input type="submit" name="savelocation" value="Cập nhật" style="cursor: pointer;" />
                </td>
            </tr>
          </table></td>
        <td valign="top" style="text-align:left"><h2> <img alt="" src="<?php  echo  ADMIN_PATH_IMG ?>icon-16-info.png"> Xác nhận đơn hàng </h2>
          <p> <b style="padding-right:20px;">Tình trạng:</b>
            <select name="tinhtrang" <?php if($cus[0]['status']==6) echo "disabled" ?> >
              <option value="0" <?php if($cus[0]['status']==0 ) echo 'selected'; ?> >Chưa xác nhận</option>
              <option value="1" <?php if($cus[0]['status']==1 ) echo 'selected'; ?> >Đã xác nhận</option>
              <option value="4" <?php if($cus[0]['status']==4 ) echo 'selected'; ?> >Đóng gói</option>
              <option value="5" <?php if($cus[0]['status']==5 ) echo 'selected'; ?> >Giao hàng</option>
              <option value="2" <?php if($cus[0]['status']==2 ) echo 'selected'; ?> >Đã hoàn thành</option>
              <option value="3" <?php if($cus[0]['status']==3 ) echo 'selected'; ?>>Đơn hàng thất bại</option>
               <option value="6" <?php if($cus[0]['status']==6 ) echo 'selected'; ?>>Bị hủy bời thành viên</option>
            </select>
          </p>
          <p>
          <?php
		  if($cus[0]['status']==6) {
			  
			 $sql ="SELECT mn_customer_reasoncancel.content,mn_customer_reasoncancel.date,mn_reasoncancel.title_vn FROM mn_customer_reasoncancel 
			 INNER JOIN mn_reasoncancel ON mn_reasoncancel.Id = mn_customer_reasoncancel.idreasoncancel WHERE mn_customer_reasoncancel.idcustomer=".$cus[0]['Id'];
			 $info = $this->payment_model->get_query($sql,1,0);
			 	echo "<p class=\"alert alert-danger\">".$info[0]["title_vn"]."<hr />".$info[0]["content"]."</p>";
			}
		  
		  ?>
          </p>
          <p style="padding-left:80px;">
            <input type="submit" value="Cập nhật" name="btnupdate" style="cursor:pointer" />
          </p>
          <h2> <img alt="" src="<?php  echo  ADMIN_PATH_IMG ?>icon-16-info.png"> Thông tin giỏ hàng </h2>
    </form>
    <form action="" method="post">
      <table class="view">
        <tr>
          <th>STT</th>
          <th width="300">Tên sản phẩm</th>
          <th>Hình sản phẩm</th>
          <th>Màu sắc</th>
          <th>Size</th>
          <th>Số lượng</th>
          <th>Đơn giá</th>
          <!-- <th>Giảm giá</th> -->
          <th>Thành tiền</th>
        </tr>
        <?php
	$i=0;
	if(!empty($cart))
	{
		$tongcong = 0; $tong_gia =0; $tongcong_sale =0; $tong =0; $tongcong_discount=0;
		$total_price_voucher = 0;
		foreach($cart as $item)
		{
			
			$i++;
      $pro = $this->product_model->get_Id($item['idpro']);
			/*if($item['deal']==1){
				$pro = $this->deal_model->get_Id($item['idpro']);
			}else{
				$pro = $this->product_model->get_Id($item['idpro']);
			}*/
      
			$price = $item['price'];
      $tong = $price * $item['amount'];
			/*if($pro[0]['discount_code']=='2016MADA' && $pro[0]['code_type']==1){
					$tong = $price * $item['amount'];
					$tongcong_discount += $tong - 1000000;	
			}
			elseif($pro[0]['hot']==1){
					$percent =0;
					$tong_gia = $price * $item['amount'];
					$percent = $tong_gia * 20 / 100;
					$tongcong_sale += $tong_gia - $percent;
					
			}else{
				$tong = $price * $item['amount'];
				$tongcong += $tong;
			}*/
      $tongcong += $tong;
			$id_customer = $this->payment_model->get_id_customer($item['idcustomer']);
			$voucher_sale = $this->payment_model->check_code_voucher($id_customer['code']);
			
			$check_voucher = $this->db->where("order_id", $item['idcustomer'])->get('mn_voucher')->row_array();
			
		?>
        <tr>
          <td align = 'center'><?php echo $i; ?></td>
          <td><?php echo $pro[0]['title_vn'];?>
          		<!-- <?php if($pro[0]['discount_code']=='2016MADA' && $pro[0]['code_type']==1){?>
                	<p style="background:#F00; padding:5px 10px; color:#fff; display:inline-block"><span>Áp dụng mã:</span> <?php echo $pro[0]['discount_code']?></p>
                <?php }?> -->
          	</td>
          <td><img src = 'data/Product/<?php echo $pro[0]['images']; ?>' width = '60'></td>
          <td align="center"><?php
				 if(!empty($item['color'])){
                     $color = $this->color_model->get_where((int)$item['color']);
					 echo '<span class="ibox" style="background-color:'.$color[0]['color'].'"></span>';
				 }
				 
				?></td>
          <td align="center"><?php
				 if(!empty($item['size'])){
                     $size = $this->size_model->get_where((int)$item['size']);
					 echo '<span class="ibox">'.$size[0]['title_vn']."</span>";
				 }
				 
				?></td>
          <td align="center"><?php echo $item['amount']; ?></td>
          <td align = 'right'><?php echo $this->page->bsVndDot($price);?></td>
          <!-- <td align="center"><?php if($pro[0]['hot']==1){echo $this->page->bsVndDot($percent);	}else{ echo '-';}?></td> -->
          <!-- <td align="right"><b>
            <?php 
        			if($pro[0]['hot']==1){
        				echo  $this->page->bsVndDot($tong_gia - $percent);
        				}else 
        			echo  $this->page->bsVndDot($tong);
        			?>
            </b></td> -->
            <td align="right"><b><?php echo $this->page->bsVndDot($tong);?></b></td>
        </tr>
        <?php 
      		} 
      		 /*if($tongcong_discount!==''){
      		$tongcong = $tongcong_discount +  $tongcong;
      		 }
      		$total_price_voucher = $tongcong_sale + $tongcong;*/
      	}
      	?>
		<?php if($check_voucher) { ?>
		<tr>
          <td colspan = '7' align = 'right'><b>Voucher</b></td>
            <td align = 'right' colspan="2"><b>
            <?php echo $check_voucher['code'] . ' - Giảm ' .bsVndDot($check_voucher['price']).' VND' ;?>
			</b></td>
        </tr>
		<?php } ?>
		<tr>
          <td colspan = '7' align = 'right'><b>Phí vận chuyển</b></td>
            <td align = 'right' colspan="2"><b>
            <?php echo bsVndDot($cus[0]['transfee']);?>
            VNĐ</b></td>
        </tr>
        <tr>
          <td colspan = '7' align = 'right'><b>Tổng thanh toán</b></td>
          <!-- <td align = 'right' colspan="2"><b>
            <?php 
          			if($total_price_voucher!=''){	
          				echo  $this->page->bsVndDot($total_price_voucher);
          			}else 
          			echo  $this->page->bsVndDot($tongcong + $cus[0]['transfee'] - $check_voucher['price']);
          			
          		?>
            VNĐ</b></td> -->
            <td align = 'right' colspan="2"><b>
            <?php echo  $this->page->bsVndDot($tongcong + $cus[0]['transfee'] - $check_voucher['price']); ?>
            VNĐ</b></td>
        </tr>
        
		
        <?php if($voucher_sale!=''){?>
        <!-- <tr>
          <td colspan = '7' align = 'right'><b>Giá trị giảm giá:</b></td>
          <td align = 'right' colspan="2"><b>
            <?php
						
			if($voucher_sale['price']=='2000'){echo '2000.000đ';}
			if($voucher_sale['price']=='1000'){echo '1000.000đ';}
			if($voucher_sale['price']=='500'){echo '500.000đ';}
			if($voucher_sale['price']=='200'){echo '200.000đ';}
			if($voucher_sale['price']=='100'){echo '100.000đ';}
			if($voucher_sale['price']=='20'){echo '20%';}
			
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
        </tr> -->
        <!-- <tr>
          <td colspan = '5' align = 'right'><b>Loại voucher</b></td>
          <td align = 'right' colspan="2"><b>
            <?php
			if($voucher_sale['price']=='2000'){echo 'Voucher 2 triệu';}
			if($voucher_sale['price']=='1000'){echo 'Voucher 1 triệu';}
			if($voucher_sale['price']=='500'){echo 'Voucher 500k';}
			if($voucher_sale['price']=='200'){echo 'Voucher 200k';}
			if($voucher_sale['price']=='100'){echo 'Voucher 100k';}
			if($voucher_sale['price']=='20'){echo 'Giảm 20%';}
			?>
            </b></td>
        </tr> -->
        <?php }?>
        <!-- <tr>
          <td colspan = '5' align = 'right'><b>Phí giao hàng</b></td>
          <td align = 'right' colspan="2"><b>
            <?php 
		
		if($voucher_sale!=''){
			
			if($total_price_voucher<150000) { echo  bsVndDot($cus[0]['ship']).'đ'; $tongthanhtoan = $total_price_voucher+$cus[0]['ship']; }
			else if($total_price_voucher >=300000) { echo 'Miễn phí'; $tongthanhtoan = $total_price_voucher; }
			else if($cus[0]['free']==1) { echo 'Miễn phí'; $tongthanhtoan = $total_price_voucher; }
			else { bsVndDot($cus[0]['ship']).'đ'; $tongthanhtoan = $total_price_voucher+$cus[0]['ship'];  }
			}else{
			
			if($tongcong<150000) { echo  bsVndDot($cus[0]['ship']).'đ'; $tongthanhtoan = $tongcong+$cus[0]['ship']; }
			else if($tongcong >=300000) { echo 'Miễn phí'; $tongthanhtoan = $tongcong; }
			else if($cus[0]['free']==1) { echo 'Miễn phí'; $tongthanhtoan = $tongcong; }
			else { bsVndDot($cus[0]['ship']).'đ'; $tongthanhtoan = $tongcong+$cus[0]['ship'];  }
		}
		
		?>
            </b></td>
        </tr> -->
        <!-- <tr>
          <td colspan = '5' align = 'right'><b>Tổng thanh toán</b></td>
          <td align = 'right' colspan="2"><b>
            <?php 
			if($voucher_sale!=''){
				echo bsVndDot($total_price_voucher);
			}
			else{ 
				echo bsVndDot($tongthanhtoan);
			}?>
            VNĐ</b></td>
        </tr> -->
      </table>
    </form>
    </td>
    </tr>
    </table>
    </form>
    <h3 class="title">Ghi chú đơn hàng</h3>
    <div class="viewcomment">
      <?php if(empty($comment)){
	echo '<div class="alert alert-danger">Chưa có ghi chú nào</div>';
}else{
	foreach($comment as $item){
?>
      <div class="itemcm">
        <p class="tibs"><b><?php echo $item['admin'] ?></b><i><?php echo date('H:i d-m-Y ',$item['date']) ?></i></p>
        <p><?php echo $item['content'] ?></p>
      </div>
      <?php }} ?>
    </div>
    <div class="formsent">
      <form action="" method="post">
        <textarea name="note" rows="5" ></textarea>
        <?php echo form_error('note'); ?>
        <button type="submit" name="save" value="save">Ghi chú</button>
      </form>
    </div>
  </div>
</div>
