app.controller('GraficoController', function ($scope, $http) {

    $scope.inicializar = function (home_url, id_tipo_grafico, id_tipo_reporte, tipo_reporte, fecha_inicial, fecha_final, generado) {
        $scope.home_url = home_url;
        $scope.id_tipo_grafico = id_tipo_grafico;
        $scope.id_tipo_reporte = id_tipo_reporte;
        $scope.tipo_reporte = tipo_reporte;
        $scope.fecha_inicial = fecha_inicial;
        $scope.fecha_final = fecha_final;

        if (generado === '1') {
            $scope.generarReporte();
        }
    };

    $scope.generarReporte = function () {
        $http.get($scope.home_url + "/ajax/generar-reporte-para-grafico/?id_tipo_reporte=" + $scope.id_tipo_reporte + "&fecha_inicial=" + $scope.fecha_inicial + "&fecha_final=" + $scope.fecha_final).then(function successCallback(response) {
            $scope.res = response.data;
            $('#chart-container').show();

            $(function () {
                Highcharts.setOptions({
                    lang: {
                        contextButtonTitle: "Opciones",
                        printChart: "Imprimir gr\u00E1fico",
                        downloadJPEG: "Descargar en formato JPEG",
                        downloadPDF: "Descargar en formato PDF (requiere conexi\u00F3n a Internet)",
                        downloadPNG: "Descargar en formato PNG",
                        downloadSVG: "Descargar en formato SVG",
                        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        noData: 'No hay resultados',
                        weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    }
                });
            });

            Highcharts.chart('chart-container', {
                exporting: {
                    allowHTML: true
                },
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: $scope.id_tipo_grafico,
                },
                title: {
                    text: 'Resultados'
                },
                tooltip: {
                    pointFormat: $scope.id_tipo_grafico === 'pie' ? '{series.name}: <b>{point.percentage:.1f}%</b>' : '{series.name}: {point.y}'
                },
                /*plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        showInLegend: true,
                        dataLabels: {
                            enabled: true,
                            format: '<b>{series.name}</b>',
                        }
                    }
                },*/
                xAxis: {
                    categories: $scope.res.titulos,
                    title: {
                        text: ''
                    }
                },
                yAxis: {
                    title: {
                        text: $scope.tipo_reporte
                    }
                },
                series: [
                    {
                        name: $scope.tipo_reporte,
                        data: $scope.id_tipo_reporte === 'ejemplares-vendidos' ? $scope.res.totales : $scope.res.ingresos
                    }
                ]
            });

            $('.highcharts-credits').hide();
        });
    };

});
