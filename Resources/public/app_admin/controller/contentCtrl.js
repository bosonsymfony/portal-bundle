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
                    name: 'Tipo',
                    type: 'string'
                }
            }
        };

        $scope.selectedItems = {};

        $scope.print = function () {
            console.log($scope.selectedItems)
        };

        $scope.transformImage = function (image) {
            return portalSvc.getAssetUrl() + '/images/' + image;
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
                    message: "¿Estás seguro que deseas eliminar el elemento con id: " + id + "?"
                }
            );

            promise.then(
                function handleResolve(response) {

                    $scope.deleteContent(id);

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
                    message: "¿Estás seguro que deseas eliminar los elementos seleccionados?"
                }
            );

            promise.then(
                function handleResolve(response) {

                    $scope.deleteSelected();

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
                })
            .error(
                function (data) {
                    utilSvc.createNotify('', data, 'alert');
                }
            );


    }]);

admin.controller('contentNewCtrl', ['$scope', 'Upload', '$timeout', 'utilSvc', '$state', 'contentSvc',
    function ($scope, Upload, $timeout, utilSvc, $state, contentSvc) {

        $scope.tabcontrol = "icon";
        $scope.url = Routing.generate('content_create', {}, true);

        $scope.data = {
            'futbol_PortalBundle_image[tipo]': 'icon'
        };

        $scope.dataIcon = {
            'futbol_PortalBundle_icon[icon]': ''
        };

        $scope.submitIcon = function () {
            $scope.dataIcon.type = $scope.tabcontrol;
            contentSvc.createContent($scope.dataIcon)
                .success(
                    function (data) {
                        utilSvc.createNotify('', data, 'success');
                        $state.go('main.content');
                    }
                )
                .error(
                    function (data) {
                        utilSvc.createNotify('', data, 'alert');
                    }
                )
        };

        $scope.submitImage = function (file) {
            file.upload = Upload.upload({
                url: $scope.url,
                data: {
                    'futbol_PortalBundle_image[file]': file,
                    'futbol_PortalBundle_image[tipo]': $scope.data['futbol_PortalBundle_image[tipo]'],
                    'type': $scope.tabcontrol
                }
            });

            file.upload.then(
                function (response) {
                    utilSvc.createNotify('', response.data, 'success');
                    $state.go('main.content');
                },
                function (response) {
                    utilSvc.createNotify('', response.data, 'alert');
                    //}
                }
            );
        };

        $scope.submitImageSet = function (dataImageSet) {
            console.log(dataImageSet);
            dataImageSet.type = $scope.tabcontrol;
            dataImageSet.upload = Upload.upload({
                url: $scope.url + '?XDEBUG_SESSION_START=default',
                data: dataImageSet
            });

            dataImageSet.upload.then(
                function (response) {
                    utilSvc.createNotify('', response.data, 'success');
                    $state.go('main.content');                },
                function (response) {
                    utilSvc.createNotify('', response.data, 'alert');
                }
            )
        };

        utilSvc.getIcons()
            .success(
                function (data) {
                    $scope.styles = data;
                })
            .error(
                function (data) {

                }
            );


    }]);

admin.controller('contentUpdateCtrl', ['$scope', function ($scope) {

}]);