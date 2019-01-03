app.controller('GastoController', function ($scope, $http) {

    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $http.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");

    $scope.inicializar = function (home_url, id, numero, fecha, id_ejecutor_gasto) {

        $scope.producto = {};
        $scope.producto_tmp = {};
        $scope.producto.id = '';
        $scope.producto.cantidad = '';

        $scope.cantidad_total = 0;
        $scope.importe_venta_total = 0;
        $scope.importe_costo_total = 0;

        $scope.productos = [];
        $scope.accion_sobre_producto = '';
        $scope.home_url = home_url;

        $scope.gasto = {};
        $scope.gasto.id = id;
        $scope.gasto.numero = numero;
        $scope.gasto.fecha = fecha;
        $scope.gasto.id_ejecutor_gasto = id_ejecutor_gasto;
        
        $scope.getProductosDelGasto();
        $scope.getTodosLosProductos();
    };

    $scope.actualizarProductoTmp = function () {
        $scope.producto_tmp.id = $scope.producto_tmp.contenido.id;
        $scope.producto_tmp.titulo = $scope.producto_tmp.contenido.titulo;
        $scope.producto_tmp.precio_costo = $scope.producto_tmp.contenido.precio_costo;
        $scope.producto_tmp.precio_venta = parseFloat($scope.producto_tmp.contenido.precio_venta).toFixed(2);
        $scope.producto_tmp.contenido = {};
        $scope.actualizarImportes();
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
    
    $scope.actualizarImportes = function () {
        $scope.actualizarImporteCosto();
        $scope.actualizarImporteVenta()();
    };

    $scope.getTodosLosProductos = function () {
        $http.get($scope.home_url + "ajax/get-vproductos").then(function successCallback(response) {
            $scope.todosLosProductos = response.data;
        });
    };

    $scope.getProductosDelGasto = function () {
        if ($scope.gasto.id) {
            $http.get($scope.home_url + "sitio/producto/get-productos-por-id-gasto/?id_gasto=" + $scope.gasto.id).then(function successCallback(response) {
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

    $scope.productoInvalido = function () {
        return ($scope.producto_tmp.id === undefined || $scope.producto_tmp.cantidad === undefined);
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
                $scope.producto_tmp.cantidad = 0;
                $scope.actualizarImporteCosto();
                $scope.actualizarImporteVenta();
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
        $scope.importe_costo_total = $scope.importe_costo_total.toFixed(2);
    };

    $scope.mostrarVentana = function (tipo_accion, indice) {
        $scope.accion_sobre_producto = tipo_accion;
        $scope.indice_producto = indice;

        switch (tipo_accion) {
            case 'adicionar':

                $scope.producto_tmp = {};
                $scope.producto = {};
                $('#adicionar-producto').modal('show');
                break;

            case 'actualizar':

                $scope.producto = $scope.productos[indice];
                $scope.producto_tmp = {};
                $scope.producto_tmp.cantidad = $scope.producto.cantidad;
                $scope.producto_tmp.codigo = $scope.producto.codigo;
                $scope.producto_tmp.id = $scope.producto.id;
                $scope.producto_tmp.importe_venta = $scope.producto.importe_venta;
                $scope.producto_tmp.importe_costo = $scope.producto.importe_costo;
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

    $scope.cerrarVentana = function () {
        $('#adicionar-producto').modal('hide');
    };

    $scope.eliminarProducto = function () {
        $scope.productos.splice($scope.indice_producto, 1);
        $scope.actualizarTotales();
    };

    $scope.entidadIncompleta = function () {
        return !$scope.gasto.fecha || !$scope.gasto.id_ejecutor_gasto || !$scope.gasto.numero || $scope.productos.length === 0;
    };

    $scope.guardar = function () {

        $('#btn-submit').attr('disabled', 'disabled');
        $('#btn-submit-fa').addClass('fa-refresh fa-spin');

        var params = {
            gasto: $scope.gasto,
            productos: $scope.productos
        };

        var url = $scope.home_url + "sitio/gasto/guardar/?gasto=" + JSON.stringify(params);

        $http({
            method: 'POST',
            url: url,
            headers: {
                'Content-type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function successCallback(response) {
            window.location.href = $scope.home_url + "sitio/gasto";
        }, function errorCallback(response) {
            $('#btn-submit').removeAttr('disabled');
        });
    };

});
