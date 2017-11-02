module.exports = {
  template: require('../../views/views_Module/loginTest.html'),
  controller: loginSampleController,
  controllerAs: 'vm'
};

function loginSampleController($http, $base64) {
  var vm = this;
  
  var auth = $base64.encode("xiaohe@test.com:he"), 
  headers = {"Authorization": "Basic " + auth};
  
  // with auth header
  $http.get('http://localhost:8000/users', {headers: headers}).then(function (response) {
    vm.resp = response;
  });
    
  // without auth header
  $http.get('http://localhost:8000/users').then(function (response) {
    vm.resp2 = response;
  },
  function(response) {
    // Handle error here
    vm.resp2 = 'invalid credential';
    vm.resp3 = response;
  });
}