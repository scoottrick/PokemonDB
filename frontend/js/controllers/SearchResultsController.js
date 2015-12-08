app.controller("SearchResultsController", function ($scope, $location, $route, API) {
    $scope.query = $route.current.params.text;
    $scope.results = {
        badges: [],
        gyms: [],
        pokemon: [],
        trainers: [],
        types: []
    };
    $scope.sortOptions = {
        Default: $scope.query,
        Alphabetical: "name"
    };
    $scope.reverse = false;
    $scope.sortValue = $scope.sortOptions.Default;

    $scope.sortBy = function (value) {
        if ($scope.sortValue == $scope.sortOptions.Alphabetical) {
            $scope.reverse = !$scope.reverse;
        } else {
            $scope.reverse = false;
        }
        $scope.sortValue = value;
    };

    var search = function (query) {
        API.search(query).
        then(function successCallback(response) {
            $scope.results = response.data;
            var data = response.data;
            var badges = data.badges.length;
            var gyms = data.gyms.length;
            var pokemon = data.pokemon.length;
            var trainers = data.trainers.length;
            var types = data.types.length;
            if (badges + gyms + pokemon + trainers + types == 1) {
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
        }, function errorCallback(response) {
            API.errorResponse(response);
        });
    }

    $scope.openItem = function (subject, data) {
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
});