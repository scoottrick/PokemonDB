app.controller("NavController", function ($scope, $location) {

    $scope.pokedexClick = function () {
        $location.path("/pokedex");
    };

    $scope.trainersClick = function () {
        $location.path("/trainers");
    };

    $scope.gymsClick = function () {
        $location.path("/gyms");
    };

    $scope.badgesClick = function () {
        $location.path("/badges");
    };

});