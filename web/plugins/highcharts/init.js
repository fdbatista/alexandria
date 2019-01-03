$(function () {

    Highcharts.setOptions({
        lang: {
            contextButtonTitle: 'Opciones',
            printChart: 'Imprimir gr\u00E1fico',
            downloadJPEG: 'Descargar en formato JPEG',
            downloadPDF: 'Descargar en formato PDF (requiere conexi\u00F3n a Internet)',
            downloadPNG: 'Descargar en formato PNG',
            downloadSVG: 'Descargar en formato SVG',
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            noData: 'No hay resultados',
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        }
    });

    Highcharts.chart('chart-container', {
        exporting: {
            allowHTML: true
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'Título'
        },
        xAxis: {
            categories: ['El viejo y el mar', 'Pulgarcito', 'La Odisea'],
            title: {
                text: 'Productos'
            }
        },
        yAxis: {
            title: {
                text: 'Ejemplares vendidos'
            }
        },
        series: [{
                name: 'Ventas',
                data: [1, 5, 4]
            }
        ]
    });

    $('.highcharts-credits').hide();

});