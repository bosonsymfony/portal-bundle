/**
 * Created by killer on 13/11/15.
 */
portal.controller('tileCtrl', ['$scope', function ($scope) {

    $scope.isExcludedByFilter = applySearchFilter();

    $scope.$watch("search", function (newName, oldName) {
        if (newName === oldName) {
            return;
        }
        applySearchFilter();
    });

    function applySearchFilter() {
        var filter = $scope.search.toLowerCase();
        var name = $scope.tile.funcionalidad.nombre.toLowerCase();
        var isSubstring = ( name.indexOf(filter) !== -1 );
        $scope.isExcludedByFilter = !isSubstring;
    }
}
]);