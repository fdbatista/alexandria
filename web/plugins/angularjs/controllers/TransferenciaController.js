app.controller('TransferenciaController', function ($scope, $http) {

    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $http.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");

    $scope.inicializar = function (home_url, id, numero, observaciones, id_almacen, fecha, id_cuenta) {
        $scope.producto = {};
        $scope.producto_tmp = {};
        $scope.productos = [];
        $scope.accion_sobre_producto = '';
        $scope.id_cuenta = id_cuenta;
        $scope.home_url = home_url;
        $scope.mensaje = 'Todos los campos son obligatorios';

        $scope.transferencia = {};
        $scope.params = {};
        $scope.transferencia.id = id;
        $scope.transferencia.numero = numero;
        $scope.transferencia.observaciones = observaciones;
        $scope.transferencia.id_almacen = id_almacen;
        $scope.transferencia.fecha = fecha;
        $scope.getProductosDeLaTransferencia();
        
        if ($scope.id_cuenta !== '') {
            $scope.getTiposDeProductosPorCuenta();
            $scope.getTodosLosProductosPorCuenta();
        }
        
        $scope.cantidad_total = 0;
        $scope.importe_venta_total = 0;
        $scope.importe_costo_total = 0;
    };
    
    $scope.actualizarObjetosPorIdCuenta = function () {
        if ($scope.id_cuenta !== '') {
            $('#cuenta-div').removeClass('has-error');
            $('#cuenta-div').addClass('has-success');
            $('#div-cuenta-errormsg').addClass('hidden');
            $scope.getTiposDeProductosPorCuenta();
            $scope.getTodosLosProductosPorCuenta();
        } else {
            $('#cuenta-div').removeClass('has-success');
            $('#cuenta-div').addClass('has-error');
            $('#div-cuenta-errormsg').removeClass('hidden');
        }
    };

    $scope.getTiposDeProductosPorCuenta = function () {
        $http.get($scope.home_url + "ajax/get-tipos-productos/?id_cuenta=" + $scope.id_cuenta).then(function successCallback(response) {
            $scope.tiposDeProductos = response.data;
        });
    };

    $scope.getTodosLosProductosPorCuenta = function () {
        $http.get($scope.home_url + "ajax/get-productos-por-id-cuenta/?id_cuenta=" + $scope.id_cuenta).then(function successCallback(response) {
            $scope.todosLosProductos = response.data;
        });
    };

    $scope.getProductosDeLaTransferencia = function () {
        if ($scope.transferencia.id !== "") {
            $http.get($scope.home_url + "ajax/get-productos-por-id-transf/?id_transferencia=" + $scope.transferencia.id).then(function successCallback(response) {
                $scope.productos = response.data;
                $scope.actualizarTotales();
            });
        }
    };

    $scope.existeProducto = function () {
        for (var i = 0; i < $scope.productos.length; i++) {
            if ($scope.productoACadena($scope.productos[i]) === $scope.productoACadena($scope.producto)) {
                return i;
            }
        }
        return -1;
    };

    $scope.productoACadena = function (producto) {
        return producto.id_tipo_producto + producto.titulo + producto.codigo;
    };

    $scope.tituloInvalido = function () {
        var titulo = $('#titulo-autocomplete_value').val();
        return !titulo;
    };

    $scope.adicionarProducto = function () {
        $scope.producto = $scope.producto_tmp;
        if ($scope.producto === undefined || !$scope.producto.hasOwnProperty("title")) {
            $scope.producto.titulo = $('#titulo-autocomplete_value').val();
        } else {
            $scope.producto.titulo = $scope.producto.title;
        }
        
        $scope.actualizarImporteVenta();
        $scope.actualizarImporteCosto();

        for (var i = 0; i < $scope.tiposDeProductos.length; i++) {
            if ($scope.tiposDeProductos[i].id === $scope.producto.id_tipo_producto) {
                $scope.producto.tipo_producto = $scope.tiposDeProductos[i].nombre;
                break;
            }
        }
        var pos_prod = $scope.existeProducto();

        if (pos_prod === -1) {
            $scope.productos.push($scope.producto);
        } else {
            $scope.productos.splice(pos_prod, 1, $scope.producto);
        }
        
        $scope.actualizarTotales();
        
        if ($scope.accion_sobre_producto === 'adicionar') {
            $scope.producto = {};
            $scope.producto_tmp = {};
            $scope.producto.titulo = '';
            $('#titulo-autocomplete_value').val('');
        } else {
            $('#adicionar-producto').modal('hide');
        }

    };

    $scope.mostrarVentana = function (tipo_accion, indice) {
        $scope.accion_sobre_producto = tipo_accion;

        switch (tipo_accion) {

            case 'adicionar':

                if ($scope.id_cuenta !== '') {
                    $scope.producto_tmp = {};
                    $scope.producto_tmp.id_transferencia_producto = '0';
                    $('#titulo-autocomplete_value').val('');
                    $('#adicionar-producto').modal('show');
                } else {
                    $('#cuenta-div').removeClass('has-success');
                    $('#cuenta-div').addClass('has-error');
                    $('#div-cuenta-errormsg').removeClass('hidden');
                }
                break;

            case 'actualizar':

                $scope.producto = $scope.productos[indice];
                $scope.producto_tmp = {};
                $scope.producto_tmp.id = $scope.producto.id;
                $scope.producto_tmp.id_transferencia_producto = $scope.producto.id_transferencia_producto;
                $scope.producto_tmp.id_tipo_producto = $scope.producto.id_tipo_producto;
                $scope.producto_tmp.codigo = $scope.producto.codigo;
                $scope.producto_tmp.titulo = $scope.producto.titulo;
                $scope.producto_tmp.cantidad = $scope.producto.cantidad;
                $scope.producto_tmp.precio_venta = $scope.producto.precio_venta;
                $scope.producto_tmp.precio_costo = $scope.producto.precio_costo;
                $('#titulo-autocomplete_value').val($scope.producto.titulo);
                $('#adicionar-producto').modal();
                break;

            case 'eliminar':

                $scope.indice_producto_a_eliminar = indice;
                $scope.producto = $scope.productos[indice];
                $scope.producto_a_eliminar = $scope.producto.titulo;
                $('#eliminar-producto').modal('show');
                break;

            default:
                break;
        }
    };

    $scope.eliminarProducto = function () {
        $scope.productos.splice($scope.indice_producto_a_eliminar, 1);
        $scope.actualizarTotales();
    };

    $scope.mostrarGrid = function () {
        $('#grid-content').hide();
        $('#grid-content').fadeIn(500);
    };

    $scope.mostrarMensaje = function (message, divClass, divId) {
        $scope.message = message;
        var divMsg = $(divId);
        divMsg.addClass(divClass);
        switch (divClass)
        {
            case 'alert-danger':
            {
                divMsg.removeClass('alert-info alert-warning');
                break;
            }
            case 'alert-warning':
            {
                divMsg.removeClass('alert-info alert-danger');
                break;
            }
            default:
                divMsg.removeClass('alert-danger alert-warning');
                break;
        }

        divMsg.show();
        divMsg.animate({'opacity': 1}, 3000).animate({'opacity': 0}, 3000, function () {
            divMsg.hide();
        });
    };

    $scope.guardar = function () {
        $('#btn-submit').attr('disabled', 'disabled');
        $('#btn-submit-fa').addClass('fa-refresh fa-spin');
        var params = {
            transferencia: $scope.transferencia,
            productos: $scope.productos
        };

        var url = $scope.home_url + "administracion/documentos/transferencia/guardar/?transferencia=" + JSON.stringify(params);

        $http({
            method: 'POST',
            url: url,
            headers: {
                'Content-type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function successCallback(response) {
            $scope.mostrarMensaje(response, 'alert-info', '#div-message-product');
            window.location.href = $scope.home_url + "administracion/documentos/transferencia";
        }, function errorCallback(response) {
            $scope.obtenerErrores(response);
            $('#btn-submit').removeAttr('disabled');
        });
    };

    //delete record
    $scope.confirmarEliminacion = function (id) {
        $http({
            method: 'POST',
            url: $scope.home_url + 'products/delete/' + id,
            data: $.param($scope.item) + '&api_token=' + $scope.api_token,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
            $scope.mostrarMensaje(response, 'alert-info', '#div-message');
            $scope.obtenerProductos($scope.paginationConfig.currentPage);
        }).error(function (response) {
            $scope.mostrarMensaje(response, 'alert-danger', '#div-message');
        });
    };

    //search
    $scope.buscar = function (criteria) {
        $('#img-loading').show();
        $http({
            method: 'GET',
            url: $scope.home_url + "products/search/",
            params: {criteria: criteria, api_token: $scope.api_token},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (response) {
            $scope.allItems = response;
            $scope.updatePagination(1);
            $('#img-loading').hide();
        }).error(function (response) {
            $scope.mostrarMensaje(response, 'alert-danger', '#div-message');
        });
    };


    $scope.obtenerErrores = function (response) {
        var errors = '';
        $.each(response, function (i, item)
        {
            errors += item + "<br />";
        });
        var messageDivId = '';
        if ($scope.modalstate === 'raffle')
        {
            messageDivId = '#div-message-raffle';
        } else
        {
            messageDivId = '#div-message-product';
        }
        $scope.mostrarMensaje($scope.rtrim(errors, '<br />'), 'alert-danger', messageDivId);
    };

    $scope.rtrim = function (s) {
        var r = s.length - 1;
        while (r > 0 && s[r] === ' ')
        {
            r -= 1;
        }
        return s.substring(0, r + 1);
    };

    /*$scope.cambiarTitulo = function () {
        console.log($scope.producto);
    };*/

    $scope.entidadIncompleta = function () {
        return !$scope.transferencia.id_almacen || !$scope.transferencia.numero || !$scope.transferencia.fecha || $scope.productos.length === 0;
    };

    $scope.productoIncompleto = function () {
        return !$scope.producto_tmp.id_tipo_producto || !$scope.producto_tmp.codigo || $scope.tituloInvalido() || $scope.cantidadIncorrecta() || $scope.precioCostoIncorrecto() || $scope.precioVentaIncorrecto();
    };
    
    
    $scope.cantidadIncorrecta = function () {
        return !$scope.producto_tmp.cantidad || isNaN($scope.producto_tmp.cantidad) || parseInt($scope.producto_tmp.cantidad) <= 0;
    };
    
    $scope.precioVentaIncorrecto = function () {
        return !$scope.producto_tmp.precio_venta || isNaN($scope.producto_tmp.precio_venta) || parseInt($scope.producto_tmp.precio_venta) <= 0;
    };
    
    $scope.precioCostoIncorrecto = function () {
        return !$scope.producto_tmp.precio_costo || isNaN($scope.producto_tmp.precio_costo) || parseInt($scope.producto_tmp.precio_costo) <= 0;
    };

    $scope.validarNumero = function (atributo) {
        switch (atributo) {
            case 'cantidad':
                if (isNaN($scope.producto_tmp.cantidad) || parseInt($scope.producto_tmp.cantidad) <= 0) {
                    $scope.producto_tmp.cantidad = null;
                    $scope.mensaje = 'La cantidad debe ser mayor que cero';
                }
                else {
                    $scope.mensaje = 'Todos los campos son obligatorios';
                }
                break;
            case 'precio_venta':
                if (isNaN($scope.producto_tmp.precio_venta) || parseInt($scope.producto_tmp.precio_venta) <= 0) {
                    $scope.producto_tmp.precio_venta = null;
                    $scope.mensaje = 'El precio de venta debe ser mayor que cero';
                }
                else {
                    $scope.mensaje = 'Todos los campos son obligatorios';
                }
                break;
            case 'precio_costo':
                if (isNaN($scope.producto_tmp.precio_costo) || parseInt($scope.producto_tmp.precio_costo) <= 0) {
                    $scope.producto_tmp.precio_costo = null;
                    $scope.mensaje = 'El precio de costo debe ser mayor que cero';
                }
                else {
                    $scope.mensaje = 'Todos los campos son obligatorios';
                }
                break;
            default:
                break;
        }
    };
    
    $scope.actualizarImporteVenta = function () {
        if (isNaN($scope.producto_tmp.cantidad)) {
            $scope.producto_tmp.cantidad = undefined;
            $scope.producto_tmp.importe_venta = '0.00';
        } else {
            $scope.producto_tmp.importe_venta = parseFloat(parseFloat($scope.producto_tmp.precio_venta) * parseInt($scope.producto_tmp.cantidad)).toFixed(2);
            var importe = $scope.producto_tmp.importe_venta.toString();
            if (importe.indexOf('.') === -1) {
                $scope.producto_tmp.importe_venta = importe + '.00';
            }
        }
    };
    
    $scope.actualizarImporteCosto = function () {
        if (isNaN($scope.producto_tmp.cantidad)) {
            $scope.producto_tmp.cantidad = undefined;
            $scope.producto_tmp.importe_costo = '0.00';
        } else {
            $scope.producto_tmp.importe_costo = parseFloat(parseFloat($scope.producto_tmp.precio_costo) * parseInt($scope.producto_tmp.cantidad)).toFixed(2);
            var importe = $scope.producto_tmp.importe_costo.toString();
            if (importe.indexOf('.') === -1) {
                $scope.producto_tmp.importe_costo = importe + '.00';
            }
        }
    };
    
    $scope.actualizarTotales = function () {
        $scope.cantidad_total = 0;
        $scope.importe_venta_total = 0;
        $scope.importe_costo_total = 0;
        for (var i = 0; i < $scope.productos.length; i++) {
            var productoTmp = $scope.productos[i];
            $scope.cantidad_total += parseInt(productoTmp.cantidad);
            $scope.importe_venta_total = $scope.importe_venta_total + parseFloat(productoTmp.importe_venta);
            $scope.importe_costo_total = $scope.importe_costo_total + parseFloat(productoTmp.importe_costo);
        }
        $scope.importe_venta_total = $scope.importe_venta_total.toFixed(2);
        $scope.importe_costo_total = $scope.importe_costo_total.toFixed(2);
    };

});
