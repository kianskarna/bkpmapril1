<?php
//user.php

include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}


include('header.php');


?>
		<span id="alert_action"></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Data Kegiatan Selesai</h3>
                            </div>
                            
                        </div>
                       
                        <div class="clear:both"></div>
                   	</div>
                   	<div class="panel-body" id="result">
                   		<div class="row"><div class="col-sm-12 table-responsive">
                   			
                   			<table id="user_data" class="table table-bordered table-striped">
                   				<thead>
									<tr>
										<th>No</th>
										<th>Kegiatan</th>
										<th>Waktu Dimulai</th>
										<th>Waktu Selesai</th>
										<th>Provinsi</th>
										<th>Pengguna</th>
										<th>View</th>
									</tr>
								</thead>
                   			</table>
                   			
                   		</div>
                   	</div>
               	</div>
           	</div>
        </div>
               <div>
        	
        		<form method="post" action="excel_data_kegiatan_selesai_individual.php" style="margin-left: 20px;">
     					<input type="submit" name="export" class="btn btn-success" value="Export Excel" />
     				    <input type="submit" name="create_pdf" class="btn btn-danger" value="Create PDF" />                     
   				 </form>
        </div>


<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add User");
		$('#action').val("Add");
		$('#btn_action').val("Add");
		$('#user_uploaded_image').html('');
	});

	

	var userdataTable = $('#user_data').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax":{
			url:"data_kegiatan_selesai_individual_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"target":[4,5],
				"orderable":false
			}
		],
		"pageLength": 10
	});

	

});



	$('table').tableExport();



</script>

<?php
include('footer.php');
?>
