/**
 * Created by killer on 2/11/15.
 */

portal.directive('focusMe', ['$timeout', '$parse', function ($timeout, $parse) {
    return {
        link: function (scope, element, attrs) {
            var model = $parse(attrs.focusOnMe);
            scope.$watch(model, function (value) {
                console.log('value=', value);
                if (value === true) {
                    $timeout(function () {
                        element[0].focus();
                    });
                }
            });
        }
    }
}]);