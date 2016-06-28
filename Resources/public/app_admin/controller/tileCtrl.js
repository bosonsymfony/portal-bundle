/**
 * Created by killer on 6/11/15.
 */

admin
    .controller('tileCtrl', ['$scope', 'tileSvc', 'utilSvc', 'modals', function ($scope, tileSvc, utilSvc, modals) {

        $scope.dataTable = {
            columns: {
                id: {
                    name: 'Id',
                    type: 'integer'
                },
                'funcionalidad.nombre': {
                    name: 'Funcionalidad',
                    type: 'string'
                },
                selected: {
                    name: 'Seleccionado',
                    type: 'boolean'
                },
                backgroung: {
                    name: 'Fondo',
                    type: 'string'
                },
                'tileGroup.title': {
                    name: 'Grupo',
                    type: 'string'
                },
                size: {
                    name: 'Tamaño',
                    type: 'string'
                }
            }
        };

        $scope.selectedItems = {};

        $scope.print = function () {
            console.log($scope.selectedItems)
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
            tileSvc.getTiles()
                .success(
                function (data) {
                    $scope.myData = data;
                });
        };

        $scope.deleteTile = function (id) {
            tileSvc.deleteTile(id)
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
                    $scope.deleteTile(key);
                }
            }
            $scope.selectedItems = {};
        };

        $scope.loadData();


        $scope.changeProperty = function (tile) {
            utilSvc.changeProperty('PortalBundle:Tile', tile.id, 'selected', 'bool', tile.selected)
                .success(
                function (data) {
                    utilSvc.createNotify('', data, 'success');
                })
                .error(function (data) {
                    utilSvc.createNotify('', data, 'alert');

                })
        };

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

                    $scope.deleteTile(id);

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

                },
                function handleReject(error) {

                    console.warn("Confirm rejected!");

                }
            );
        };

    }]);
admin
    .controller('tileNewCtrl', ['$scope', '$state', 'tileSvc', 'tilegroupSvc', 'contentSvc', 'portalSvc', 'utilSvc',
        function ($scope, $state, tileSvc, tilegroupSvc, contentSvc, portalSvc, utilSvc) {

            $scope.data = {
                'futbol_PortalBundle_tile[dataEffect]': "",
                'futbol_PortalBundle_tile[tileGroup]': "",
                'futbol_PortalBundle_tile[funcionalidad]': "",
                'futbol_PortalBundle_tile[backgroung]': "",
                'futbol_PortalBundle_tile[size]': "",
                'futbol_PortalBundle_tile[selected]': null,
                'futbol_PortalBundle_tile[contents][]': []
            };

            utilSvc.getStyles()
                .success(
                function (data) {
                    $scope.styles = data;
                })
                .error(
                function (data) {

                }
            );

            utilSvc.getFunctions()
                .success(
                function (data) {
                    $scope.functions = data;
                })
                .error(
                function (data) {

                }
            );

            tilegroupSvc.getTileGroups()
                .success(
                function (data) {
                    $scope.tilegs = data;
                })
                .error(
                function (data) {

                }
            );

            contentSvc.getContents()
                .success(
                function (data) {
                    $scope.contents = data;
                })
                .error(
                function (data) {

                }
            );

            $scope.toStringContent = function (content) {
                switch (content.type) {
                    case 'icon':
                        return 'icon ' + content.icon;
                    case 'image':
                        return 'image' + ((content.tipo == 'icon') ? '-icon ' : ' ') + content.path;
                    case 'image-set':
                        return 'image-set ' + content.id
                }
            };

            $scope.submit = function () {

                var selected = $scope.data['futbol_PortalBundle_tile[selected]'];
                $scope.data['futbol_PortalBundle_tile[selected]'] = (selected == true) ? true : null;

                tileSvc.createTile($scope.data)
                    .success(
                    function (data) {
                        utilSvc.createNotify('', data, 'success');
                        $state.go('main.tile_');
                    })
                    .error(
                    function (data) {
                        utilSvc.createNotify('', data, 'alert');
                    })
            };

            utilSvc.initSelects();
        }]);
admin
    .controller('tileShowCtrl', ['$scope', '$state', '$timeout', 'tileSvc', 'utilSvc', 'portalSvc',
        function ($scope, $state, $timeout, tileSvc, utilSvc, portalSvc) {

            $scope.url = portalSvc.getAssetUrl();

            $scope.init = function (effect) {
                if (effect != null) {
                    $("#tile").tile({
                        effect: effect
                    })
                } else {
                    $("#tile").tile();
                }

            };

            tileSvc.getTile($state.params.id)
                .success(
                function (data) {
                    $scope.tile = data;
                    $timeout(function () {
                        $scope.init(data.dataEffect);
                    }, 10);
                })
                .error(
                function (data) {
                    utilSvc.createNotify('', data, 'alert');
                });
        }]);
