<?php

include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
  header('location:login.php');
}



include('header.php');
?>



	<script src="angular/angular.min.js"></script>
	<style>
.komentar {
    border: 1px solid #5cb85c;
	border-radius :4px;
    width: 460px;
    height: 300px;
    overflow: scroll;
    text-align: justify;
    padding: 20px 30px;
    background: #666666;
    color: white;
}

@media(min-width: 576px)
{
 .komentar {
    border: 1px solid #5cb85c;
  border-radius :4px;
    width: 1100px;
    height: 470px;
    overflow: scroll;
    text-align: justify;
    color: white;
    padding: 20px 30px;
    background: #666666;
}
}


</style>
	
</head>
<body ng-app="AngularJSCreate" ng-controller="AngularCreateController as angCtrl" ng-init="displayData()"> 
	<div class="container" id="container" style="margin-left: -14px;">
		<div  class="col-lg-13" >
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">Forum Diskusi</div>
				</div>
				<div style="padding-top:30px" class="panel-body">
					<form class="form-horizontal" method="POST" >
						

                      <div class="komentar">
                      
                        <table  style="margin:30px 10px;border-radius: 10px; padding: 100px; background-color: white; color: black;" cellpadding="10"  id="tabel" border="0" ng-repeat="x in names">
                        
                        <tr>
                          <td style="padding-top:7px; padding-left: 7px;color: #a6a6a6; font-size: 12px;"><strong>~{{x.nama_lengkap}} <b style="font-size: 10px;">({{(x.no_telepon)}})</b></strong></td>
                        <tr/>
                        <tr>
                         <td style="padding-left: 7px; ">{{x.komentar}}</td> 
                        </tr>
                        <tr>
                          <td align="right" style="padding-left: 100px; padding-right: 7px; padding-bottom: 5px; font-size: 11px;">{{ x.waktu_komentar}}</td>
                        </tr>
                      </table>
                      </div>


                    <br>
                      <div style="margin-bottom:25px" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
							<input type="text" id="inputuser" class="form-control" ng-model="newKomentar" placeholder="Komentar" name="komentar">
						</div>
						<div style="margin-bottom: 30px;" class="col-sm-12 controls">
							<input type="submit" name="insert" class="btn btn-primary pull-left"  ng-click="insert()" value="Post">
						</div>
						 </div>
                              <div class="alert alert-danger" ng-show="errorMsg">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                      ×</button>
                                  <span class="glyphicon glyphicon-hand-right"></span>&nbsp;&nbsp;{{errorMsg}}
                              </div>
					</form>
					
				</div>
				 
			</div>
		</div>
		
	</div>
<script>
	var app =angular.module("AngularJSCreate" ,[]);
app.controller("AngularCreateController", function($scope, $http){
  $scope.insert = function(){
    $http.post(
      "insert_data.php",{
        'komentar': $scope.newKomentar,
  
      }
      ).success(function(data){
      alert(data);
      $scope.newKomentar = null;
      $scope.displayData();
     
		console.log(data);
        if ( data.trim() === 'Insert Data Successfully') {
        } else {
          $scope.errorMsg = "Username was already been used";
        }

    });
  }
  $scope.displayData = function(){
        $http.get("select_forum.php")
        .success(function(data){
          $scope.names =data;
        });
      }
});


</script>
