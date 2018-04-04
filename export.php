<?php  
 //export.php  
 if(!empty($_FILES["excel_file"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "", "testing2");  
      $file_array = explode(".", $_FILES["excel_file"]["name"]);  
      if($file_array[1] == "xls")  
      {  
           include("PHPExcel-1.8/Classes/PHPEXcel/IOfactory.php");  
           $output = '';  
           $output .= "  
           <label class='text-success'>Data Inserted</label>  
                <table class='table table-bordered'>  
                     <tr>  
                          <th>Kegiatan</th>
                          <th>Date</th>   
                     </tr>  
                     ";  
           $object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);  
           foreach($object->getWorksheetIterator() as $worksheet)  
           {  
                $highestRow = $worksheet->getHighestRow();  
                for($row=2; $row<=$highestRow; $row++)  
                {  
                	 date_default_timezone_set('Asia/Jakarta');
                	 $date = date("Y-m-d h:i:s");
                     $kegiatan = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());    
                     $query = "  
                     INSERT INTO data_kegiatan_dimulai  
                     (kegiatan_dimulai, waktu_kegiatan_dimulai)   
                     VALUES ('".$kegiatan."','".$date."')  
                     ";  
                     mysqli_query($connect, $query);  
                     $output .= '  
                     <tr>  
                          <td>'.$kegiatan.'</td>  
                          <td>'.$date.'</td>  
                     </tr>  
                     ';  
                     if ($query) {
                     	header("location:data_kegiatan.php");
                     }
                }  
           }  
           $output .= '</table>';  
           echo $output;  
      }  
      else  
      {  
           echo '<label class="text-danger">Invalid File</label>';  
      }  
 }  
 ?>  