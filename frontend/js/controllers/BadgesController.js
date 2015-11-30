function BadgesController($http, $scope, $location) {
    $scope.badges = [];

    $http({
        method: 'GET',
        url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/trainers'
    }).then(function successCallback(response) {
        var badgeData = response.data;
        console.log(badgeData);
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
        console.log(temp);
        $scope.badges = temp;
    };

};