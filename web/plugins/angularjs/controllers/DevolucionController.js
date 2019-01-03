app.controller('DevolucionController', function ($scope, $http) {

    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $http.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");

    $scope.inicializar = function (home_url, id, numero, fecha, idUsuario, idEfectEntr, idCuenta, descomercial) {

        $scope.producto = {};
        $scope.producto_tmp = {};
        $scope.producto.id = undefined;
        $scope.producto.precio_costo = undefined;
        $scope.producto.precio = undefined;
        $scope.producto.cantidad = undefined;
        $scope.producto.codigo = undefined;
        $scope.mensaje = 'Este dato es obligatorio';

        $scope.cantidad_total = 0;
        $scope.importe_venta_total = 0;
        $scope.importe_costo_total = 0;
        if (descomercial !== 0) {
            $scope.descuento_comercial = descomercial;
        } else {
            $scope.actualizarDescomercial();
        }

        $scope.productos = [];
        $scope.accion_sobre_producto = '';
        $scope.home_url = home_url;
        $scope.id_cuenta = idCuenta;


        $scope.devolucion = {};
        $scope.devolucion.id = id;
        $scope.devolucion.numero = numero;
        $scope.devolucion.fecha = fecha;
        $scope.devolucion.id_usuario = idUsuario;
        $scope.devolucion.id_efect_entr = idEfectEntr;

        if ($scope.devolucion.id !== '') {
            $scope.getProductosDeLaDev();
        }

        $scope.getTodosLosProductos();

    };
    
    $scope.cantidadIncorrecta = function () {
        return !$scope.producto_tmp.cantidad || isNaN($scope.producto_tmp.cantidad) || parseInt($scope.producto_tmp.cantidad) <= 0;
    };

    $scope.actualizarProductoTmp = function () {
        $scope.producto_tmp.id = $scope.producto_tmp.contenido.id;
        $scope.producto_tmp.codigo = $scope.producto_tmp.contenido.codigo;
        $scope.producto_tmp.titulo = $scope.producto_tmp.contenido.titulo;
        $scope.producto_tmp.precio_costo = $scope.producto_tmp.contenido.precio_costo;
        $scope.producto_tmp.precio_venta = parseFloat($scope.producto_tmp.contenido.precio_venta).toFixed(2);
        $scope.producto_tmp.contenido = {};
        $scope.actualizarImporte();
    };

    $scope.actualizarImporte = function () {
        if (!$scope.producto_tmp.cantidad) {
            $scope.mensaje = 'Este dato es obligatorio';
        }
        if (isNaN($scope.producto_tmp.cantidad)) {
            $scope.mensaje = 'Debe introducir un número';
            $scope.producto_tmp.cantidad = undefined;
            $scope.producto_tmp.importe_venta = '0.00';
            $scope.producto_tmp.importe_costo = '0.00';
        } else if (parseInt($scope.producto_tmp.cantidad) === 0) {
            $scope.mensaje = 'La cantidad debe ser mayor que cero';
            $scope.producto_tmp.importe_venta = '0.00';
        } else {
            $scope.mensaje = '';
            $scope.producto_tmp.importe_venta = parseFloat(parseFloat($scope.producto_tmp.precio_venta) * parseInt($scope.producto_tmp.cantidad)).toFixed(2);
            $scope.producto_tmp.importe_costo = $scope.producto_tmp.precio_costo * $scope.producto_tmp.cantidad;
            var importeVenta = $scope.producto_tmp.importe_venta.toString();
            var importeCosto = $scope.producto_tmp.importe_costo.toString();

            if (importeVenta.indexOf('.') === -1) {
                $scope.producto_tmp.importe_venta = importeVenta + '.00';
            }

            if (importeCosto.indexOf('.') === -1) {
                $scope.producto_tmp.importe_costo = importeCosto + '.00';
            }
        }
    };

    $scope.getTodosLosProductos = function () {
        $http.get($scope.home_url + "ajax/get-vproductos").then(function successCallback(response) {
            $scope.todosLosProductos = response.data;
        });
    };

    $scope.getProductosDeLaDev = function () {
        if ($scope.devolucion.id !== "") {
            $http.get($scope.home_url + "ajax/get-productos-por-id-dev/?id_devolucion=" + $scope.devolucion.id).then(function successCallback(response) {
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
        return producto.id;
    };

    $scope.productoIncompleto = function () {
        return ($scope.producto_tmp.id === undefined || $scope.cantidadIncorrecta());
    };

    $scope.adicionarProducto = function () {
        $('#btn-act-prod').attr('disabled', 'disabled');
        $http.get($scope.home_url + "ajax/is-cantidad-ok/?id_producto=" + $scope.producto_tmp.id + "&cantidad=" + $scope.producto_tmp.cantidad).then(function successCallback(response) {
            var cantidad_ok = response.data;
            if (cantidad_ok === 1) {
                $scope.producto = $scope.producto_tmp;
                $scope.producto.contenido = {};

                if ($scope.existeProducto() === -1 && $scope.accion_sobre_producto === 'adicionar') {
                    $scope.productos.push($scope.producto);
                } else {
                    $scope.productos.splice($scope.indice_producto, 1, $scope.producto);
                }
                $scope.actualizarTotales();

                if ($scope.accion_sobre_producto === 'adicionar') {
                    $scope.producto_tmp = {};
                } else {
                    $('#adicionar-producto').modal('hide');
                }

            } else {
                alert('La cantidad supera la existencia');
                $scope.producto.cantidad = $scope.producto_tmp.cantidad;
                $scope.actualizarImporte();
            }
            $('#btn-act-prod').removeAttr('disabled');
        });

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
        $scope.importe_costo_total = $scope.importe_costo_total.toFixed(6);
    };

    $scope.getTotalAPagar = function () {
        return ($scope.importe_venta_total - ($scope.importe_venta_total * $scope.descuento_comercial / 100)).toFixed(2);
    };

    $scope.mostrarVentana = function (tipo_accion, indice) {
        $scope.accion_sobre_producto = tipo_accion;
        $scope.indice_producto = indice;

        switch (tipo_accion) {
            case 'adicionar':
                if ($scope.id_cuenta !== '') {
                    $scope.producto_tmp = {};
                    $scope.producto = {};
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
                $scope.producto_tmp.cantidad = $scope.producto.cantidad;
                $scope.producto_tmp.codigo = $scope.producto.codigo;
                $scope.producto_tmp.id = $scope.producto.id;
                $scope.producto_tmp.importe_venta = $scope.producto.importe_venta;
                $scope.producto_tmp.precio_venta = $scope.producto.precio_venta;
                $scope.producto_tmp.precio_costo = $scope.producto.precio_costo;
                $scope.producto_tmp.titulo = $scope.producto.titulo;
                $scope.producto_tmp.contenido = $scope.producto;
                $('#adicionar-producto').modal({backdrop: 'static'});
                break;
            case 'eliminar':
                $scope.producto = $scope.productos[indice];
                $scope.producto_a_eliminar = $scope.producto.titulo;
                $('#eliminar-producto').modal('show');
                break;
            default:
                break;
        }
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

    $scope.cerrarVentana = function () {
        $('#adicionar-producto').modal('hide');
    };

    $scope.eliminarProducto = function () {
        $scope.productos.splice($scope.indice_producto, 1);
        $scope.actualizarTotales();
    };

    $scope.entidadIncompleta = function () {
        return $scope.devolucion.numero === '' || $scope.devolucion.fecha === '' || $scope.devolucion.id_efect_entr === '' || !$scope.devolucion.id_usuario || $scope.productos.length === 0;
    };

    $scope.guardar = function () {

        $('#btn-submit').attr('disabled', 'disabled');
        $('#btn-submit-fa').addClass('fa-refresh fa-spin');

        var params = {
            devolucion: $scope.devolucion,
            productos: $scope.productos
        };

        var url = $scope.home_url + "sitio/devolucion/guardar/?devolucion=" + JSON.stringify(params);
        $http({
            method: 'POST',
            url: url,
            headers: {
                'Content-type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function successCallback(response) {
            window.location.href = $scope.home_url + "sitio/devolucion";
        }, function errorCallback(response) {
            $('#btn-submit').removeAttr('disabled');
        });
    };

    $scope.actualizarDescomercial = function () {
        $http.get($scope.home_url + "ajax/get-descomercial-por-id-efect-entr/?id_efect_entr=" + $scope.devolucion.id_efect_entr).then(
                function successCallback(response) {
                    $scope.descuento_comercial = response.data;
                });
    };

});
