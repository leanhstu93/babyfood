
<div class="main_area">
  <div class="breakcrumb">
    <table border="0">
      <tbody>
        <tr>
          <td width="25"><i class="fa icon-23 fa-windows"></i></td>
          <td> Nội dung / Mã giảm giá / <?php echo $map_title ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="content">
  <div class="content_i wrapper-offer">
    <form method="post" name="add-new" action="" enctype="multipart/form-data">
      <table>
        <tr>
          <td class = 'title_td' >Tạo chương trình khuyến mãi</td>
          <td><input type="text" name="code" value="<?php echo set_value('code','') ?>"  style="width:400px">
            <?php echo form_error('code'); ?></td>
        </tr>
        <tr>
          <td class = 'title_td' >Đơn vị khuyến mãi</td>
          <td><select name = 'valid_until' style="width:400px">
                  <option value = '1'>VND</option>
                  <option value="3">% Giảm</option>
                  <option value="5">Đồng giá</option>
              </select>
            <?php echo form_error('valid_until'); ?></td>
        </tr>

      <tr>
          <td class = 'title_td' >Áp dụng cho</td>
          <td>
              <select class="js-card-type" name = 'card_type' style="width:400px">
                  <option value="1">Tất cả</option>
                  <option value="3">Danh mục sản phẩm</option>
                  <option value="5">Sản phẩm</option>
              </select>
              <?php echo form_error('valid_until'); ?>
          </td>
      </tr>

      <tr class="js-tab-product tab-product">
          <td class = 'title_td' >Sản phẩm</td>
          <td>
              <select name = 'card_type' style="width:400px">
                  <option value="1">Tất cả</option>
                  <option value="3">Danh mục sản phẩm</option>
                  <option value="5">Sản phẩm</option>
              </select>
              <?php echo form_error('valid_until'); ?>
          </td>
      </tr>

      <tr class="js-tab-category-product tab-category-product">
          <td class = 'title_td' >Danh mục sản phẩm</td>
          <td>
              <select name = 'card_type' style="width:400px">
                  <?php echo $this->page->TreeCat($listcat,0,"",set_value('idcat',''),"--");?>
              </select>
              <?php echo form_error('valid_until'); ?>
          </td>
      </tr>

      <tr>
          <td class = 'title_td' >Giá trị giảm</td>
          <td><input name="discount_value" value="<?php echo set_value('discount_value','') ?>" style="width:400px">
              <?php echo form_error('discount_value'); ?></td>
      </tr>

        <tr>
          <td class = 'title_td' >Thời gian bắt đầu</td>
          <td><input type="text" name="start_day" value="<?php echo set_value('start_day','') ?>" onclick="WdatePicker({startDate:'%y-%M-01 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})"  style="width:400px"></td>
        </tr>
        <tr>
          <td class = 'title_td' >Thời gian kết thúc</td>
          <td><input type="text" name="end_day" value="<?php echo set_value('end_day','') ?>"  onclick="WdatePicker({startDate:'%y-%M-01 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" style="width:400px"></td>
        </tr>
        <tr>
          <td class = 'title_td' >Khóa</td>
          <td><input type="checkbox" value="1" name="ticlock"  <?php echo set_checkbox('ticlock', '1'); ?>/></td>
        </tr>
        <tr>
          <td  ></td>
          <th align = 'left'> <button type = 'submit' name="save" value="save"  class="button" >Thêm mới</button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type = 'reset' value = 'Làm lại' class="button">
          </th>
        </tr>
      </table>
    </form>
  </div>
</div>
