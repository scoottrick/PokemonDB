app.factory("API", function($http){

    //    var baseURL = "http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend";
    var baseURL = "http://localhost:8888/PokemonDB/backend";
    var factory = {};

    factory.getAllBadges = function () {
        return $http({
            method: 'GET',
            url: baseURL + '/badges'
        });
    };
    factory.getAllPokemon = function () {
        return $http({
            method: 'GET',
            url: baseURL + '/pokemon'
        });
    };
    factory.getPokemonById = function (id) {
        return $http({
            method: 'GET',
            url: baseURL + '/pokemon/' + id
        });
    };
    factory.getAllTrainers = function () {
        return $http({
            method: 'GET',
            url: baseURL + '/trainers'
        });
    };

    return factory;
});