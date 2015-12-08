app.controller("MainPageController", function ($scope, $location, API) {
    $scope.pokemon = [];

    $scope.viewPokemon = function () {
        var id = $scope.pokemon['id'];
        $location.path('/pokedex/' + id);
    };

    var random = Math.floor(Math.random() * 151).toString();
    while (random.length < 3) {
        random = "0" + random;
    };

    API.getPokemonById(random)
        .then(function successCallback(response) {
            $scope.pokemon = response.data;
        }, function errorCallback(response) {
            API.errorResponse(response);
        });

});