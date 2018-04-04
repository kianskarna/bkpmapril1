<?php

//user_fetch.php

include('database_connection.php');


$query = '';

$output = array();

$query .= "SELECT * FROM data_kegiatan_selesai INNER JOIN (data_kegiatan_dimulai INNER JOIN user_details ON data_kegiatan_dimulai.user_id=user_details.user_id JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_kegiatan_selesai.kegiatan_dimulai_id=data_kegiatan_dimulai.kegiatan_dimulai_id WHERE data_kegiatan_selesai.user_id='".$_SESSION['user_id']."' AND";

if(isset($_POST["search"]["value"]))
{
	$query .= '(kegiatan_selesai_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR kegiatan_dimulai LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_details.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR provinsi.provinsi LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR waktu_kegiatan_dimulai LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR waktu_kegiatan_selesai LIKE "%'.$_POST["search"]["value"].'%") ';


}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY waktu_kegiatan_selesai DESC ';
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
	$date = date("F j, Y H:i:s",strtotime($row['waktu_kegiatan_selesai']));
	
	$sub_array = array();
	$sub_array[] = $row['kegiatan_dimulai_id'];
	$sub_array[] = get_kegiatan_name($connect, $row['kegiatan_selesai_id']);
	$sub_array[] = get_waktu_kegiatan($connect, $row['kegiatan_selesai_id']);
	$sub_array[] = $date;
	$sub_array[] = get_provinsi_name($connect, $row['user_id']);
	
	$sub_array[] = get_user_name($connect, $row['user_id']);
	$sub_array[] = '<a href="view_kegiatan_selesai.php?pdf=1&order_id='.$row["kegiatan_dimulai_id"].'" class="btn btn-info btn-xs">View PDF</a>';
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

	$statement = $connect->prepare("SELECT * FROM data_kegiatan_selesai INNER JOIN (data_kegiatan_dimulai INNER JOIN user_details ON data_kegiatan_dimulai.user_id=user_details.user_id JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_kegiatan_selesai.kegiatan_dimulai_id=data_kegiatan_dimulai.kegiatan_dimulai_id WHERE data_kegiatan_selesai.user_id='".$_SESSION['user_id']."'");
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

function get_kegiatan_name($connect, $kegiatan_selesai_id)
{
	$query = "
	SELECT * FROM data_kegiatan_dimulai INNER JOIN data_kegiatan_selesai ON data_kegiatan_dimulai.kegiatan_dimulai_id=data_kegiatan_selesai.kegiatan_dimulai_id WHERE kegiatan_selesai_id = '".$kegiatan_selesai_id."';
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['kegiatan_dimulai'];
	}
}


function get_waktu_kegiatan($connect, $kegiatan_selesai_id)
{
	$query = "
	SELECT * FROM data_kegiatan_dimulai INNER JOIN data_kegiatan_selesai ON data_kegiatan_dimulai.kegiatan_dimulai_id=data_kegiatan_selesai.kegiatan_dimulai_id WHERE kegiatan_selesai_id = '".$kegiatan_selesai_id."';
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return date("F j, Y H:i:s",strtotime($row['waktu_kegiatan_dimulai']));
	}
}

function get_user_name($connect, $user_id)
{
	$query = "
	SELECT user_name FROM user_details WHERE user_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['user_name'];
	}
}


?>