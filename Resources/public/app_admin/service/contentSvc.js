/**
 * Created by killer on 11/11/15.
 */

admin.provider('contentSvc', [function () {

    return {
        $get: function ($http) {

            var getContents = function () {
                return $http.get(Routing.generate('content', {}, true))
            };

            return {
                getContents: getContents
            }
        }
    }
}]);