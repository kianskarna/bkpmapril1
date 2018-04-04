<?php
//header.php
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sistem Informasi</title>
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>		
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
		 <script type="text/javascript" src="jquery.media.js"></script>
		 <script type="css/js/tableexport.min.js"></script>
		 <script type="css/js/FileSaver.js"></script>
		 
	<link rel="stylesheet" type="text/css" href="css/css/tableexport.min.css">
 
	</head>
	<body>
		<br />
		<div class="container">
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a href="index.php" class="navbar-brand">Home</a>
					</div>
					<?php
					if($_SESSION['type'] == 'master')
					{
					?>
					<ul class="nav navbar-nav">
					
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>Pengguna</a>
							<ul class="dropdown-menu">
								<?php
								if($_SESSION['type'] == 'master')
								{
								?>
												
									<li><a href="user.php">Pedamping</a></li>
									<li><a href="user_helpdesk.php">Helpdesk</a></li>
								<?php
								}
								?>				
							</ul>
						</li>
					</ul>
					<?php
					}
					?>
					<ul class="nav navbar-nav">
					<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>Data Kegiatan</a>
							<ul class="dropdown-menu">
								<?php
								if($_SESSION['type'] == 'master')
								{
								?>
												
									<li><a href="data_kegiatan.php">Data Kegiatan Dimulai</a></li>
									<li><a href="data_kegiatan_selesai.php">Data Kegiatan Selesai</a></li>
								<?php
								}
								?>			
									<li><a href="data_kegiatan_individual.php">Data Kegiatan Dimulai Individual</a></li>
									<li><a href="data_kegiatan_selesai_individual.php">Data Kegiatan Selesai Individual</a></li>
								<?php
								if($_SESSION['type'] == 'master')
								{
								?>
									<li><a href="data_kegiatan_dimulai_update.php">Update Data Kegiatan Dimulai </a></li>
									<li><a href="data_kegiatan_selesai_update.php">Update Data Kegiatan Selesai </a></li>
								<?php
								}
								?>			
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>Data Permasalahan</a>
							<ul class="dropdown-menu">
								<li><a href="data_permasalahan.php">Data Permasalahan</a></li>
								<li><a href="data_permasalahan_individual.php">Data Permasalahan Individual</a></li>
								<li><a href="data_solusi.php">Data Solusi</a></li>
										<li><a href="data_solusi_individual.php">Data Solusi Individual</a></li>
							<?php
							if($_SESSION['type'] == 'master')
							{
							?>
								<li><a href="data_permasalahan_update.php">Update Data Permasalahan </a></li>
								<li><a href="data_solusi_update.php">Update Data Solusi</a></li>
								
							<?php
							}
							?>
							</ul>
						</li>
					<?php
					if($_SESSION['type'] == 'master')
					{
					?>
						<li class="dropdown">
						
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>Laporan Data</a>
							<ul class="dropdown-menu">
								<li><a href="data_kegiatan_selesai.php">Laporan Data Kegiatan Dimulai dan Selesai</a></li>
								<li><a href="data_solusi.php">Laporan Data Permasalahan dan Solusi</a></li>
								
							</ul>
						</li>
					<?php
					}
					?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>Bantuan</a>
							<ul class="dropdown-menu">
						<li><a href="chat.php">Meminta Bantuan</a></li>
						<li><a href="data_permasalahan_bantuan.php">Permasalahan Belum Terjawab</a></li>

							</ul>
						</li>
						
						<!-- <li><a href="order.php">Order</a></li> -->
					</ul>
				</li>
							<ul class="nav navbar-nav">
					
						<li><a href="forum.php">Forum Chat</a></li>
						
					
					</ul>
					<ul class="nav navbar-nav navbar-right">
						  <li class="dropdown">
					       <a href="#" class="drop" data-toggle="dropdown"><span class="label label-pill label-danger cint" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-envelope" style="font-size:18px;"></span></a>
					       <ul class="dropdown-menu" id="drop"></ul>
					      </li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo $_SESSION["user_name"]; ?></a>
							<ul class="dropdown-menu" >
								<li><a href="profile.php">Profile</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					</ul>

				</div>
			</nav>
			