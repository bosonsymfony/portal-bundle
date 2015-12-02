/**
 * Created by killer on 11/11/15.
 */

admin.provider('contentSvc', [function () {

    return {
        $get: function ($http) {

            var getContents = function () {
                return $http.get(Routing.generate('content', {}, true))
            };

            var getContent = function (id) {
                return $http.get(Routing.generate('content_show', {'id': id}, true))
            };

            var createContent = function (data) {
                return $http.post(Routing.generate('content_create', {}, true), data);
            };

            var updateContent = function (id, data) {
                data._method = 'PUT';
                return $http.post(Routing.generate('content_update', {'id': id}, true), data);
            };

            var deleteContent = function (id) {
                return $http.delete(Routing.generate('content_delete', {'id': id}, true)+ '?XDEBUG_SESSION_START=default');
            };

            return {
                getContents: getContents,
                getContent: getContent,
                createContent: createContent,
                updateContent: updateContent,
                deleteContent: deleteContent
            }
        }
    }
}]);