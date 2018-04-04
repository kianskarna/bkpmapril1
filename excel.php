<?php  
//export.php  
$connect = mysqli_connect("localhost", "root", "", "testing2");
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM data_kegiatan_dimulai INNER JOIN (user_details JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_kegiatan_dimulai.user_id=user_details.user_id";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>No</th>  
                         <th>Kegiatan Dimulai</th>
                         <th>Waktu Kegiatan Dimulai</th>
                         <th>Provinsi</th>
                         <th>Nama Pengguna</th>  
                  
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
  	$no =1;
   $output .= '
    <tr>  
    					  	     <td>'.$no++.'</td>  
                        	  <td>'.$row["kegiatan_dimulai"].'</td>  
                         	  <td>'.$row["waktu_kegiatan_dimulai"].'</td>  
                         	  <td>'.$row["provinsi"].'</td>
                            <td>'.$row["user_name"].'</td>
                   		 </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 }
}


 function fetch_data()  
 {  


      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "testing2");  
      $sql = "SELECT * FROM data_kegiatan_dimulai INNER JOIN (user_details JOIN provinsi ON user_details.provinsi=provinsi.id_provinsi) ON data_kegiatan_dimulai.user_id=user_details.user_id ORDER BY waktu_kegiatan_dimulai DESC";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {       
      $output .= '<tr>  
                          <td>'.$row["kegiatan_dimulai_id"].'</td>  
                          <td>'.$row["kegiatan_dimulai"].'</td>  
                          <td>'.$row["waktu_kegiatan_dimulai"].'</td>  
                          <td>'.$row["provinsi"].'</td>  
                          <td>'.$row["user_name"].'</td>  
                     </tr>  
                          ';  
      }  
      return $output;  
 }  
 if(isset($_POST["create_pdf"]))  
 {  
      require_once('tcpdf/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 8);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h3 align="center">Export HTML Table data to PDF using TCPDF in PHP</h3><br /><br />  
      <table border="1" cellspacing="0" cellpadding="5" >  
           <tr>  
                <th width="5%">ID</th>  
                <th width="15%">Kegiatan Dimulai</th>  
                <th width="20%">Waktu Kegiatan Dimulai</th>  
                <th width="10%">Provinsi</th>  
                <th width="15%">Nama Pengguna</th>  
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('sample.pdf', 'I');  
 }  







?>