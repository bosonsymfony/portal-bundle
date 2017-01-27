/**
 * Created by killer on 24/11/15.
 */

admin.controller("PromptModalCtrl", ['$scope', 'modals', function ($scope, modals) {

    // Setup defaults using the modal params.
    $scope.message = ( modals.params().message || "Give me." );

    // Setup the form inputs (using modal params).
    $scope.form = {
        input: ( modals.params().placeholder || "" )
    };

    $scope.errorMessage = null;


    // ---
    // PUBLIC METHODS.
    // ---


    // Wire the modal buttons into modal resolution actions.
    $scope.cancel = modals.reject;


    // I process the form submission.
    $scope.submit = function () {

        // If no input was provided, show the user an error message.
        if (!$scope.form.input) {

            return ( $scope.errorMessage = "Please provide something!" );

        }

        modals.resolve($scope.form.input);

    };

}]);