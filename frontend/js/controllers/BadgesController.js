app.controller("BadgesController", function ($http, $scope, $location, API) {
    $scope.badges = [];

    API.getAllBadges()
        .then(function successCallback(response) {
            var badgeData = response.data;
            $scope.badges = API.setBadgeImages(badgeData);
        }, function errorCallback(response) {
            API.errorResponse(response);
        });

});