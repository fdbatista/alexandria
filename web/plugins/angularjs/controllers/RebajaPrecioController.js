app.controller('RebajaPrecioController', function ($scope, $http) {

    $scope.inicializar = function (home_url, id_producto, fecha) {
        $scope.home_url = home_url;
        $scope.fecha = fecha;
        $scope.producto_tmp = {};
        $scope.producto_tmp.id = id_producto;
        $scope.getTodosLosProductos();
    };

    $scope.buscarProducto = function () {
        for (var i = 0; i < $scope.todosLosProductos.length; i++) {
            if ($scope.todosLosProductos[i].id == $scope.producto_tmp.id) {
                $scope.producto_tmp.contenido = $scope.todosLosProductos[i];
                $scope.actualizarProductoTmp();
                break;
            }
        }
    };

    $scope.actualizarProductoTmp = function () {
        
        $scope.producto_tmp.id = $scope.producto_tmp.contenido.id;
        $scope.producto_tmp.titulo = $scope.producto_tmp.contenido.titulo;
        $scope.producto_tmp.precio_anterior = $scope.producto_tmp.contenido.precio_venta;
        $scope.producto_tmp.contenido = {};
        $('#rebajaprecio-id_producto').val($scope.producto_tmp.id);
        $('#rebajaprecio-id_producto-div').removeClass('has-error');
        $('#rebajaprecio-id_producto-div').addClass('has-success');
        $('.field-rebajaprecio-id_producto .help-block').html('');
    };

    $scope.getTodosLosProductos = function () {
        $http.get($scope.home_url + "ajax/get-vproductos").then(function successCallback(response) {
            $scope.todosLosProductos = response.data;
            if ($scope.producto_tmp.id) {
                $scope.buscarProducto();
            }
        });
    };

    $scope.validar = function () {
        if (!$scope.producto_tmp.id) {
            $('#rebajaprecio-id_producto-div').removeClass('has-success');
            $('#rebajaprecio-id_producto-div').addClass('has-error');
        }
        else {
            $('#rebajaprecio-id_producto-div').removeClass('has-error');
            $('#rebajaprecio-id_producto-div').addClass('has-success');
        }
    };

});
