/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

admin.provider('tileSvc', [function () {

    return {
        $get: function ($http) {

            var getTiles = function () {
                return $http.get(Routing.generate('tile', {}, true));
            };

            var getTile = function (id) {
                return $http.get(Routing.generate('tile_show', {'id': id}, true))
            };

            var createTile = function (data) {
                return $http.post(Routing.generate('tile_create', {}, true), data);
            };

            var updateTile = function (id, data) {
                data._method = 'PUT';
                return $http.post(Routing.generate('tile_update', {'id': id}, true) + '?XDEBUG_SESSION_START', data);
            };

            var deleteTile = function (id) {
                return $http.delete(Routing.generate('tile_delete', {'id': id}, true));
            };

            return {
                getTiles: getTiles,
                createTile: createTile,
                deleteTile: deleteTile,
                getTile: getTile,
                updateTile: updateTile
            }
        }
    }
}]);

