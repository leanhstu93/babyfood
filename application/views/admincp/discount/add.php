
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
  <div class="content_i">
    <form method="post" name="add-new" action="" enctype="multipart/form-data">
      <table>
        <tr>
          <td class = 'title_td' >Mã giảm giá</td>
          <td><input type="text" name="code" value="<?php echo set_value('code','') ?>"  style="width:400px">
            <?php echo form_error('code'); ?></td>
        </tr>
        <tr>
          <td class = 'title_td' >Giá trị giảm</td>
          <td><input type="text" name="type" value="<?php echo set_value('type','') ?>"  style="width:400px">
            <?php echo form_error('type'); ?></td>
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
