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
		SELECT * FROM data_solusi INNER JOIN data_permasalahan ON data_solusi.permasalahan_id=data_permasalahan.permasalahan_id INNER JOIN user_details ON data_solusi.user_id=user_details.user_id JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi  WHERE solusi_id = :solusi_id 
	");
	$statement->execute(
		array(
			':solusi_id'       =>  $_GET["order_id"]
		)
	);
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output .= '
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			<tr>
				<td colspan="2" align="center" style="font-size:18px"><b>Permasalahan</b></td>
			</tr>
			<tr>
				<td colspan="2">
				<table width="100%" cellpadding="5">
					<tr>
						<td width="65%">
							
							<b>Pengguna ('.$row["user_name"].')</b><br />
							Permasalahan : '.$row["permasalahan"].'<br />	
							Waktu Permasalahan : '.$row["waktu_permasalahan"].'<br />
							Permasalahan : '.$row["solusi"].'<br />	
							Waktu Permasalahan : '.$row["waktu_solusi"].'<br />
						</td>
						<td width="35%">
							<br />
							Provinsi : '.$row["provinsi"].'<br />
							
						</td>
					</tr>
				</table>
				<br />
				
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
	$file_name = 'Order-'.$row["permasalahan_id"].'.pdf';
	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
}

?>