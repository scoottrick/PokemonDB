app.factory("API", function ($http) {

    var baseURL = "http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend";
    //var baseURL = "http://localhost:8888/PokemonDB/backend";
    var factory = {};

    /* ---- GET Requests ---- */

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
    factory.getTrainerById = function (id) {
        return $http({
            method: 'GET',
            url: baseURL + '/trainers/' + id
        });
    };
    factory.getAllGyms = function () {
        return $http({
            method: 'GET',
            url: baseURL + '/gyms'
        });
    };
    factory.getGymById = function (id) {
        return $http({
            method: 'GET',
            url: baseURL + '/gyms/' + id
        });
    };
    factory.search = function (value) {
        return $http({
            method: 'GET',
            url: baseURL + '/search/' + value
        });
    };

    /* ---- POST Requests ---- */

    factory.createNewTrainer = function (trainerData) {
        return $http({
            method: 'POST',
            url: baseURL + '/trainers/create',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                name: trainerData.name,
                rivalId: trainerData.rivalId,
                pokemon: trainerData.pokemon,
                badgeIds: trainerData.badgeIds
            }
        })
    };

    factory.deleteTrainerById = function (id) {
        return $http({
            method: 'POST',
            url: baseURL + '/trainers/delete',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id: id
            }
        });
    };

    factory.deleteBadgeFromTrainer = function (trainerId, badgeId) {
        return $http({
            method: 'POST',
            url: baseURL + '/trainers/' + trainerId + '/badges/remove',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                badgeId: badgeId
            }
        });
    };

    factory.deletePokemonFromTrainer = function (trainerId, pokemonId) {
        return $http({
            method: 'POST',
            url: baseURL + '/trainers/' + trainerId + '/pokemon/remove',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                pokemonId: pokemonId
            }
        });
    };

    factory.addSinglePokemonToTrainer = function (trainerId, pokemon) {
        return $http({
            method: 'POST',
            url: baseURL + '/trainers/' + trainerId + '/pokemon/add',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                pokemonId: pokemon.id,
                pokemonLevel: pokemon.level
            }
        });
    };

    factory.addSingleBadgeToTrainer = function (trainedId, badgeId) {
        return $http({
            method: 'POST',
            url: baseURL + '/trainers/' + trainedId + '/badges/add',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                badgeId: badgeId,
            }
        });
    };

    /* ---- Editing Objects ---- */


    factory.setBadgeImage = function (badge) {
        var name = badge['name'];
        var index = name.indexOf(" ");
        var image = name.substring(0, index);
        badge['image'] = image;
        return badge;
    };

    factory.setBadgeImages = function (badgeArray) {
        var temp = badgeArray;
        for (var i = 0; i < temp.length; i++) {
            var badge = temp[i];
            var name = badge['name'];
            var index = name.indexOf(" ");
            var image = name.substring(0, index);
            badge['image'] = image;
            temp[i] = badge;
        };
        return temp;
    };

    factory.setTrainerImage = function (trainer) {
        if (trainer['id'] <= 10) {
            trainer['image'] = trainer['name'];
        } else {
            trainer['image'] = "Avatar";
        }
        return trainer;
    };

    factory.setTrainerImages = function (trainerArray) {
        var temp = trainerArray;
        for (var i = 0; i < temp.length; i++) {
            var trainer = temp[i];
            if (trainer['id'] <= 10) {
                trainer['image'] = trainer['name'];
            } else {
                trainer['image'] = "Avatar";
            }
            temp[i] = trainer;
        }
        return temp;
    };

    /* ---- Request Errors ---- */

    factory.errorResponse = function (response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    }

    return factory;
});