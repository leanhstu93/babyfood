<div class="main_area">
    <div class="breakcrumb">
    <table border="0">
    <tbody>
    <tr>
    <td width="25">
    <i class="fa icon-23 fa-windows"></i>
    </td>
    <td> Hệ thống / Cấu hình website</td>
    </tr>
    </tbody>
    </table>
    </div>
</div>
<div class="content">
<div class="content_i">
<form action = '<?php echo base_url('admincp/website');  ?>' method = 'post' enctype = "multipart/form-data">
<table>
<tbody>
<tr>
   <td width="600">
<table>

	<tr>
		<td class = 'title_td'>Tiêu đề </td>
		<td><input type='text' name='title_vn' size='50' value='<?php echo set_value('title_vn',$info['title_vn']); ?>'>
        <?php echo form_error('title_vn'); ?>
        </td>
	</tr>
	<tr>
		<td class = 'title_td'>Email</td>
		<td><input type = 'text' name = 'email' size = '50' value='<?php echo set_value('email',$info['email']); ?>'></td>
	</tr>
    <tr>
		<td class = 'title_td'>Hotline</td>
		<td><input type = 'text' name = 'hotline' size = '50' value='<?php echo set_value('hotline',$info['hotline']); ?>'></td>
	</tr>
	<tr>
		<td class = 'title_td' width="100">Meta title</td>
		<td><input type="text" name="meta_title" value="<?php echo set_value('meta_title',$info['meta_title']) ?>"  style="width:400px"></td>
	</tr>
    <tr>
		<td class = 'title_td'>Meta Keyword</td>
		<td><textarea  style="width:400px; height:100px;" name="keyword_vn"><?php echo set_value('keyword_vn',$info['keyword_vn']); ?></textarea></td>
	</tr>
     <tr>
		<td class = 'title_td'>Meta Description</td>
		<td><textarea  style="width:400px; height:100px;" name="description_vn"><?php echo set_value('description_vn',$info['description_vn']); ?></textarea></td>
	</tr>
     <tr>
		<td class = 'title_td'>Google analytics</td>
		<td><textarea  style="width:400px; height:200px;" name="googleanalytics"><?php echo set_value('googleanalytics',htmlspecialchars_decode($info['googleanalytics']));  ?></textarea></td>
	</tr>

	<tr>
   	 <th  align = 'center'>
		<th  align = 'center'>
			<input type = "hidden" >
			<button type = 'submit' value = 'save' name = 'save'  class="button">Cập nhật</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type = 'reset' value = 'Làm lại' class="button" >
		</th>
	</tr>	
</table>
</td>
<td valign="top">

<table>
	<tr>
		<td class = 'title_td'>Xóa cache toàn trang</td>
		<td><a href="<?php echo base_url('admincp/website/removecache'); ?>"><i class="fa fa-toggle-on" style="font-size:25px;"></i></a>
        <span class="input-error ">Lưu ý: việc xóa cache có thể ảnh hưởng đến việc hoạt động của website</span>
    </td>
	</tr>
    <tr>
        <td class = 'title_td'>Bảo trì website</td>
        <td> 
        <select name="enable">
        		<option value="1" <?php echo set_select('enable', '0',$info['enable']==0?TRUE:FALSE); ?>  > Bật </option>
                <option value="0" <?php echo set_select('enable', '0',$info['enable']==0?TRUE:FALSE); ?>  > Tắt </option>
        </select>
        </td>
    </tr>
    <tr>
        <td class = 'title_td'>Đóng dấu ảnh</td>
        <td> 
        <select name="stamp">
        		<option value="1"  <?php echo set_select('stamp', '0',$info['stamp']==0?TRUE:FALSE); ?> > Bật </option>
                <option value="0" <?php echo set_select('stamp', '0',$info['stamp']==0?TRUE:FALSE); ?> > Tắt </option>
        </select>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        	
        </td>
        
    </tr>
</table>

</td>
</tr>
</tbody>
</table>
</div>
</div>  