var app = angular.module('app', ['ngRoute']);

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            controller: 'MainPageController',
            templateUrl: '/frontend/html/main.html',
            css: '/frontend/styles/views/mainPage.css'
        })
        .when('/pokedex', {
            controller: 'PokedexController',
            templateUrl: '/frontend/html/pokedex.html',
            css: '/frontend/styles/views/pokedex.css'
        })
        .when('/trainers', {
            controller: 'TrainersController',
            templateUrl: '/frontend/html/trainers.html',
            css: '/frontend/styles/views/categorySelection.css'
        })
        .when('/search', {
            controller: 'SearchResultsController',
            templateUrl: '/frontend/html/searchResults.html',
            css: '/frontend/styles/views/searchResults.css'
        })
        .otherwise({
            redirectTo: '/'
        });
});

app.controller("MainPageController", ["$http", "$scope", "$location", MainPageController]);
app.controller("PokedexController", ["$http", "$scope", "$location", PokedexController]);
app.controller("TrainersController", ["$http", "$scope", "$location", TrainersController]);
app.controller("SearchResultsController", ["$http", "$scope", "$location", SearchResultsController]);