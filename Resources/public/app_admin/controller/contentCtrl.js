/**
 * Created by killer on 6/11/15.
 */

admin.controller('contentCtrl', ['$scope', 'contentSvc', 'modals', 'utilSvc', 'portalSvc',
    function ($scope, contentSvc, modals, utilSvc, portalSvc) {

        $scope.dataTable = {
            columns: {
                id: {
                    name: 'Id',
                    type: 'integer'
                },
                'type': {
                    name: 'Type',
                    type: 'string'
                }
            }
        };

        $scope.selectedItems = {};

        $scope.print = function () {
            console.log($scope.selectedItems)
        };

        $scope.transformImage = function (image) {
            return portalSvc.getAssetUrl() + '/bundles/portal/img/' + image;
        };

        $scope.predicate = 'id';
        $scope.reverse = false;
        $scope.limit = '5';
        $scope.currentPage = 0;
        $scope.order = function (predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };

        $scope.previous = function () {
            if (!$scope.isFirst()) {
                $scope.currentPage--;
            }
        };

        $scope.first = function () {
            $scope.currentPage = 0;
        };

        $scope.next = function (cant_elementos) {
            if (!$scope.isLast(cant_elementos)) {
                $scope.currentPage++;
            }

        };

        $scope.last = function (cant_elementos) {
            $scope.currentPage = Math.floor(cant_elementos / $scope.limit);
        };

        $scope.isFirst = function () {
            return $scope.currentPage == 0;
        };

        $scope.isLast = function (cant_elementos) {
            var lastPage = Math.floor(cant_elementos / $scope.limit);
            return ($scope.currentPage == lastPage || cant_elementos == $scope.limit);
        };

        $scope.toInt = function (value) {
            return parseInt(value)
        };

        $scope.loadData = function () {
            contentSvc.getContents()
                .success(
                    function (data) {
                        $scope.myData = data;
                    });
        };

        $scope.deleteContent = function (id) {
            contentSvc.deleteContent(id)
                .success(
                    function (data) {
                        utilSvc.createNotify('', data, 'success');
                        $scope.loadData();
                        $scope.first();
                    })
                .error(function (data) {
                    utilSvc.createNotify('', data, 'alert');
                });
        };

        $scope.deleteSelected = function () {
            var selectedItems = $scope.selectedItems;
            for (var key in selectedItems) {
                if (selectedItems.hasOwnProperty(key) && selectedItems[key] == true) {
                    $scope.deleteContent(key);
                }
            }
            $scope.selectedItems = {};
        };

        $scope.loadData();

        $scope.isSelectedItems = function () {
            var selectedItems = $scope.selectedItems;
            for (var key in selectedItems) {
                if (selectedItems.hasOwnProperty(key) && selectedItems[key] == true) {
                    return true
                }
            }
            return false;
        };

        $scope.confirmSingleDeletion = function (id) {
            var promise = modals.open(
                "confirmSingle",
                {
                    message: "¿Estas seguro que deseas eliminar el elemento con id: " + id + "?"
                }
            );

            promise.then(
                function handleResolve(response) {

                    $scope.deleteContent(id);
                    console.log("Confirm resolved.");

                },
                function handleReject(error) {

                    console.warn("Confirm rejected!");

                }
            );
        };

        $scope.confirmMultipleDeletion = function () {
            var promise = modals.open(
                "confirmMultiple",
                {
                    message: "¿Estas seguro que deseas eliminar los elementos seleccionados?"
                }
            );

            promise.then(
                function handleResolve(response) {

                    $scope.deleteSelected();
                    console.log("Confirm resolved.");

                },
                function handleReject(error) {

                    console.warn("Confirm rejected!");

                }
            );
        };

    }]);

admin.controller('contentShowCtrl', ['$scope', 'portalSvc', 'contentSvc', '$state', 'utilSvc',
    function ($scope, portalSvc, contentSvc, $state, utilSvc) {

        $scope.url = portalSvc.getAssetUrl();

        contentSvc.getContent($state.params.id)
            .success(
                function (data) {
                    $scope.content = data;
                    console.log(data);
                })
            .error(
                function (data) {
                    utilSvc.createNotify('', data, 'alert');
                }
            );


    }]);

admin.controller('contentNewCtrl', ['$scope', function ($scope) {

    $scope.tabcontrol = "icon";

}]);

admin.controller('contentUpdateCtrl', ['$scope', function ($scope) {

}]);