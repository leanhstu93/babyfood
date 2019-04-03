<style type="text/css">
.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
	padding: 15px;
    margin: 10px 0;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-transition: opacity .15s linear;
    -o-transition: opacity .15s linear;
    transition: opacity .15s linear;
	
}
</style>
<div class="alert-danger">
	<strong><?php  
	$username = $this->session->userdata('login_admin_username');
	echo $username; ?> </strong> không đủ quyền truy cập vô trang này 
</div>