/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

admin.
    run(['$rootScope', '$state', '$stateParams', function ($rootScope, $state, $stateParams) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams
    }])
    .config(['$httpProvider', '$urlRouterProvider', '$stateProvider', 'portalSvcProvider', function ($httpProvider, $urlRouterProvider, $stateProvider, portalSvcProvider) {
        var path = portalSvcProvider.$get().getAngularRoute();

        $urlRouterProvider
            .otherwise('/tile');

        $stateProvider
            .state('main', {
                url: '',
                templateUrl: path + "/app_admin/index.html"

            })
            /* Tiles routes */
            .state('main.tile', {
                url: '/tile',
                templateUrl: path + "/app_admin/view/tile/tile.html",
                controller: "tileCtrl"
            })
            .state('main.tile_new', {
                url: '/tile/new',
                templateUrl: path + "/app_admin/view/tile/tile.new.html",
                controller: "tileNewCtrl"
            })
            .state('main.tile_show', {
                url: '/tile/show/:id',
                templateUrl: path + "/app_admin/view/tile/tile.show.html",
                controller: "tileShowCtrl"
            })
            .state('main.tile_update', {
                url: '/tile/update/:id',
                templateUrl: path + "/app_admin/view/tile/tile.update.html",
                controller: "tileUpdateCtrl"
            })
            /* Content routes */
            .state('main.content', {
                url: '/content',
                templateUrl: path + "/app_admin/view/content/content.html"
            })
            /* Tilegroup routes */
            .state('main.tilegroup', {
                url: '/tilegroup',
                templateUrl: path + "/app_admin/view/tilegroup/tilegroup.html"
            });

        var param = function (obj) {
            var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

            for (name in obj) {
                value = obj[name];

                if (value instanceof Array) {
                    for (i = 0; i < value.length; ++i) {
                        subValue = value[i];
                        fullSubName = name + '[' + i + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                }
                else if (value instanceof Object) {
                    for (subName in value) {
                        subValue = value[subName];
                        fullSubName = name + '[' + subName + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                }
                else if (value !== undefined && value !== null)
                    query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
            }

            return query.length ? query.substr(0, query.length - 1) : query;
        };

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

        $httpProvider.defaults.transformRequest = [function (data) {
            return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
        }];
    }]);


