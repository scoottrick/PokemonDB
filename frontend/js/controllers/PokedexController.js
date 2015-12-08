app.controller("PokedexController", function ($scope, $location, API) {
    $scope.pokedex = [];
    $scope.sortOptions = {
        ID: "id",
        Name: "name",
        Type: "[type.name, name]"
    };
    $scope.reverse = false;
    $scope.sortValue = $scope.sortOptions.ID;

    $scope.viewPokemon = function (pokemon) {
        var id = pokemon['id'];
        $location.path('/pokedex/' + id);
    };

    $scope.sortBy = function(value){
        if ($scope.sortValue == value){
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortValue = value;
    };

    API.getAllPokemon()
        .then(function successCallback(response) {
            $scope.pokedex = response.data;
        }, function errorCallback(response) {
            API.errorResponse(response);
        });

});