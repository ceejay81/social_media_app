angular.module('socialMediaApp').controller('LoginController', function($scope, $http) {
    $scope.login = function() {
      $http.post('/login', $scope.user).then(function(response) {
        // Handle login success
      });
    };
  });
  