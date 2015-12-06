function NavController($http, $scope, $location, $rootScope) {

    $scope.pokedexClick = function(){
        $location.path("/pokedex");
    };

    $scope.trainersClick = function() {
        $location.path("/trainers");
    };

    $scope.gymsClick = function() {
        $location.path("/gyms");
    };

    $scope.badgesClick = function() {
        $location.path("/badges");
    };

};