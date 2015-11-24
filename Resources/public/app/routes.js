/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

portal.
    run(['$rootScope', '$state', '$stateParams', function ($rootScope, $state, $stateParams) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams
    }])
    .config(['$urlRouterProvider', '$stateProvider', 'portalSvcProvider', function ($urlRouterProvider, $stateProvider, portalSvcProvider) {
        var path = portalSvcProvider.$get().getAngularRoute();

        $urlRouterProvider
            .otherwise('/');

        $stateProvider
            .state('main', {
                url: '/',
                templateUrl: path + "/app/index.html",
                controller: "portalCtrl"

            });
    }]);


