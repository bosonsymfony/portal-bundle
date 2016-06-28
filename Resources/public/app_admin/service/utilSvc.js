/**
 * Created by rosi on 21/11/15.
 */

admin.provider('utilSvc', [function () {

    return {
        $get: function ($http, portalSvc) {

            var getStyles = function () {
                return $http.get(Routing.generate('tile_styles', {}, true))
            };

            var getIcons = function () {
                return $http.get(Routing.generate('content_icons', {}, true))
            };

            var getFunctions = function () {
                return $http.get(Routing.generate('tile_functions', {}, true))
            };

            var changeProperty = function (entity, entity_id, property, type, value) {
                return $http.post(Routing.generate('portal_change_property', {}, true) + '?XDEBUG_SESSION_START', {
                    'entity': entity,
                    'entity_id': entity_id,
                    'property': property,
                    'type': type,
                    'value': value
                })
            };

            var initSelects = function () {
                $("#backgroung").select2({
                    placeholder: "Seleccione el color",
                    templateResult: formatStateColor,
                    templateSelection: formatStateColor
                });
                $("#size").select2({
                    placeholder: "Seleccione el tamaño"
                });
                $("#dataEffect").select2({
                    placeholder: "Seleccione el efecto"
                });
                $("#tileGroup").select2({
                    placeholder: "Seleccione el tile group",
                    allowClear: true
                });
                $("#funcionalidad").select2({
                    placeholder: "Seleccione la funcionalidad",
                    allowClear: true
                });
                $("#contents").select2({
                    placeholder: "Seleccione los contenidos",
                    allowClear: true,
                    templateResult: formatStateContent,
                    templateSelection: formatStateContent
                });
            };

            var formatStateColor = function (state) {
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<span class="border-solid bg-' + state.element.value + '">&nbsp&nbsp&nbsp&nbsp</span>' +
                    '<span> ' + state.element.value + '</span>'
                );
                return $state;
            };

            var formatStateContent = function (state) {
                if (!state.id) {
                    return state.text;
                }

                var value = state.text;
                if (state.text.indexOf(' icon ') != -1) {
                    var array = value.split(' icon ');
                    return $(
                        '<span class="border-solid padding-2 ' + array[1] + '"></span>' +
                        '<span>  ' + array[1] + '</span>'
                    );
                } else if (state.text.indexOf(' image-set ') != -1) {

                } else if (state.text.indexOf(' image-icon ') != -1) {
                    array = value.split(' image-icon ');
                    return $(
                        '<img class="border-solid height-100" src="' + portalSvc.getAssetUrl() + '/images/' + array[1] + '">' +
                        '<span>  ' + array[1] + '</span>'
                    );
                } else if (state.text.indexOf(' image ') != -1) {
                    array = value.split(' image ');
                    return $(
                        '<img class="border-solid height-100" src="' + portalSvc.getAssetUrl() + '/images/' + array[1] + '">' +
                        '<span>  ' + array[1] + '</span>'
                    );
                }

                var $state = $(
                    '<span>' + state.text + '</span>'
                );
                return $state;
            };

            var createNotify = function (caption, content, type) {
                $.Notify({
                    // caption: type.toUpperCase(),
                    content: content,
                    type: type,
                    timeout: 5000,
                    shadow: true,
                    icon: (type == 'alert') ? '<span class="mif-warning"></span>' : '<span class="mif-info"></span>'
                })
            };

            return {
                getStyles: getStyles,
                getFunctions: getFunctions,
                formatStateColor: formatStateColor,
                formatStateContent: formatStateContent,
                changeProperty: changeProperty,
                createNotify: createNotify,
                initSelects: initSelects,
                getIcons: getIcons
            }
        }
    }
}]);