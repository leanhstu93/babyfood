<div class="row-white">
  <div class="container">
    <?php $this->load->view("default/persion/left"); ?>
    <div class="main-persion">
      <div class="page-header">
        <h1>Lịch sử mua hàng</h1>
      </div>
      <form action="<?php echo base_url('dat-gio-up.html'); ?>" method="post" name="rowsForm" >
        <div class="main-content div-history">
          <table class="table table-hover table-responsive table-bordered" >
            <tr class="info">
              <th ><input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes" onclick="Check(document.rowsForm.check_list)"></th>
              <th>Mã đơn hàng</th>
              <th>Ngày mua</th>
              <th width="300">Sản phẩm</th>
              <th>Tổng tiền</th>
              <th>Trạng thái đơn hàng</th> 
            </tr>
            <?php
	if(empty($info)){ //neu khong co du lieu
	?>
            <tr>
              <td colspan = '8' class = 'emptydata'><?php echo "Không có sản phẩm nào"; ?></td>
            </tr>
            <?php
	}
	else //neu co du lieu xuat du lieu ra
	{
		$i=0;
		foreach($info as $item)
		{
			$i++;
			$cart = $this->payment_model->get_list_cart(array('idcustomer'=>$item["Id"]));
			$pro =  $this->product_model->get_Id($cart[0]["idpro"]);
			$tongtien = 0;
			if(!empty($cart)){
				foreach($cart as $k){
					$ipro =  $this->product_model->get_Id($k["idpro"]);
					$tongtien = $tongtien+ $ipro[0]["sale_price"]*$k["amount"];
				}
			}
		?>
            <tr>
              <td align="center" ><input type="checkbox" id="check_list" name="check_list[]" value="<?php echo $item['Id']; ?>"></td>
              <td style="text-align:center"><a href="/order-view/<?php echo $item['code']; ?>">#<?php echo $item['code']; ?></a></td>
              <td><?php echo date("d/m/Y",$item['date']);?></td>
              <td><?php if($item["total"]==1) echo $pro[0]["title_vn"]; else echo $pro[0]["title_vn"]." và ".($item["total"]-1)." sản phẩm khác";  ?></td>
              <td><?php echo bsVndDOt($tongtien);?> ₫</td>
              <td align = 'center'>
			   <?php 
		   		if($item['status']==0) echo "<span class=\"label label-default\">chưa xác nhận</span>";
		   		if($item['status']==1) echo "<span class=\"label label-info\">Đã xác nhận</span>";
				if($item['status']==2) echo "<span class=\"label label-success\">Đã hoàn thành</span>";
				if($item['status']==3) echo "<span class=\"label label-danger\">Đơn hàng thất bại</span>";
				if($item['status']==4) echo "<span class=\"label label-info\">Đóng gói</span>";
				if($item['status']==5) echo "<span class=\"label label-primary\">Giao hàng</span>";
				if($item['status']==6) echo "<span class=\"label label-danger\">Đã hủy </span>";
		    ?>
               </td>
            </tr>
            <?php
		}
	}
	?>
          </table>
          <?php 
			echo '<div class="space_5"></div>';
			echo "<div class = 'paging '>";
			if(!empty($page))
			{
				echo $page;
			}
			echo '</div>';
			?>
        </div>
        <input type="hidden"  name="save" value="save"/>
      </form>
    </div>
  </div>
</div>
<div class="xenOverlay timedMessage" >
  <div class="content baseHtml">Your changes have been saved.<span class="close"></span></div>
</div>
