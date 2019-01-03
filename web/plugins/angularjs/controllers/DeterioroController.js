app.controller('DeterioroController', function ($scope, $http) {

    $scope.inicializar = function (home_url, id_producto, fecha, idUsuario, cantidad) {
        $scope.home_url = home_url;
        $scope.producto = {};
        $scope.producto_tmp = {};
        $scope.producto_tmp.id = id_producto;
        $scope.getTodosLosProductos();
        $scope.deterioro = {};
        $scope.deterioro.fecha = fecha;
        $scope.deterioro.id_usuario = idUsuario;
        $scope.deterioro.cantidad = cantidad;
    };

    $scope.buscarProducto = function (id_producto) {
        for (var i = 0; i < $scope.todosLosProductos.length; i++) {
            if ($scope.todosLosProductos[i].id == id_producto) {
                $scope.producto_tmp.contenido = $scope.todosLosProductos[i];
                $scope.actualizarProductoTmp();
                break;
            }
        }
    };

    $scope.actualizarProductoTmp = function () {
        $scope.producto_tmp.id = $scope.producto_tmp.contenido.id;
        $scope.producto_tmp.titulo = $scope.producto_tmp.contenido.titulo;
        $scope.producto_tmp.contenido = {};
        $('#deterioro-id_producto').val($scope.producto_tmp.id);
        $('#deterioro-id_producto-div').removeClass('has-error');
        $('#deterioro-id_producto-div').addClass('has-success');
        $('.field-deterioro-id_producto .help-block').html('');
    };

    $scope.getTodosLosProductos = function () {
        $http.get($scope.home_url + "ajax/get-vproductos").then(function successCallback(response) {
            $scope.todosLosProductos = response.data;
            if ($scope.producto_tmp.id) {
                $scope.buscarProducto($scope.producto_tmp.id);
            }
        });
    };

    $scope.validar = function () {
        if (!$scope.producto_tmp.id) {
            $('#deterioro-id_producto-div').removeClass('has-success');
            $('#deterioro-id_producto-div').addClass('has-error');
        } else {
            $('#deterioro-id_producto-div').removeClass('has-error');
            $('#deterioro-id_producto-div').addClass('has-success');
        }
    };

    $scope.entidadIncompleta = function () {
        return $scope.deterioro.cantidad === '' || $scope.deterioro.fecha === '' || !$scope.deterioro.id_usuario || $scope.productos.length === 0;
    };

});
