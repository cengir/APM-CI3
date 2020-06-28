<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>.:: Login Admin ::.</title>

	<link href="<?= base_url('assets/') ?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>css/datepicker3.css" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>css/styles.css" rel="stylesheet">
	<style>
		.error {
	      color: red;
	   }
	</style>
</head>
<body>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">LOGIN ADMIN</div>
				<div class="panel-body">
					<form role="form" method="post" action="<?= base_url('auth/login_admin') ?>" id="form_admin">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" id="password" type="password" value="">
							</div>
							<input type="submit" class="btn btn-primary btn-block" value="Login" />
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	

	<script src="<?= base_url('assets/') ?>js/jquery-1.11.1.min.js"></script>
	<script src="<?= base_url('assets/') ?>js/bootstrap.min.js"></script>

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


	<script>

		$(document).ready(function(){

			<?php 
				if ($this->session->flashdata('error')) {
					?>
						swal('Login Gagal', "<?= $this->session->flashdata('error') ?>", "error");
					<?php
				}
			?>

			$('#form_admin').validate({
				rules: {
					username: "required",
					password: {
						required: true,
						minlength: 5
					}
				},
				messages: {
					username: 'Username tidak boleh Kosong',
					password: {
						required: 'Password tidak boleh Kosong',
						minlength: 'Password Minimal 5 Karakter'
					}
				},
				errorElement : 'em',
			})
		})

	</script>
</body>
</html>