admin
    .controller('tileUpdateCtrl', ['$scope', '$state', '$timeout', 'tileSvc', 'tilegroupSvc', 'contentSvc', 'portalSvc', 'utilSvc',
        function ($scope, $state, $timeout, tileSvc, tilegroupSvc, contentSvc, portalSvc, utilSvc) {

            utilSvc.initSelects();

            $scope.init = function () {
                utilSvc.getStyles()
                    .success(
                    function (data) {
                        $scope.styles = data;
                        $timeout(function () {
                            $("#backgroung").select2({
                                placeholder: "Seleccione el color",
                                templateResult: utilSvc.formatStateColor,
                                templateSelection: utilSvc.formatStateColor
                            });
                            $("#size").select2({
                                placeholder: "Seleccione el tamaño"
                            });
                            $("#dataEffect").select2({
                                placeholder: "Seleccione el efecto"
                            });
                        }, 10);
                    })
                    .error(
                    function (data) {
                        utilSvc.createNotify('', data, 'alert');
                    }
                );

                utilSvc.getFunctions()
                    .success(
                    function (data) {
                        $scope.functions = data;
                        $timeout(function () {
                            $("#funcionalidad").select2({
                                placeholder: "Seleccione la funcionalidad",
                                allowClear: true
                            });
                        }, 10);
                    })
                    .error(
                    function (data) {
                        utilSvc.createNotify('', data, 'alert');
                    }
                );

                tilegroupSvc.getTileGroups()
                    .success(
                    function (data) {
                        $scope.tilegs = data;
                        $timeout(function () {
                            $("#tileGroup").select2({
                                placeholder: "Seleccione el tile group",
                                allowClear: true
                            });
                        }, 10);
                    })
                    .error(
                    function (data) {
                        utilSvc.createNotify('', data, 'alert');
                    }
                );

                contentSvc.getContents()
                    .success(
                    function (data) {
                        $scope.contents = data;
                        $timeout(function () {
                            $("#contents").select2({
                                placeholder: "Seleccione los contenidos",
                                allowClear: true,
                                templateResult: utilSvc.formatStateContent,
                                templateSelection: utilSvc.formatStateContent
                            });
                        }, 10);
                    })
                    .error(
                    function (data) {
                        utilSvc.createNotify('', data, 'alert');
                    }
                );
            };

            tileSvc.getTile($state.params.id)
                .success(
                function (data) {
                    $scope.tile = data;
                    $scope.data = {
                        'futbol_PortalBundle_tile[dataEffect]': data.dataEffect,
                        'futbol_PortalBundle_tile[tileGroup]': (data.tileGroup != null) ? data.tileGroup.id + '' : '',
                        'futbol_PortalBundle_tile[funcionalidad]': (data.funcionalidad != null) ? data.funcionalidad.id + '' : '',
                        'futbol_PortalBundle_tile[backgroung]': data.backgroung,
                        'futbol_PortalBundle_tile[size]': data.size,
                        'futbol_PortalBundle_tile[selected]': data.selected,
                        'futbol_PortalBundle_tile[contents]': $scope.transformData(data.contents)
                    };
                    $scope.init();

                })
                .error(function () {
                    utilSvc.createNotify('', data, 'alert');
                });

            $scope.transformData = function (contents) {
                var result = [];
                contents.forEach(function (entry) {
                    result.push(entry.id + "");
                });
                return result;
            };


            $scope.toStringContent = function (content) {
                switch (content.type) {
                    case 'icon':
                        return 'icon ' + content.icon;
                    case 'image':
                        return 'image' + ((content.tipo == 'icon') ? '-icon ' : ' ') + content.path;
                    case 'image-set':
                        return 'image-set ' + content.id
                }
            };

            $scope.submit = function () {

                var selected = $scope.data['futbol_PortalBundle_tile[selected]'];
                $scope.data['futbol_PortalBundle_tile[selected]'] = (selected == true) ? true : null;

                tileSvc.updateTile($scope.tile.id, $scope.data)
                    .success(
                    function (data) {
                        utilSvc.createNotify('', data, 'success');
                        $state.go('main.tile_');
                    })
                    .error(
                    function (data) {
                        utilSvc.createNotify('', data, 'alert');
                    })
            };
        }]);
