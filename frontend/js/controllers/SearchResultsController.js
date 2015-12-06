function SearchResultsController($http, $scope, $location, $route, $rootScope) {
    $scope.query = $route.current.params.text;
    $scope.results = [];

    var search = function (query) {
        $http({
            method: 'GET',
            url: $rootScope.baseURL+'/search/' + query
        }).then(function successCallback(response) {
            $scope.results = response.data;
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