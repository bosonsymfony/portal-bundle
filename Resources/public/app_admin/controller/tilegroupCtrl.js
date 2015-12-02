/**
 * Created by killer on 6/11/15.
 */

admin
    .controller('tilegroupCtrl', ['$scope', 'tilegroupSvc', 'modals', 'utilSvc', function ($scope, tilegroupSvc, modals, utilSvc) {

        $scope.dataTable = {
            columns: {
                id: {
                    name: 'Id',
                    type: 'integer'
                },
                title: {
                    name: 'Title',
                    type: 'string'
                },
                size: {
                    name: 'Size',
                    type: 'integer'
                }
            }
        };

        $scope.selectedItems = {};

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
            tilegroupSvc.getTileGroups()
                .success(
                    function (data) {
                        $scope.myData = data;
                    });
        };


        $scope.deleteTileGroup = function (id) {
            tilegroupSvc.deleteTileGroup(id)
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
                    $scope.deleteTileGroup(key);
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

                    $scope.deleteTileGroup(id);
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
admin
    .controller('tilegroupNewCtrl', ['$scope', '$state', 'tilegroupSvc', 'utilSvc',
        function ($scope, $state, tilegroupSvc, utilSvc) {

            $scope.data = {
                'futbol_PortalBundle_tilegroup[title]': "",
                'futbol_PortalBundle_tilegroup[size]': 0
            };

            $scope.submit = function () {

                tilegroupSvc.createTileGroup($scope.data)
                    .success(
                        function (data) {
                            utilSvc.createNotify('', data, 'success');
                            $state.go('main.tilegroup');
                        })
                    .error(
                        function (data) {
                            utilSvc.createNotify('', data, 'alert');
                        })
            }
        }]);
admin
    .controller('tilegroupShowCtrl', ['$scope', '$state', 'tilegroupSvc', 'utilSvc',
        function ($scope, $state, tilegroupSvc, utilSvc) {

            tilegroupSvc.getTileGroup($state.params.id)
                .success(
                    function (data) {
                        $scope.tilegroup = data;
                    })
                .error(
                    function () {
                        utilSvc.createNotify('', data, 'alert');
                    });
        }]);
admin
    .controller('tilegroupUpdateCtrl', ['$scope', '$state', 'tilegroupSvc', 'utilSvc',
        function ($scope, $state, tilegroupSvc, utilSvc) {

            tilegroupSvc.getTileGroup($state.params.id)
                .success(
                    function (data) {
                        $scope.tilegroup = data;
                        $scope.data = {
                            'futbol_PortalBundle_tilegroup[title]': data.title,
                            'futbol_PortalBundle_tilegroup[size]': data.size
                        };

                    })
                .error(function () {
                    utilSvc.createNotify('', data, 'alert');
                });

            $scope.submit = function () {

                tilegroupSvc.updateTileGroup($scope.tilegroup.id, $scope.data)
                    .success(
                        function (data) {
                            utilSvc.createNotify('', data, 'success');
                            $state.go('main.tilegroup');
                        })
                    .error(
                        function (data) {
                            console.log('here');
                            utilSvc.createNotify('', data, 'alert');
                        })
            };

        }]);