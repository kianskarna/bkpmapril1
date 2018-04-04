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
                            	<h3 class="panel-title">Data Kegiatan Dimulai</h3>
                            </div>
                            <?php
                            	if($_SESSION["type"] == 'master')
                            	{
                            		echo '<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
			                            	<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success btn-xs">Add</button>
			                        	</div>';
                            	}
                            ?>
                            
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
										<th>Waktu Kegiatan</th>
										<th>Provinsi</th>
										<?php
										if($_SESSION['type'] == 'master')
											{
												echo '<th>Pengguna</th>';
											}
										?>
										<th>Status</th>
										<th>View</th>
										<?php
										if($_SESSION['type'] == 'master')
											{
												echo '<th>Selesaikan</th>
												<th>Delete</th>';
											}
										?>
										
									</tr>
								</thead>
                   			</table>
                   			
                   		</div>
                   	</div>
               	</div>
           	</div>
        </div>
        <div id="userModal" class="modal fade">
        	<div class="modal-dialog">
        		<form method="post" id="user_form">
        			<div class="modal-content">
        			<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
        			</div>
        			<div class="modal-body">
        				<div class="form-group">
							<label>Kegiatan</label>
							<input type="text" name="kegiatan_dimulai" id="kegiatan_dimulai" class="form-control" required />
						</div>
						
        			<div class="modal-footer">
        				<input type="hidden" name="kegiatan_dimulai_id" id="kegiatan_dimulai_id" />
        				<input type="hidden" name="btn_action" id="btn_action" />
        				<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
        				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        			</div>
        		</div>
        		</form>
</div>
        	</div>
        </div>
        <div>
        							<?php
										if($_SESSION['type'] == 'master')
											{
												echo '<form method="post" action="excel.php" style="margin-left: 20px;">
									     					<input type="submit" name="export" class="btn btn-success" value="Export Excel" />
									     				    <input type="submit" name="create_pdf" class="btn btn-danger" value="Create PDF" />                     
									   				 </form>';
											}
									?>
        	
        		
        </div>


<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add User");
		$('#action').val("Add");
		$('#btn_action').val("Add");
		
	});

	

	var userdataTable = $('#user_data').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax":{
			url:"data_kegiatan_fetch.php",
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

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"data_kegiatan_action.php",
			method:"POST",
			data:new FormData(this),
				contentType:false,
				processData:false,
			success:function(data)
			{
				$('#user_form')[0].reset();
				$('#userModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				userdataTable.ajax.reload();
			}
		})
	});

	function readURL(input) {

		  if (input.files && input.files[0]) {
		    var reader = new FileReader();

		    reader.onload = function(e) {
		      $('#blah').attr('src', e.target.result);
		    }

		    reader.readAsDataURL(input.files[0]);
		  }
		}

		$("#user_image").change(function() {
		  readURL(this);
		});



	$(document).on('click', '.update', function(){
		var kegiatan_dimulai_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"data_kegiatan_action.php",
			method:"POST",
			data:{kegiatan_dimulai_id:kegiatan_dimulai_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#userModal').modal('show');
				$('#kegiatan_dimulai').val(data.kegiatan_dimulai);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Selesaikan Kegiatan");
				$('#kegiatan_dimulai_id').val(kegiatan_dimulai_id);
				$('#action').val('Selesaikan');
				$('#btn_action').val('Edit');
			}
		})
	});



	$(document).on('click', '.delete', function(){
		var kegiatan_dimulai_id = $(this).attr("id");
		var btn_action = "delete";
		if(confirm("Are you sure you want to delete data ?"))
		{
			$.ajax({
				url:"data_kegiatan_action.php",
				method:"POST",
				data:{kegiatan_dimulai_id:kegiatan_dimulai_id, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					userdataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});

});




	function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}	

	$('table').tableExport();



</script>

<?php
include('footer.php');
?>
