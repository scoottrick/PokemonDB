app.controller("PokedexController", function ($scope, $location, API) {
    $scope.pokedex = [];

    $scope.viewPokemon = function (pokemon) {
        var id = pokemon['id'];
        $location.path('/pokedex/' + id);
    }

    API.getAllPokemon().then(function successCallback(response) {
        $scope.pokedex = response.data;
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });

});