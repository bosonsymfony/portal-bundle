/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


portal.controller('portalCtrl', ['$scope', '$timeout', 'portalSvc', function ($scope, $timeout, portalSvc) {

    $scope.loaded = {
        user: true,
        tilegs: true,
        logo: true
    };

    $scope.showCharmSearch = false;

    $scope.search = "";

    $scope.url = portalSvc.getAssetUrl();

    $scope.urlServer = portalSvc.getUrlServer();

    $scope.iux_params = [];

    $scope.logo = "";

    $scope.user = null;

    $scope.login = portalSvc.getUrlLogin();

    $scope.logout = portalSvc.getUrlLogout();

    $scope.admin = portalSvc.getUrlAdmin();

    $scope.arrayWindow = [];

    $scope.topshow = false;

    $scope.leftshow = false;

    $scope.actualfunc = {
        id: -1,
        icon: 'icon-home',
        title: 'Ventana a cerrar'
    };

    $scope.showing = false;

    var path = $scope.url + "/bundles/portal/";

    portalSvc.getIUXParams().success(function (data) {
        $scope.iux_params = data;
        $scope.logo = $scope.url + "/bundles/portal/images/iux/" + data.linea + "/" + data.linea + ".png";
        $scope.loaded.logo = false;
    });

    portalSvc.getUser().success(function (data) {
        $scope.user = data;
        $scope.loaded.user = false;
    });

    portalSvc.getAllTiles().success(function (data) {
        $scope.tilegs = data;

        var tileAreaWidth = 160;

        for (var i = 0; i < $scope.tilegs.length; i++) {
            tileAreaWidth += $scope.tilegs[i].size + 46;
        }
        $(".tile-area").css({
            width: tileAreaWidth
        });
        $("body").mousewheel(function (event, delta) {
            var scroll_value = delta * 50;
            $(document).scrollLeft($(document).scrollLeft() - scroll_value);
            return false;
        });

        $(function () {
            $.getScript(path + 'js/metro.min.js');
            //$.getScript(path + 'lib/jquery/jquery.min.js');
        });

        $scope.loaded.tilegs = false;
    });

    $scope.createWindow = function (tile) {
        $scope.actualfunc.id = tile.id;
        $scope.actualfunc.title = tile.funcionalidad.nombre;
        $scope.actualfunc.icon = tile.contents[0];

        if (!containsWindows(tile.id)) {

            $scope.arrayWindow.push({
                id: tile.id,
                background: tile.backgroung,
                icon: tile.contents[0],
                visible: false,
                url: $scope.urlServer + tile.funcionalidad.accion.ruta,
                nombre_func: tile.funcionalidad.nombre
            })
        }

        $scope.activeWindow(tile.id);
        $scope.showing = true;
    };

    $scope.activeWindow = function (id) {
        for (var i = 0; i < $scope.arrayWindow.length; i++) {
            if ($scope.arrayWindow[i].id == id) {
                $scope.arrayWindow[i].visible = true;
                $scope.actualfunc.id = id;
                $scope.actualfunc.title = $scope.arrayWindow[i].nombre_func;
                $scope.actualfunc.icon = $scope.arrayWindow[i];
                $scope.showing = true;
            } else {
                $scope.arrayWindow[i].visible = false
            }
        }
    };

    $scope.closeWindow = function (id) {
        for (var i = 0; i < $scope.arrayWindow.length; i++) {
            if ($scope.arrayWindow[i].id == id) {
                $scope.arrayWindow[i].visible = false;
                $scope.arrayWindow.splice(i, 1);
                $scope.showing = false;
            }
        }
    };

    $scope.minWindow = function (id) {
        for (var i = 0; i < $scope.arrayWindow.length; i++) {
            if ($scope.arrayWindow[i].id == id) {
                $scope.arrayWindow[i].visible = false;
                $scope.showing = false;
            }
        }
    };

    var containsWindows = function (id) {
        for (var i = 0; i < $scope.arrayWindow.length; i++) {
            if ($scope.arrayWindow[i].id == id) {
                return true;
            }
        }
        return false;
    };

    $scope.changeTopShow = function () {
        if ($scope.showing == true) {
            $scope.topshow = true;
        }
    };

    $scope.onInputBlur = function () {
        $scope.showCharmSearch = false;
        $timeout(function () {
            $scope.search = '';
        }, 500);

    };

    $timeout(function () {
        $scope.loading = false;
    }, 1000);


}]);

