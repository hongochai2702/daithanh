var app = angular.module('myApp',['angularUtils.directives.dirPagination','ui.router'])
.factory('DataCache', function($cacheFactory) {
    return $cacheFactory('dataCache', {
        capacity: 3 // optional - turns the cache into LRU cache
    });
 })

///pagination//

app.factory('dataFactory', function($http) {
  var myService = {
    httpRequest: function(url,method,params,dataPost,upload) {
      var passParameters = {};
      passParameters.url = url;

      if (typeof method == 'undefined'){
        passParameters.method = 'GET';
      }else{
        passParameters.method = method;
      }

      if (typeof params != 'undefined'){
        passParameters.params = params;
        passParameters.params = params;
      }

      if (typeof dataPost != 'undefined'){
        passParameters.data = dataPost;
      }

      if (typeof upload != 'undefined'){
         passParameters.upload = upload;
      }
      // passParameters.headers = {'Content-Type': 'application/x-www-form-urlencoded'};
      // var urls = passParameters.url;
      var promise = $http(passParameters).then(function (response) {
        if(typeof response.data == 'string' && response.data != 1){
          if(response.data.substr('loginMark')){
              location.reload();
              return;
          }
          $.gritter.add({
            title: 'Application',
            text: response.data
          });
          return false;
        }
        if(response.data.jsMessage){
          $.gritter.add({
            title: response.data.jsTitle,
            text: response.data.jsMessage
          });
        }
        return response.data;
      },function(){

        $.gritter.add({
          title: 'Application',
          text: 'An error occured while processing your request.'
        });
      });
      return promise;
    }
  };
  return myService;
});
//end pagination 


app.controller('getList', function(dataFactory,$scope, $http) {
  $scope.data = [];
  $scope.pageNumber = 1;
  $scope.libraryTemp = {};
  $scope.totalItemsTemp = {};
  $scope.totalItems = 0;
  $scope.filter_title = 'filter_name';
  $scope.placeholder  = entry_name;
  $scope.changeFilter = function(data){
      $scope.filter_title = data;
      if($scope.filter_title == 'filter_name') {
        $scope.placeholder  = entry_name;
        $('.select_searchText').hide();
         $('.filter').show().val('');
        $('.filter').show();
      } else if ($scope.filter_title == 'filter_model') {
        $scope.placeholder  = entry_model;
        $('.select_searchText').hide();
         $('.filter').show().val('');
        $('.filter').show();
      } else if ($scope.filter_title == 'filter_price') {
        $scope.placeholder  = entry_price;
        $('.select_searchText').hide();
        $('.filter').show().val('');
      } else if ($scope.filter_title == 'filter_quantity') {
          $('.select_searchText').hide();
           $('.filter').show().val('');
        $('.filter').show();
          $scope.placeholder  = entry_quantity;
      } else if ($scope.filter_title == 'filter_status') {
         $('.filter').hide();
         $('.select_searchText').show();

          $scope.placeholder  = entry_status;
      }
  }

  $scope.pageChanged = function(newPage) {
    getResultsPage(newPage);
  };
getResultsPage(1);
//get List json category and product
function getResultsPage(pageNumber) {
      if(! $.isEmptyObject($scope.libraryTemp)){
          dataFactory.httpRequest(urlGetlist+'&'+$scope.filter_title+'='+$scope.searchText+'&page='+pageNumber).then(function(data) {
            $scope.data = data.data;
            $scope.totalItems = data.total;
            $scope.pageNumber = pageNumber;
          });
      }else{
        dataFactory.httpRequest(urlGetlist+'&page='+pageNumber).then(function(data) {
          $scope.data = data.data;
          $scope.totalItems = data.total;
          $scope.pageNumber = pageNumber;
        });
      }
}
//end get List json category and product


//filter category and product
$scope.searchDB = function(){
      if($scope.searchText.length >= 0){
          if($.isEmptyObject($scope.libraryTemp)){
              $scope.libraryTemp = $scope.data;
              $scope.totalItemsTemp = $scope.totalItems;
              $scope.data = {};
          }
          getResultsPage($scope.pageNumber);
      }else{
          if(! $.isEmptyObject($scope.libraryTemp)){
              $scope.data = $scope.libraryTemp ;
              $scope.totalItems = $scope.totalItemsTemp;
              $scope.libraryTemp = {};
          }
      }
}
//end filter category and product


//edit category and product
$scope.edit = function(id){
        var urls  = urlEdit,
            datas = $('.editForm').serialize();
        $http({
          method: 'POST',
          url: urls,
          data: datas,
          headers : {'Content-Type': 'application/x-www-form-urlencoded'},
        })
        .success(function(json){
          if(json['error_success'] == false) {
            getResultsPage($scope.pageNumber);
            var $toast = toastr[shortCutFunction](json['message']);
          } else if (json['error_success'] == true) {
           var $toast = toastr[shortCutFunction3](json['message']);
          } 
        })
}
//end edit category and product


//add product
$scope.addProduct = function(){
var urls  = urlAdd,
    datas = $('.addForm').serialize();
$http({
    method: 'POST',
    url: urls,
    data: datas,
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
})
.success(function(json){
if(json['error_success'] == false) {
        getResultsPage($scope.pageNumber);
        var $toast = toastr[shortCutFunction](json['message']);
    } else if (json['error_success'] == true) {

        var $toast = toastr[shortCutFunction3](json['message']);
     } else {

        var $toast = toastr[shortCutFunction3](text_limit);
    }
});
}
//end add product

//delete product
$scope.deleteProduct = function(product_id){
  if (confirm(text_confirm)) {
      var urls  = urlDelete,
          datas = $.param({
            product_id: product_id,
          });

      $http({
          method: 'POST',
          url: urls,
          data: datas,
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      })
      .success(function(json){
      if(json['error_success'] == false) {
            getResultsPage($scope.pageNumber);
            var $toast = toastr[shortCutFunction](json['message']);
      } else if (json['error_success'] == true) {
          var $toast = toastr[shortCutFunction3](json['message']);
      }
      });
  }
}
//end delete product

//add cateogry
$scope.addCategory = function(){
  var urls  = urlAdd,
      datas = $('.addForm').serialize();
  $http({
      method: 'POST',
      url: urls,
      data: datas,
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
  })
  .success(function(json){
  if(json['error_success'] == false) {
         getResultsPage($scope.pageNumber);
          var $toast = toastr[shortCutFunction](json['message']);
      } else if (json['error_success'] == true) {
           var $toast = toastr[shortCutFunction3](json['message']);
      }

  });
}
//end add cateogry

// delete category
$scope.deleteCategory = function(category_id){
  if (confirm(text_confirm)) {
      var urls  = urlDelete,
          datas = $.param({
            category_id: category_id,
          });

      $http({
          method: 'POST',
          url: urls,
          data: datas,
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      })
      .success(function(json){
        console.log(json);
      if(json['error_success'] == false) {
            getResultsPage($scope.pageNumber);
            var $toast = toastr[shortCutFunction](json['message']);
      } else if (json['error_success'] == true) {
          var $toast = toastr[shortCutFunction3](json['message']);
      }
      });
  }
}
//end delete category

//curent edit product and category//
$scope.curentGetList = {};
$scope.editInfo = function(info){
  $scope.curentGetList = info;
}
//end curent edit product and category//
$scope.showadd_form = true;
$scope.formAddToggle =function(){
$('#addForm').slideToggle();
}
});