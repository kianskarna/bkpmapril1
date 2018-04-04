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
		SELECT * FROM data_permasalahan INNER JOIN (user_details JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_permasalahan.user_id=user_details.user_id WHERE permasalahan_id = :permasalahan_id 
	");
	$statement->execute(
		array(
			':permasalahan_id'       =>  $_GET["order_id"]
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
						</td>
						<td width="35%">
							<br />
							Provinsi : '.$row["provinsi"].'<br />
							
						</td>
					</tr>
				</table>
				<br />
				<table width="50%" border="1" cellpadding="5" cellspacing="0" align="center">
				
		';
		$statement = $connect->prepare("
			SELECT * FROM data_permasalahan 
			WHERE permasalahan_id = :permasalahan_id
		");
		$statement->execute(
			array(
				':permasalahan_id'       =>  $_GET["order_id"]
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
	$file_name = 'Order-'.$row["permasalahan_id"].'.pdf';
	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
}

?>