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
                            	<h3 class="panel-title">Data Permasalahan</h3>
                            </div>
                            <?php
                            	if($_SESSION['type'] == 'master')
                            		echo ' <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
			                            	<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success btn-xs">Add</button>
			                        	</div>';
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
										<th>Permasalahan</th>
										<th>Waktu Permasalahan</th>
										<th>Kategori</th>
										<th>Provinsi</th>
										<th>Status</th>
										<th>View</th>
										<th>Pengguna</th>
										<th>Selesaikan</th>
										
										
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
							<label>Permasalahan</label>
							<input type="text" name="permasalahan" id="permasalahan" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Kategori</label>
    						<select name="kategori" id="kategori" class="form-control" required>
								<option value="">Select Category</option>
								<?php echo fill_kategori_list($connect); ?>
							</select>
    					</div>
					</div>
						
        			<div class="modal-footer">
        				<input type="hidden" name="permasalahan_id" id="permasalahan_id" />
        				<input type="hidden" name="btn_action" id="btn_action" />
        				<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
        				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        			</div>
        		</div>
        		</form>

        	</div>
        </div>
        <div>       	

        							<?php
										if($_SESSION["type"] == 'master')
										{
											echo '<form method="post" action="excel_permasalahan.php" style="margin-left: 20px;">
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
		$('#user_uploaded_image').html('');
	});

	

	var userdataTable = $('#user_data').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax":{
			url:"data_permasalahan_fetch.php",
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
			url:"data_permasalahan_action.php",
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
		var permasalahan_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"data_permasalahan_action.php",
			method:"POST",
			data:{permasalahan_id:permasalahan_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#userModal').modal('show');
				
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Selesaikan Permasalahan");
				$('.modal-body').html("<label>Permasalahan</label><br><input type='text' name='permasalahan' id='permasalahan' class='form-control' disabled><label>Kategori</label><br><input type='text' name='kategori' id='kategori' class='form-control' disabled><label>Solusi</label><br><input type='text' name='solusi' id='solusi' class='form-control'> ");
				$('#permasalahan').val(data.permasalahan);
				$('#kategori').val(data.kategori);
				$('#permasalahan_id').val(permasalahan_id);
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
				url:"data_permasalahan_action.php",
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
