function MainPageController($http, $scope, $location) {
    $scope.pokemon = [];

    $scope.viewPokemon = function () {
        var id = $scope.pokemon['id'];
        $location.path('/pokedex/' + id);
    };

    var random = Math.floor(Math.random() * 151).toString();
    while (random.length < 3) {
        random = "0" + random;
    };

    $http({
        method: 'GET',
        url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/pokemon/' + random
    }).then(function successCallback(response) {
        $scope.pokemon = response.data;
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });

};