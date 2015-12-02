/**
 * Created by killer on 13/11/15.
 */

portal.directive("bnLineItem", function () {
        // I bind the UI events to the scope.
        function link($scope, element, attributes) {
            console.log("Linked:", $scope.tile.funcionalidad.nombre);
        }

        // Return the directive configuration.
        return ({
            link: link,
            restrict: "A"
        });
    }
);