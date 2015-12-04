function GymsController($http, $scope, $location) {
    $scope.gyms = [];
    
    $scope.openGym = function(name){
        name = name.replace(" ", "_");
        $location.path('/gym/' + name);
    };

    $http({
        method: 'GET',
        //        url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/gyms'
        url: 'http://localhost:8888/PokemonDB/backend/gyms'
    }).then(function successCallback(response) {
        $scope.gyms = response.data;
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });

};