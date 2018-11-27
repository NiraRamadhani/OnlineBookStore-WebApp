angular.module('probookApp', [])
  .controller('ProbookController', function($scope) {
    var probook = this;
    probook.books = []
    probook.searchTerm = "";

    probook.search = function(){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
          while (probook.books.length > 0){
            probook.books.pop();
          }
          console.log(this.responseText);
          json = JSON.parse(this.responseText);
          angular.forEach(json.item, function(book){
            probook.books.push(book);
          });
          console.log(probook.searchTerm);
          console.log('done');
          console.log(probook.books);
          $scope.$apply();
         }
        };
      xhttp.open("POST", "./soapclient.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("judul="+probook.searchTerm);
    }
  });