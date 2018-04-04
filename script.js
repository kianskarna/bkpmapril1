var app = angular.module('fromRegistration', []);
app.controller('fromRegistrationController', function($scope,$http){
    $scope.btnName ="ADD";
    $scope.insert_again= function(){
      if ($scope.newFullname == null) {
        alert("Full Name is required ");
      }
      else if($scope.newEmail == null){
        alert("Email is required");
      }
      else if ($scope.newPhone == null) {
        alert("Phone Number is required");
      }
      else if ($scope.newAddress == null) {
        alert("Address is required");
      }
      else{


      $http.post(
        "forum_action.php",{
          'fullname': $scope.newFullname,
          'email' : $scope.newEmail,
          'phone' : $scope.newPhone,
          'address' : $scope.newAddress,
          'btnName' : $scope.btnName,
          'regis_id' : $scope.id
        }
        ).success(function(data){
          alert(data);
          $scope.newFullname =null;
          $scope.newEmail = null;
          $scope.newPhone = null;
          $scope.newAddress =null;
          $scope.btnName ="ADD";
          $scope.displayData();
          console.log(data);
          if (data.trim() === 'Insert Data Successfully') {
            window.location.href ='welcome_dashboard.php';
          }
            else
            {
              scope.errorMsg = "Invalid Data";
            }
          
        });
      }
    }

      $scope.displayData = function(){
        $http.get("select.php")
        .success(function(data){
          $scope.names =data;
        });
      }