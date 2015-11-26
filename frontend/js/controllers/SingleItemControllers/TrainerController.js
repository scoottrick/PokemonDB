function TrainerController($http, $scope, $location, $route) {

    $scope.trainer = [];
    var id = $route.current.params.name;

    $http({
        method: 'GET',
        url: 'http://localhost:8888/PokemonDB/backend/trainers/' + id
            //url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/trainers/' + id
    }).then(function successCallback(response) {
        $scope.trainer = response.data;
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });
};