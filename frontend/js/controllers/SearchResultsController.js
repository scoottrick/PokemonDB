function SearchResultsController($http, $scope, $location, $route, $rootScope) {
    $scope.query = $route.current.params.text;
    $scope.results = {
        badges: [],
        gyms: [],
        pokemon: [],
        trainers: [],
        types: []
    };

    var search = function (query) {
        $http({
            method: 'GET',
            url: $rootScope.baseURL+'/search/' + query
        }).then(function successCallback(response) {
            $scope.results = response.data;
            var data = response.data;
            var badges = data.badges.length;
            var gyms = data.gyms.length;
            var pokemon = data.pokemon.length;
            var trainers = data.trainers.length;
            var types = data.types.length;
            if (badges+gyms+pokemon+trainers+types == 1) {
                if (data.badges.length) {
                    $scope.openItem("badges", data.badges[0]);
                } else if (data.gyms.length) {
                    $scope.openItem("gyms", data.gyms[0]);
                } else if (data.pokemon.length) {
                    $scope.openItem("pokemon", data.pokemon[0]);
                } else if (data.trainers.length) {
                    $scope.openItem("trainers", data.trainers[0]);
                }
            }
            console.log($scope.results);


        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });
    }

    $scope.openItem = function (subject, data) {
        console.log(subject);
        console.log(data);
        switch (subject) {
        case "badges":
            $location.path("/badges");
            break;
        case "gyms":
            $location.path("/gym/" + data.name);
            break;
        case "pokemon":
            $location.path("/pokedex/" + data.id);
            break;
        case "trainers":
            $location.path("/trainer/" + data.name);
            break;
        case "types":
            $location.path("/");
            break;
        default:
            alert("Error: Invalid subject");
            break;
        }
    }

    search($scope.query);
};