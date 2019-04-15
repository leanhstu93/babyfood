
<div class="main_area">
  <div class="breakcrumb">
    <table border="0">
      <tbody>
        <tr>
          <td width="25"><i class="fa icon-23 fa-windows"></i></td>
          <td> Nội dung / Chương trình khuyến mãi / <?php echo $map_title ?></td>
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
          <td><input type="text" name="coupon_code" value=""  style="width:400px">
            <?php echo form_error('coupon_code'); ?></td>
        </tr>
        <tr>
          <td class = 'title_td' >Đơn vị khuyến mãi</td>
          <td><select name = 'discount_unit' class="js-discount-unit" style="width:400px">
                  <option value = '1'>VND</option>
                  <option value="3">% Giảm</option>
                  <option value="5">Đồng giá</option>
              </select>
            <?php echo form_error('discount_unit'); ?></td>
        </tr>

      <tr>
          <td class = 'title_td' >Áp dụng cho</td>
          <td>
              <select class="js-card-type" name = 'card_type' style="width:400px">
                  <option value="1">Tất cả</option>
                  <option value="3">Danh mục sản phẩm</option>
                  <option value="5">Sản phẩm</option>
              </select>
              <?php echo form_error('card_type '); ?>
          </td>
      </tr>

      <tr class="js-tab-product tab-product">
          <td class = 'title_td' >Sản phẩm</td>
          <td>
              <select name = 'product_id[]' class="js-select-sumo" style="width:400px" multiple>
                  <?php
                  if(!empty($listproduct)){
                      foreach($listproduct as $item){ ?>
                          <option value="<?php echo $item['Id'] ?>">
                            <?php echo $item['title_vn']; ?>
                          </option>

                  <?php }
                  } ?>
              </select>
              <?php echo form_error('product_id'); ?>
          </td>
      </tr>

      <tr class="js-tab-category-product tab-category-product">
          <td class = 'title_td' >Danh mục sản phẩm</td>
          <td>
              <select name = 'category_id' class="js-select-sumo" style="width:400px" multiple="multiple">
                  <?php
                  if(!empty($listcat)){
                      foreach($listcat as $item){
                          $sub= $this->pagehtml_model->get_catelog($item['Id']);
                          ?>
                          <option value="<?php echo $item['Id'] ?>" <?php echo set_select('parentid', $item['Id']); ?>>
                              <?php echo $item['title_vn']; ?>
                          </option>
                          <?php if(!empty($sub)){
                              foreach($sub as $row){
                                  ?>
                                  <option value="<?php echo $row['Id'] ?>" <?php echo set_select('parentid', $row['Id']); ?>>---<?php echo $row['title_vn']; ?></option>
                              <?php }}}} ?>
              </select>
              <?php echo form_error('category_id'); ?>
          </td>
      </tr>

      <tr>
          <td class = 'title_td' >Giá trị giảm</td>
          <td>
              <div style="position: relative">
                <input name="discount_value" value="<?php echo set_value('discount_value','') ?>" style="width:400px">
                  <div class="js-currency-name" style="position: absolute;
    right: 12px;
    top: 5px;
    bottom: 0;
    margin: auto;
    font-size: 76%;
    color: #797979;">VND</div>
              </div>
              <?php echo form_error('discount_value'); ?></td>
      </tr>

        <tr>
          <td class = 'title_td' >Thời gian bắt đầu</td>
          <td><input autocomplete="off" type="text" name="valid_from" value="" onclick="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})"  style="width:400px">
              <?php echo form_error('valid_from'); ?></td>
          </td>
        </tr>
        <tr>
          <td class = 'title_td' >Thời gian kết thúc</td>
          <td><input autocomplete="off" type="text" name="valid_until" value=""  onclick="WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'})" style="width:400px">
              <?php echo form_error('valid_until'); ?></td>
          </td>
        </tr>
<!--        <tr>-->
<!--          <td class = 'title_td' >Không áp dụng</td>-->
<!--          <td><input type="checkbox" value="1" name="active"  --><?php //echo set_checkbox('active', '1'); ?><!--/></td>-->
<!--        </tr>-->
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
