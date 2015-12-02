/**
 * Created by killer on 13/11/15.
 */


portal.filter('filterTilesBy', function () {
    return function (tile_array, filter) {
        var array_result = [];

        angular.forEach(tile_array, function (tile, key) {
            if (tile.funcionalidad.nombre.toLowerCase().indexOf(filter.toLowerCase()) != -1) {
                array_result.push(tile);
            }
        });

        return array_result;
    };
});