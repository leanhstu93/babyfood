<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Nội dung / Chủ đề bài viết / <?php echo $map_title ?></td>
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
            <?php echo $this->page->TreeCat($listcat,0,"",$info['parentid'],"--");?>
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
	<td class = 'title_td' >Alias</td>
    <td> <input type="text" name="alias" value="<?php echo $info['alias']; ?>"  style="width:400px"> 
     	<?php echo form_error('alias'); ?>
     </td>
</tr>
<tr>
    <td class = 'title_td'> Meta Keyword</td>
    <td><textarea name="meta_keyword" style="width:400px; height:100px;" ><?php echo $info['meta_keyword'] ?></textarea>
     <?php echo form_error('meta_keyword'); ?>
    </td>
</tr>
<tr>
    <td class = 'title_td'> Meta Description</td>
    <td><textarea name="meta_description" style="width:400px; height:100px;"  ><?php echo $info['meta_description']; ?></textarea>
     <?php echo form_error('meta_description'); ?>
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