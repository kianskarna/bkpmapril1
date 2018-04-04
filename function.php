<?php
//function.php

function total_data_permasalahan_lkpm($connect)
{
	$query = "
	SELECT * FROM data_permasalahan INNER JOIN (user_details JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_permasalahan.user_id=user_details.user_id WHERE kategori='LKPM' ";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}



function total_data_permasalahan_total_kategori($connect)
{
	$query = "
	SELECT * FROM data_permasalahan INNER JOIN (user_details JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_permasalahan.user_id=user_details.user_id ";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function total_data_permasalahan_non_sistem($connect)
{
	$query = "
	SELECT * FROM data_permasalahan INNER JOIN (user_details JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_permasalahan.user_id=user_details.user_id WHERE kategori='Non Sistem'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}
function total_data_permasalahan_perizinan($connect)
{
	$query = "
	SELECT * FROM data_permasalahan INNER JOIN (user_details JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_permasalahan.user_id=user_details.user_id WHERE kategori='Perizinan' ";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}
function total_data_permasalahan_sistem_aplikasi($connect)
{
	$query = "
	SELECT * FROM data_permasalahan INNER JOIN (user_details JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_permasalahan.user_id=user_details.user_id WHERE kategori='Sistem Aplikasi'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function total_data_kegiatan($connect)
{
	$query = "
	SELECT * FROM data_kegiatan_dimulai";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}


function total_data_kegiatan_belum_selesai($connect)
{
	$query = "
	SELECT * FROM data_kegiatan_dimulai WHERE status='inactive'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}


function total_data_kegiatan_selesai($connect)
{
	$query = "
	SELECT * FROM data_kegiatan_selesai";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function total_data_permasalahan($connect)
{
	$query = "
	SELECT * FROM data_permasalahan";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function total_data_permasalahan_tak_terjawab($connect)
{
	$query = "
	SELECT * FROM data_permasalahan WHERE status='takTerjawab'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function total_data_solusi($connect)
{
	$query = "
	SELECT * FROM data_solusi";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function total_data_solusi_helpdesk($connect)
{
	$query = "
	SELECT * FROM data_solusi INNER JOIN user_details ON data_solusi.user_id=user_details.user_id WHERE user_details.user_type='master'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function total_data_solusi_pedamping($connect)
{
	$query = "
	SELECT * FROM data_solusi INNER JOIN user_details ON data_solusi.user_id=user_details.user_id WHERE user_details.user_type='user'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}



function upload_image()
{
	if(isset($_FILES["user_image"]))
	{
		$extension = explode('.', $_FILES['user_image']['name']);
		$new_name = rand() . '.' . $extension[1];
		$destination = './upload/' . $new_name;
		move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);
		return $new_name;
	}
}

function get_image_name($kegiatan_dimulai_id)
{
	include('db.php');
	$statement = $connection->prepare("SELECT foto_kegiatan_dimulai FROM data_kegiatan WHERE id = '$kegiatan_dimulai_id'");
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["foto_kegiatan_dimulai"];
	}
}

function get_total_all_records()
{
	include('db.php');
	$statement = $connection->prepare("SELECT * FROM users");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

function fill_category_list($connect)
{
	$query = "
	SELECT * FROM category 
	WHERE category_status = 'active' 
	ORDER BY category_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["category_id"].'">'.$row["category_name"].'</option>';
	}
	return $output;
}

function fill_provinsi_list($connect)
{
	$query = "
	SELECT * FROM provinsi 
	ORDER BY provinsi ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["id_provinsi"].'">'.$row["provinsi"].'</option>';
	}
	return $output;
}

function fill_kategori_list($connect)
{
	$query = "
	SELECT * FROM kategori 
	ORDER BY kategori ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["kategori"].'">'.$row["kategori"].'</option>';
	}
	return $output;
}



function fill_permasalahan_list($connect)
{
	$query = "
	SELECT * FROM data_permasalahan 
	ORDER BY permasalahan ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["permasalahan_id"].'">'.$row["permasalahan"].'</option>';
	}
	return $output;
}



function fill_brand_list($connect, $category_id)
{
	$query = "SELECT * FROM brand 
	WHERE brand_status = 'active' 
	AND category_id = '".$category_id."'
	ORDER BY brand_name ASC";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<option value="">Select Brand</option>';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["brand_id"].'">'.$row["brand_name"].'</option>';
	}
	return $output;
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

function get_user_name_row($connect, $user_id)
{
	$query = "
	SELECT user_name FROM user_details 
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['user_name'];
	}
}



function fill_product_list($connect)
{
	$query = "
	SELECT * FROM product 
	WHERE product_status = 'active' 
	ORDER BY product_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["product_id"].'">'.$row["product_name"].'</option>';
	}
	return $output;
}

function fetch_product_details($product_id, $connect)
{
	$query = "
	SELECT * FROM product 
	WHERE product_id = '".$product_id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output['product_name'] = $row["product_name"];
		$output['quantity'] = $row["product_quantity"];
		$output['price'] = $row['product_base_price'];
		$output['tax'] = $row['product_tax'];
	}
	return $output;
}



function available_product_quantity($connect, $product_id)
{
	$product_data = fetch_product_details($product_id, $connect);
	$query = "
	SELECT 	inventory_order_product.quantity FROM inventory_order_product 
	INNER JOIN inventory_order ON inventory_order.inventory_order_id = inventory_order_product.inventory_order_id
	WHERE inventory_order_product.product_id = '".$product_id."' AND
	inventory_order.inventory_order_status = 'active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = 0;
	foreach($result as $row)
	{
		$total = $total + $row['quantity'];
	}
	$available_quantity = intval($product_data['quantity']) - intval($total);
	if($available_quantity == 0)
	{
		$update_query = "
		UPDATE product SET 
		product_status = 'inactive' 
		WHERE product_id = '".$product_id."'
		";
		$statement = $connect->prepare($update_query);
		$statement->execute();
	}
	return $available_quantity;
}

function count_total_user($connect)
{
	$query = "
	SELECT * FROM user_details WHERE user_status='active'";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function count_total_category($connect)
{
	$query = "
	SELECT * FROM category WHERE category_status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function count_total_category_inactive($connect)
{
	$query = "
	SELECT * FROM category WHERE category_status='inactive'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}




function count_total_brand($connect)
{
	$query = "
	SELECT * FROM brand WHERE brand_status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function count_total_product($connect)
{
	$query = "
	SELECT * FROM product WHERE product_status='active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function count_total_order_value($connect)
{
	$query = "
	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order 
	WHERE inventory_order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

function count_total_cash_order_value($connect)
{
	$query = "
	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order 
	WHERE payment_status = 'cash' 
	AND inventory_order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

function count_total_credit_order_value($connect)
{
	$query = "
	SELECT sum(inventory_order_total) as total_order_value FROM inventory_order WHERE payment_status = 'credit' AND inventory_order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["user_id"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

function get_user_wise_total_order($connect)
{
	$query = '
	SELECT sum(inventory_order.inventory_order_total) as order_total, 
	SUM(CASE WHEN inventory_order.payment_status = "cash" THEN inventory_order.inventory_order_total ELSE 0 END) AS cash_order_total, 
	SUM(CASE WHEN inventory_order.payment_status = "credit" THEN inventory_order.inventory_order_total ELSE 0 END) AS credit_order_total, 
	user_details.user_name 
	FROM inventory_order 
	INNER JOIN user_details ON user_details.user_id = inventory_order.user_id 
	WHERE inventory_order.inventory_order_status = "active" GROUP BY inventory_order.user_id
	';
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<tr>
				<th>User Name</th>
				<th>Total Order Value</th>
				<th>Total Cash Order</th>
				<th>Total Credit Order</th>
			</tr>
	';

	$total_order = 0;
	$total_cash_order = 0;
	$total_credit_order = 0;
	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td>'.$row['user_name'].'</td>
			<td align="right">$ '.$row["order_total"].'</td>
			<td align="right">$ '.$row["cash_order_total"].'</td>
			<td align="right">$ '.$row["credit_order_total"].'</td>
		</tr>
		';

		$total_order = $total_order + $row["order_total"];
		$total_cash_order = $total_cash_order + $row["cash_order_total"];
		$total_credit_order = $total_credit_order + $row["credit_order_total"];
	}
	$output .= '
	<tr>
		<td align="right"><b>Total</b></td>
		<td align="right"><b>$ '.$total_order.'</b></td>
		<td align="right"><b>$ '.$total_cash_order.'</b></td>
		<td align="right"><b>$ '.$total_credit_order.'</b></td>
	</tr></table></div>
	';
	return $output;
}

?>