function MainPageController($http, $scope, $location) {
    $scope.pokemon = [];

    var random = Math.floor(Math.random() * 151).toString();
    while (random.length < 3) {
        random = "0" + random;
    }

    $http({
        method: 'GET',
        url: 'http://localhost:8888/backend/pokemon/' + random
    }).then(function successCallback(response) {
        console.log($scope.pokemon.data);
        $scope.pokemon = response.data;
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });

};