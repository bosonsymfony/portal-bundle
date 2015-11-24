/**
 * Created by killer on 11/11/15.
 */

admin.provider('tilegroupSvc', [function () {

    return {
        $get: function ($http) {

            var getTileGroups = function () {
                return $http.get(Routing.generate('tilegroup', {}, true))
            };

            return {
                getTileGroups: getTileGroups
            }
        }
    }
}]);
