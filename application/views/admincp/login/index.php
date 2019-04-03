<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <base href="<?php echo BASE_URL?>admincp">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link  href="<?php echo ADMIN_PATH_IMG."icon-login.png"; ?>" rel="shortcut icon" type="images/png" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(ADMIN_PATH_CSS); ?>style_login.css"/>
<title>Administrator</title>
</head>
<body>
<div class="container">
    <div class="title">
        Login Screen

    </div>
    <div class="table">
		<form action = '<?php echo base_url('admincp/login'); ?>' method = 'post'>
        <?php if(!empty($error)) echo "<span class='input-error ' style='text-align: right;margin-right: 10px;'>".$error."</span>"; ?>
        <table width="98%" border="0" cellspacing="0" cellpadding="3" style="margin:0 auto;">
          <tr>
            <td rowspan="4" align="center">
                <img src="<?php echo ADMIN_PATH_IMG.'icon-login.png';?>" /> 
            </td>
      
            <td align="right">Username</td>
            <td><input type = 'text' name = 'username' id = 'username' value="<?php echo set_value('username','') ?>" style="width:99%" >
             <?php echo form_error('username'); ?>
            </td>
          </tr>
          
          <tr>
            <td align="right">Email</td>
            <td><input type = 'text' name = 'email' id = 'email' value="<?php echo set_value('email','') ?>" style="width:99%">
             <?php echo form_error('email'); ?>
            </td>
          </tr>
           <tr>
            <td align="right" >Password</td>
            <td><input type = 'password' name = 'password' id = 'password' style="width:99%">
            	 <?php echo form_error('password'); ?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;  </td>
            <td><input type="submit" name="submit" value="Sign in" id="submit" class="button" /></td>
          </tr>
        </table>
        </form>
    </div>
</div>

</body>

</html>