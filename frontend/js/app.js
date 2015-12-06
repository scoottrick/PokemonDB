var app = angular.module('app', ['ngRoute']);

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            controller: 'MainPageController',
            templateUrl: '/PokemonDB/frontend/html/main.html',
            css: '/PokemonDB/frontend/styles/views/mainPage.css'
        })
        .when('/pokedex', {
            controller: 'PokedexController',
            templateUrl: '/PokemonDB/frontend/html/pokedex.html',
            css: '/PokemonDB/frontend/styles/views/pokedex.css'
        })
        .when('/pokedex/:id', {
            controller: 'PokemonController',
            templateUrl: '/PokemonDB/frontend/html/singleItemViews/pokemon.html',
            css: '/PokemonDB/frontend/styles/views/pokemon/pokemon.css'
        })
        .when('/trainers', {
            controller: 'TrainersController',
            templateUrl: '/PokemonDB/frontend/html/trainers.html',
            css: '/PokemonDB/frontend/styles/views/trainers.css'
        })
        .when('/trainer/:name', {
            controller: 'TrainerController',
            templateUrl: '/PokemonDB/frontend/html/singleItemViews/trainer.html',
            css: '/PokemonDB/frontend/styles/views/trainer/trainer.css'
        })
        .when('/gyms', {
            controller: 'GymsController',
            templateUrl: '/PokemonDB/frontend/html/gyms.html',
            css: '/PokemonDB/frontend/styles/views/gyms.css'
        })
        .when('/gym/:name', {
            controller: 'GymController',
            templateUrl: '/PokemonDB/frontend/html/singleItemViews/gym.html',
            css: '/PokemonDB/frontend/styles/views/gym/gym.css'
        })
        .when('/badges', {
            controller: 'BadgesController',
            templateUrl: '/PokemonDB/frontend/html/badges.html',
            css: '/PokemonDB/frontend/styles/views/badges.css'
        })
        .when('/search/:text', {
            controller: 'SearchResultsController',
            templateUrl: '/PokemonDB/frontend/html/searchResults.html',
            css: '/PokemonDB/frontend/styles/views/searchResults.css'
        })
        .otherwise({
            redirectTo: '/'
        });
});

app.run(function($rootScope){
    $rootScope.baseURL = "http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend";
});

app.controller("NavController", ["$http", "$scope", "$location", "$rootScope", NavController]);
app.controller("SearchController", ["$http", "$scope", "$location", "$rootScope", SearchController]);
app.controller("MainPageController", ["$http", "$scope", "$location", "$rootScope", MainPageController]);
app.controller("PokedexController", ["$http", "$scope", "$location", "$rootScope", PokedexController]);
app.controller("TrainersController", ["$http", "$scope", "$location", "$rootScope", TrainersController]);
app.controller("BadgesController", ["$http", "$scope", "$location", "$rootScope", BadgesController]);
app.controller("GymsController", ["$http", "$scope", "$location", "$rootScope", GymsController]);
app.controller("SearchResultsController", ["$http", "$scope", "$location", "$route", "$rootScope", SearchResultsController]);
app.controller("TrainerController", ["$http", "$scope", "$location", "$route", "$rootScope", TrainerController]);
app.controller("GymController", ["$http", "$scope", "$location", "$route", "$rootScope", GymController]);
app.controller("PokemonController", ["$http", "$scope", "$location", "$route", "$rootScope", PokemonController]);