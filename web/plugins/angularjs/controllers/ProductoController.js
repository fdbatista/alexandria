app.controller('ProductoController', function ($scope, $http) {

    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $http.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");

    $scope.inicializar = function (
            home_url,
            codigo,
            anho_edicion,
            existencia,
            id,
            id_editorial,
            id_genero,
            id_tematica,
            id_tipo_literatura,
            id_tipo_producto,
            id_tipo_publico,
            numero,
            observaciones,
            precio_costo,
            precio_venta,
            titulo,
            tomo,
            volumen
            ) {
        $scope.autor = {};
        $scope.autor.id = '';
        $scope.autores = [];
        $scope.accion_sobre_autor = '';
        $scope.home_url = home_url;

        $scope.producto = {};
        $scope.producto.codigo = codigo;
        $scope.producto.anho_edicion = anho_edicion;
        $scope.producto.existencia = existencia;
        $scope.producto.id = id;
        $scope.producto.id_editorial = id_editorial;
        $scope.producto.id_genero = id_genero;
        $scope.producto.id_tematica = id_tematica;
        $scope.producto.id_tipo_literatura = id_tipo_literatura;
        $scope.producto.id_tipo_producto = id_tipo_producto;
        $scope.producto.id_tipo_publico = id_tipo_publico;
        $scope.producto.numero = numero;
        $scope.producto.observaciones = observaciones;
        $scope.producto.precio_costo = precio_costo;
        $scope.producto.precio_venta = precio_venta;
        $scope.producto.titulo = titulo;
        $scope.producto.tomo = tomo;
        $scope.producto.volumen = volumen;

        $scope.getDependenciasDeLaEntidad();
        $scope.getTodasLasDependencias();

    };

    $scope.getTodasLasDependencias = function () {
        $http.get($scope.home_url + "ajax/get-vautores").then(function successCallback(response) {
            $scope.todosLosAutores = response.data;
        });
    };

    $scope.getDependenciasDeLaEntidad = function () {
        if ($scope.producto.id) {
            $http.get($scope.home_url + "ajax/get-autores-por-id-producto/?id=" + $scope.producto.id).then(function successCallback(response) {
                $scope.autores = response.data;
            });
        }
    };

    $scope.existeAutor = function () {
        for (var i = 0; i < $scope.autores.length; i++) {
            if ($scope.autorACadena($scope.autores[i]) === $scope.autorACadena($scope.autor)) {
                return i;
            }
        }
        return -1;
    };

    $scope.autorACadena = function (objeto) {
        return objeto.id;
    };

    $scope.adicionarAutor = function () {
        $('#btn-act-prod').attr('disabled', 'disabled');
        $scope.autor = $scope.autor_tmp;
        $scope.autor.contenido = {};

        if ($scope.existeAutor() === -1 && $scope.accion_sobre_autor === 'adicionar') {
            $scope.autores.push($scope.autor);
        } else {
            $scope.autores.splice($scope.indice_producto, 1, $scope.autor);
        }

        if ($scope.accion_sobre_autor === 'adicionar') {
            $scope.autor_tmp = {};
        } else {
            $('#adicionar-producto').modal('hide');
        }
        $('#btn-act-prod').removeAttr('disabled');

    };

    $scope.mostrarVentana = function (tipo_accion, indice) {
        $scope.accion_sobre_autor = tipo_accion;
        $scope.indice_producto = indice;

        switch (tipo_accion) {
            case 'adicionar':

                $scope.autor_tmp = {};
                $scope.autor = {};
                $('#adicionar-producto').modal('show');
                break;

            case 'actualizar':

                $scope.autor = $scope.autores[indice];
                $scope.autor_tmp = {};
                $scope.autor_tmp = $scope.autor;
                $('#adicionar-producto').modal({backdrop: 'static'});
                break;

            case 'eliminar':

                $scope.autor = $scope.autores[indice];
                $scope.autor_a_eliminar = $scope.autor.titulo;
                $('#eliminar-producto').modal('show');
                break;

            default:
                break;
        }
    };

    $scope.cerrarVentana = function () {
        $('#adicionar-producto').modal('hide');
    };

    $scope.eliminarAutor = function () {
        $scope.autores.splice($scope.indice_producto, 1);
    };

    $scope.entidadIncompleta = function () {
        return !$scope.producto.id_tipo_producto || !$scope.producto.codigo || !$scope.producto.titulo || !$scope.producto.existencia || !$scope.producto.precio_venta || !$scope.producto.precio_costo || $scope.autores.length === 0;
    };

    $scope.guardar = function () {

        $('#btn-submit').attr('disabled', 'disabled');
        $('#btn-submit-fa').addClass('fa-refresh fa-spin');

        var params = {
            modelo: $scope.producto,
            dependencias: $scope.autores
        };

        var url = $scope.home_url + "sitio/producto/guardar/?modelo=" + JSON.stringify(params);

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
