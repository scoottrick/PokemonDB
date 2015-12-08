app.controller("BadgesController", function ($http, $scope, $location, API) {
    $scope.badges = [];

    $http({
        method: 'GET',
        url: $rootScope.baseURL + '/badges'
    }).then(function successCallback(response) {
        var badgeData = response.data;
        setImage(badgeData);
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });

    var setImage = function (badgeData) {
        var temp = badgeData;
        for (var i = 0; i < temp.length; i++) {
            var badge = temp[i];
            var name = badge['name'];
            var index = name.indexOf(" ");
            var image = name.substring(0, index);
            badge['image'] = image;
            temp[i] = badge;
        };
        $scope.badges = temp;
    };

});