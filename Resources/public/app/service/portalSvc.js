/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

portal.provider('portalSvc', function () {

    return {
        $get: function ($http) {

            var arrayRute = document.location.pathname.split('/');
            var origin = document.location.origin;

            var getUrlServer = function () {
                var array = Routing.b;
                var scheme = array.scheme;
                var host = array.host;
                var base_url = array.e;
                return scheme + "://" + host + base_url;
            };

            var getAngularRoute = function () {
                return getAssetUrl() + '/bundles/portal';
            };

            var getUser = function () {
                var url = Routing.generate('portal_authenticated_user', {}, true);
                return $http.get(url);
            };

            var getUrlLogout = function () {
                return Routing.generate('portal_logout', {}, true);
            };

            var getUrlLogin = function () {
                return Routing.generate('portal_login', {}, true);
            };

            var getUrlAdmin = function () {
                return Routing.generate('portal_admin', {}, true);
            };

            var getAssetUrl = function () {
                var containPHP = false;
                var result = '';

                for (var i = 1; i < arrayRute.length; i++) {
                    if (arrayRute[i].indexOf('.php') > -1) {
                        containPHP = true;
                        break;
                    } else {
                        result += '/' + arrayRute[i];

                    }
                }

                if (containPHP) {
                    return origin + result;
                } else {
                    return origin;
                }

            };

            var getAllTiles = function () {
                var url = Routing.generate('portal_all_tiles', {}, true);
                return $http.get(url);
            };

            var getBackground = function () {
                var url = Routing.generate('portal_background', {}, true);
                return $http.get(url);
            };

            var getIUXParams = function () {
                var url = Routing.generate('portal_product_name', {}, true);
                return $http.get(url);
            };

            return {
                getUrlServer: getUrlServer,
                getAngularRoute: getAngularRoute,
                getUser: getUser,
                getAssetUrl: getAssetUrl,
                getAllTiles: getAllTiles,
                getUrlLogout: getUrlLogout,
                getUrlLogin: getUrlLogin,
                getBackground: getBackground,
                getIUXParams: getIUXParams,
                getUrlAdmin: getUrlAdmin

            }
        }
    }
});

