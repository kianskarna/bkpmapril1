<?php

//view_order.php

if(isset($_GET["pdf"]) && isset($_GET['order_id']))
{
	require_once 'pdf.php';
	include('database_connection.php');
	include('function.php');
	if(!isset($_SESSION['type']))
	{
		header('location:login.php');
	}
	$output = '';
	
	$statement = $connect->prepare("
		SELECT * FROM data_kegiatan_selesai INNER JOIN (data_kegiatan_dimulai INNER JOIN user_details ON data_kegiatan_dimulai.user_id=user_details.user_id JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_kegiatan_selesai.kegiatan_dimulai_id=data_kegiatan_dimulai.kegiatan_dimulai_id WHERE data_kegiatan_selesai.kegiatan_dimulai_id = :kegiatan_dimulai_id 
	");
	$statement->execute(
		array(
			':kegiatan_dimulai_id'       =>  $_GET["order_id"]
		)
	);
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output .= '
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			<tr>
				<td colspan="2" align="center" style="font-size:18px"><b>Kegiatan</b></td>
			</tr>
			<tr>
				<td colspan="2">
				<table width="100%" cellpadding="5">
					<tr>
						<td width="65%">
							
							<b>Pengguna ('.$row["user_name"].')</b><br />
							Kegiatan Dimulai : '.$row["kegiatan_dimulai"].'<br />	
							Waktu Kegiatan Dimulai : '.$row["waktu_kegiatan_dimulai"].'<br />
							Waktu Kegiatan Selesai : '.$row["waktu_kegiatan_selesai"].'<br />
						</td>
						<td width="35%">
							<br />
							Provinsi : '.$row["provinsi"].'<br />
							
						</td>
					</tr>
				</table>
				<br />
				<table width="50%" border="1" cellpadding="5" cellspacing="0" align="center">
				<tr>
					<td>
						<img src="upload/'.$row["foto_kegiatan_dimulai"].'" class="img-thumbnail" width="500" height="300"  />
					</td>
				</tr>
		';
		$statement = $connect->prepare("
			SELECT * FROM inventory_order_product 
			WHERE kegiatan_dimulai_id = :kegiatan_dimulai_id
		");
		$statement->execute(
			array(
				':kegiatan_dimulai_id'       =>  $_GET["order_id"]
			)
		);
		$product_result = $statement->fetchAll();
		$count = 0;
		$total = 0;
		$total_actual_amount = 0;
		$total_tax_amount = 0;
		foreach($product_result as $sub_row)
		{
			
			
		}
		$output .= '
		
		';
		$output .= '
						</table>
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<p align="right">----------------------------------------<br />Report</p>
						<br />
						<br />
						<br />
					</td>
				</tr>
			</table>
		';
	}
	$pdf = new Pdf();
	$file_name = 'Order-'.$row["kegiatan_dimulai_id"].'.pdf';
	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
}

?>