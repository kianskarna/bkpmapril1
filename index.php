<?php
//index.php
include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
	header("location:login.php");
}

include('header.php');

?>


	<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: <?php echo ( total_data_permasalahan_lkpm($connect) / total_data_permasalahan_total_kategori($connect) )* 100; ?>em; color: black;">
    <?php echo ( total_data_permasalahan_lkpm($connect) / total_data_permasalahan_total_kategori($connect) )* 100;?>% LKPM
  </div>
</div>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: <?php echo ( total_data_permasalahan_non_sistem($connect) / total_data_permasalahan_total_kategori($connect) )* 100; ?>em;color: black; width: <?php echo ( total_data_permasalahan_non_sistem($connect) / total_data_permasalahan_total_kategori($connect) )* 100; ?>%;">
    <?php echo ( total_data_permasalahan_non_sistem($connect) / total_data_permasalahan_total_kategori($connect) )* 100; ?>% Non Sistem
  </div>
</div>
<div class="progress"> 
  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: <?php echo ( total_data_permasalahan_sistem_aplikasi($connect) / total_data_permasalahan_total_kategori($connect) )* 100; ?>em;color: black;">
    <?php echo ( total_data_permasalahan_sistem_aplikasi($connect) / total_data_permasalahan_total_kategori($connect) )* 100; ?>% Sistem Aplikasi
  </div>
</div>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: <?php echo ( total_data_permasalahan_perizinan($connect) / total_data_permasalahan_total_kategori($connect) )* 100; ?>em;color: black; width: <?php echo ( total_data_permasalahan_perizinan($connect) / total_data_permasalahan_total_kategori($connect) )* 100; ?>%;">
    <?php echo ( total_data_permasalahan_perizinan($connect) / total_data_permasalahan_total_kategori($connect) )* 100; ?>% Perizinan
  </div>
</div>

	<br />
	<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Permasalahan  LKPM</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_permasalahan_lkpm($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Permasalahan  Non Sistem</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_permasalahan_non_sistem($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Permasalahan  Sistem Aplikasi</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_permasalahan_sistem_aplikasi($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Permasalahan  Perizinan</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_permasalahan_perizinan($connect); ?></h1>
			</div>
		</div>
	</div>	
	<?php
	if($_SESSION['type'] == 'master')
	{
	?>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total User</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_user($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Kegiatan</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_kegiatan($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Kegiatan Belum Selesai</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_kegiatan_belum_selesai($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Kegiatan Selesai</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_kegiatan_selesai($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Permasalahan</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_permasalahan($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Permasalahan Belum Terjawab</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_permasalahan_tak_terjawab($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Solusi</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_solusi($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Permasalahan Tidak Terjawab Pedamping</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_solusi_helpdesk($connect); ?></h1>
			</div>
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Solusi Pedamping</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo total_data_solusi_pedamping($connect); ?></h1>
			</div>
		</div>
	</div>

	
	<!-- <div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Brand</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_brand($connect); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Total Item in Stock</strong></div>
			<div class="panel-body" align="center">
				<h1><?php echo count_total_product($connect); ?></h1>
			</div>
		</div>
	</div>
	<?php
	}
	?>
		<?php
		if($_SESSION['type'] == 'master')
		{
		?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Total Order Value User wise</strong></div>
				<div class="panel-body" align="center">
					<?php echo get_user_wise_total_order($connect); ?>
				</div>
			</div>
		</div>
	 -->	<?php
		}
		?>
	</div>

<?php
include("footer.php");
?>