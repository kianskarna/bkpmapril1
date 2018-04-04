<?php
include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
	header('location:login.php');
}

include('header.php');

?>



<form method="post" id="comment_form">
    <div class="form-group">
        <label>Permasalahan</label>
        <input name="subject" type="text" id="subject" class="form-control" required>
    </div>
    <div class="form-group">
              <label>Kategori</label>
                <select name="comment" id="comment" class="form-control" required>
                <option value="">Select Category</option>
                <?php echo fill_kategori_list($connect); ?>
              </select>
              </div>
    <div class="form-group">
     <input type="submit" name="post" id="post" class="btn btn-info" value="Post" />
    </div>
   </form>


  <script>
$(document).ready(function(){
 
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"chat_fetch.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('.dropdown-menu#drop').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.cint').html(data.unseen_notification);
     
    }
   }
  });
 }
 
 load_unseen_notification();
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  if($('#subject').val() != '' && $('#comment').val() != '')
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"chat_action.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     $('#comment_form')[0].reset();
     load_unseen_notification();
     alert("Permasalahan Berhasil Di Masukan");
    }
   });
  }
  else
  {
   alert("Both Fields are Required");
  }
 });
 
 $(document).on('click', '#drop', function(){
  $('.cint').html('');
  load_unseen_notification('yes');
 });
 
 setInterval(function(){ 
  load_unseen_notification();; 
 }, 5000);
 
});
</script>