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

    API.getPokemonByID(random)
        .then(function successCallback(response) {
            $scope.pokemon = response.data;
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });

});