function PokedexController($http, $scope, $location) {
    $scope.pokedex = [];

    $scope.viewPokemon = function (pokemon) {
        var id = pokemon['id'];
        $location.path('/pokedex/' + id);
    }

    $http({
        method: 'GET',
        url: 'http://localhost:8888/PokemonDB/backend/pokemon'
            //url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/pokemon'
    }).then(function successCallback(response) {
        $scope.pokedex = response.data;
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });

};