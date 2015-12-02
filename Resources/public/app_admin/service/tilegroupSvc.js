/**
 * Created by killer on 11/11/15.
 */

admin.provider('tilegroupSvc', [function () {

    return {
        $get: function ($http) {

            var getTileGroups = function () {
                return $http.get(Routing.generate('tilegroup', {}, true))
            };

            var getTileGroup = function (id) {
                return $http.get(Routing.generate('tilegroup_show', {'id': id}, true))
            };

            var createTileGroup = function (data) {
                return $http.post(Routing.generate('tilegroup_create', {}, true), data);
            };

            var updateTileGroup = function (id, data) {
                data._method = 'PUT';
                return $http.post(Routing.generate('tilegroup_update', {'id': id}, true), data);
            };

            var deleteTileGroup = function (id) {
                return $http.delete(Routing.generate('tilegroup_delete', {'id': id}, true));
            };

            return {
                getTileGroups: getTileGroups,
                getTileGroup: getTileGroup,
                createTileGroup: createTileGroup,
                updateTileGroup: updateTileGroup,
                deleteTileGroup: deleteTileGroup
            }
        }
    }
}]);
