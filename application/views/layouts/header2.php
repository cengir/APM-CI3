<?php
	if (empty($_SESSION['id'])) {
		return redirect('auth/');
	}

	function rp($value){
		return 'Rp.'.number_format($value, 2, ',', '.');
	}
	function tgl($value){
		if($value === '0000-00-00'){
			return '-';
		}else{
			
			return date('d F Y', strtotime($value));
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?></title>

	<link href="<?= base_url('assets/') ?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>css/font-awesome.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>css/datepicker3.css" rel="stylesheet">
	<link href="<?= base_url('assets/') ?>css/styles.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<style>
		.error {
			color: red
		}
		.txtCenter: {
			text-align: center;
		}
		
		.textRight: {
			text-align: right;
		}
	</style>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<script src="<?= base_url('assets/') ?>js/jquery-1.11.1.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="#"><span>Beli</span>-Mobil</a>
				
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?= $_SESSION['nama']; ?></div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>

		<ul class="nav menu">
			<li class="active"><a href="<?php echo base_url('users/index') ?>"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
			<li><a href="<?= base_url('users/history') ?>"><em class="fa fa-sticky-note-o">&nbsp;</em> History Pembayaran
			</a></li>
			<li><a href="<?= base_url('users/bayar') ?>"><em class="fa fa-money">&nbsp;</em> Bayar Cicilan
			</a></li>
			<li><a href="<?= base_url('users/info') ?>"><em class="fa fa-user">&nbsp;</em> Info Profile
			</a></li>
			<li><a href="<?= base_url('auth/logout') ?>"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>

	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="<?= base_url('admin') ?>">
					<em class="fa fa-home"></em>
				</a></li>
				<?php foreach ($link as $key => $value): ?>
					<li class="active">
						<a href="<?= $value; ?>"><?= $key; ?></a>
					</li>
				<?php endforeach ?>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><?= $page; ?></h1>
			</div>
		</div><!--/.row-->