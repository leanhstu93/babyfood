<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Hệ thống / Menu Ngang / <?php echo $map_title ?></td>
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
    <td class = 'title_td' width="100">Chủ đề</td>
    <td>
         <select name = 'parentid'>
            <option value = ''>- - Chọn chủ đề - -</option>
             <?php 
				if(!empty($listcat)){
					foreach($listcat  as $row){ 
					 $sub = $this->pagehtml_model->get_menu($row['Id']);
				?>
                <option value="<?php echo $row['Id'] ?>" <?php if($info['parentid']== $row['Id']) echo 'selected'; ?> ><?php echo $row['title_vn'] ?></option>
                <?php
					if(!empty($sub)){
						 foreach($sub as $rw){
				?>
                <option value="<?php echo $rw['Id'] ?>" <?php if($info['parentid']== $rw['Id']) echo 'selected'; ?> >--- <?php echo $rw['title_vn'] ?></option> 
                <?php }}}} ?>
        </select>
    </td>
</tr>
<tr>
	<td class = 'title_td' >Tiêu đề</td>
    <td> <input type="text" name="title_vn" value="<?php echo $info['title_vn'];?>"  style="width:400px">
   		 <?php echo form_error('title_vn'); ?>
     </td>
</tr>
<tr>
    <td class = 'title_td' width="100">Link</td>
    <td>
       <input type="text" name="link" value="<?php echo set_value('link',$info['link']) ?>"  style="width:400px">
        <?php echo form_error('link'); ?> 
    </td>
</tr>
<?php if(!empty($info['images'])){ ?>
<tr>
    <td class = 'title_td' width="100"></td>
    <td>
    <img src="/data/Menu/<?php echo $info['images']; ?>" width="60" />
      </td>
</tr>
<?php } ?>
<tr>
    <td class = 'title_td' width="100">Hình </td>
    <td>
       <input type="file" name="userfile" value="" >
    </td>
</tr>
<tr>
    <td class = 'title_td' width="100">List ID danh mục</td>
    <td>
       <input type="text" name="catelog" value="<?php echo set_value('catelog',$info['catelog']) ?>"  style="width:400px">
        <?php echo form_error('catelog'); ?> 
    </td>
</tr>
<tr>
	<td class = 'title_td' >Sắp xếp</td>
    <td> <input type="text" name="sort" value="<?php echo $info['sort']; ?>"  style="width:200px">
   		 <?php echo form_error('sort'); ?>
     </td>
</tr>

<tr>
	<td class = 'title_td' >Khóa</td>
    <td> <input type="checkbox" value="1" name="ticlock"  <?php if($info['ticlock']==1) echo 'checked'; ?> /> </td>
</tr>
<tr>
<td  ></td>
    <th align = 'left'>
       <button type = 'submit' name="save" value="save"  class="button" >Cập nhật</button> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type = 'reset' value = 'Làm lại' class="button">
    </th>
</tr>	
</table>
</form> 
</div>
</div>  