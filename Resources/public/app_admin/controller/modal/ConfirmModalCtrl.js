/**
 * Created by killer on 24/11/15.
 */

admin.controller("ConfirmModalCtrl", ['$scope', 'modals', function ($scope, modals) {

    var params = modals.params();

    // Setup defaults using the modal params.
    $scope.message = ( params.message || "Are you sure?" );
    $scope.confirmButton = ( params.confirmButton || "Yes!" );
    $scope.denyButton = ( params.denyButton || "Oh, hell no!" );


    // ---
    // PUBLIC METHODS.
    // ---


    // Wire the modal buttons into modal resolution actions.
    $scope.confirm = modals.resolve;
    $scope.deny = modals.reject;

}]);