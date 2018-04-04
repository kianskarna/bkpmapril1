<?php

//user_fetch.php

include('database_connection.php');


$query = '';

$output = array();

$query .= "SELECT * FROM data_solusi INNER JOIN data_permasalahan ON data_solusi.permasalahan_id=data_permasalahan.permasalahan_id INNER JOIN user_details ON data_solusi.user_id=user_details.user_id JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi WHERE data_solusi.user_id='".$_SESSION['user_id']."' AND";

if(isset($_POST["search"]["value"]))
{
	$query .= '(solusi_id LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR data_permasalahan.permasalahan LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR data_permasalahan.kategori LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR data_solusi.solusi LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR user_details.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR provinsi.provinsi LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR data_permasalahan.waktu_permasalahan LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR data_solusi.waktu_solusi LIKE "%'.$_POST["search"]["value"].'%") ';


}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY waktu_solusi DESC ';
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
	$date = date("F j, Y H:i:s",strtotime($row['waktu_solusi']));
	$date_solusi = date("F j, Y H:i:s",strtotime(get_waktu_permasalahan($connect, $row['solusi_id'])));
	$sub_array = array();
	$sub_array[] = $row['solusi_id'];
	$sub_array[] = get_permasalahan($connect, $row['solusi_id']);
	$sub_array[] = $date_solusi;
	$sub_array[] = $row['solusi'];
	$sub_array[] = $date;
	$sub_array[] = get_permasalahan_kategori($connect, $row['solusi_id']);
	$sub_array[] = get_provinsi_name($connect, $row['user_id']);
	$sub_array[] = get_pengguna_name($connect, $row['user_id']);
	$sub_array[] = '<a href="view_solusi.php?pdf=1&order_id='.$row["solusi_id"].'" class="btn btn-info btn-xs">View PDF</a>';
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

	$statement = $connect->prepare("SELECT * FROM data_solusi INNER JOIN data_permasalahan ON data_solusi.permasalahan_id=data_permasalahan.permasalahan_id INNER JOIN user_details ON data_solusi.user_id=user_details.user_id JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi WHERE data_solusi.user_id='".$_SESSION['user_id']."'");
	$statement->execute();
	return $statement->rowCount();
}



function get_provinsi_name($connect, $user_id)
{
	$query= "
	SELECT * FROM user_details INNER JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi WHERE user_id = '".$user_id."'
	";
	$statement =$connect->prepare($query);
	$statement->execute();
	$result= $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['provinsi'];
	}
}


function get_pengguna_name($connect, $user_id)
{
	$query= "
	SELECT * FROM user_details INNER JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi WHERE user_id = '".$user_id."'
	";
	$statement =$connect->prepare($query);
	$statement->execute();
	$result= $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['user_name'];
	}
}




function get_permasalahan($connect, $solusi_id)
{
	$query="
	SELECT * FROM data_solusi INNER JOIN data_permasalahan ON data_solusi.permasalahan_id=data_permasalahan.permasalahan_id WHERE solusi_id ='".$solusi_id."'
	";
	$statement= $connect->prepare($query);
	$statement->execute();
	$result=$statement->fetchAll();
	foreach($result as $row)
	{
		return $row['permasalahan'];
	}
}
function get_permasalahan_kategori($connect, $solusi_id)
{
	$query="
	SELECT * FROM data_solusi INNER JOIN data_permasalahan ON data_solusi.permasalahan_id=data_permasalahan.permasalahan_id WHERE solusi_id ='".$solusi_id."'
	";
	$statement= $connect->prepare($query);
	$statement->execute();
	$result=$statement->fetchAll();
	foreach($result as $row)
	{
		return $row['kategori'];
	}
}

function get_waktu_permasalahan($connect, $solusi_id)
{
	$query="
	SELECT * FROM data_solusi INNER JOIN data_permasalahan ON data_solusi.permasalahan_id=data_permasalahan.permasalahan_id WHERE solusi_id ='".$solusi_id."'
	";
	$statement= $connect->prepare($query);
	$statement->execute();
	$result=$statement->fetchAll();
	foreach($result as $row)
	{
		return $row['waktu_permasalahan'];
	}
}
?>