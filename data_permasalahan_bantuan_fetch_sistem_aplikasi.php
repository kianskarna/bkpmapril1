<?php

//user_fetch.php

include('database_connection.php');


$query = '';

$output = array();

$query .= "SELECT * FROM data_permasalahan INNER JOIN (user_details JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_permasalahan.user_id=user_details.user_id WHERE kategori='Sistem Aplikasi' AND status='takTerjawab' AND";


if(isset($_POST["search"]["value"]))
{
	$query .= '(permasalahan_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR permasalahan LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR kategori LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_details.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR provinsi.provinsi LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR waktu_permasalahan LIKE "%'.$_POST["search"]["value"].'%") ';


}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY waktu_permasalahan DESC ';
}

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$date = date("F j, Y H:i:s",strtotime($row['waktu_permasalahan']));
	$status = '';
	if($row["status"] == 'terjawab')
	{
		$status = '<span class="label label-success">Terjawab</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Belum Terjawab</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['permasalahan_id'];
	$sub_array[] = $row['permasalahan'];
	$sub_array[] = $date;
	$sub_array[] = $row['kategori'];
	$sub_array[] = get_provinsi_name($connect, $row['user_id']);
	$sub_array[] = $status;
	
		
			$sub_array[] = get_name($connect, $row['user_id']);
		

	
	$sub_array[] = '<a href="view_permasalahan.php?pdf=1&order_id='.$row["permasalahan_id"].'" class="btn btn-info btn-xs">View PDF</a>';
			$sub_array[] = '<button type="button" name="update" id="'.$row["permasalahan_id"].'" class="btn btn-warning btn-xs update">Selesaikan</button>';
	
	
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows, 
	"recordsFiltered" 	=> 	get_total_all_records($connect), 
	"data"    			=> 	$data
);
echo json_encode($output);

function get_total_all_records($connect)
{

	$statement = $connect->prepare("SELECT * FROM data_permasalahan WHERE  kategori='Sistem Aplikasi' AND status='takTerjawab'");
	$statement->execute();
	return $statement->rowCount();
}


function get_provinsi_name($connect, $user_id)
{
	$query = "
	SELECT * FROM user_details INNER JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi WHERE user_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['provinsi'];
	}
}

function get_name($connect, $user_id)
{
	$query= "
	SELECT * FROM user_details WHERE user_id='".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result =$statement->fetchAll();
	foreach($result as $row)
	{
		return $row['user_name'];
	}

}




?>