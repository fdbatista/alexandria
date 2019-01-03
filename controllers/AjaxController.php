<?php

namespace app\controllers;

use app\models\EfectivoEntrega;
use app\models\HtmlHelpers;
use app\models\Municipio;
use app\models\Permiso;
use app\models\Producto;
use app\models\Provincia;
use app\models\TipoProducto;
use app\models\views\VAutor;
use app\models\views\VProducto;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class AjaxController extends Controller {

    public function actions() {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow' => true,
                        'actions' => ['error'],
                    ],
                        [
                        'allow' => true,
                        //'actions' => ['get-descomercial-por-id-efect-entr', 'get-provincias-por-pais', 'get-municipios-por-prov', 'get-permisos-por-entidad', 'get-tipos-productos-por-cuenta', 'get-tipos-productos', 'get-productos', 'get-productos-por-id-cuenta', 'get-productos-por-id-transf', 'get-productos-por-id-dev', 'get-productos-por-id-venta', 'get-vproductos', 'is-cantidad-ok', 'get-vautores', 'get-autores-por-id-producto', 'get-libreros'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionGetProvinciasPorPais($id) {
        echo HtmlHelpers::dropDownList(Provincia::className(), 'id_pais', $id, 'id', 'nombre');
    }

    public function actionGetMunicipiosPorProv($id) {
        echo HtmlHelpers::dropDownList(Municipio::className(), 'id_provincia', $id, 'id', 'nombre');
    }

    public function actionGetPermisosPorEntidad($entidad_html) {
        echo HtmlHelpers::dropDownList(Permiso::className(), 'entidad_html', $entidad_html, 'id', 'nombre');
    }

    public function actionGetTiposProductosPorCuenta($id) {
        echo HtmlHelpers::dropDownList(TipoProducto::className(), 'id_cuenta', $id, 'id', 'nombre');
    }

    public function actionGetTiposProductos($id_cuenta) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return TipoProducto::find()->where(['id_cuenta' => $id_cuenta])->all();
    }

    public function actionGetProductos() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Producto::find()->all();
    }

    public function actionGetProductosPorIdCuenta($id_cuenta) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Producto::findBySql("select p.* from producto p join tipo_producto t on (p.id_tipo_producto = t.id) where t.id_cuenta = $id_cuenta and p.existencia > 0")->all();
    }

    public function actionGetProductosPorIdTransf($id_transferencia) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = Yii::$app->db->createCommand("select p.id, p.codigo, p.titulo, p.precio_venta, p.precio_costo, tp.cantidad, (p.precio_costo * tp.cantidad) importe_costo, (p.precio_venta * tp.cantidad) importe_venta, p.numero, p.observaciones, p.id_tipo_producto, t.nombre tipo_producto, tp.precio_venta transf_pv from producto p join tipo_producto t on (p.id_tipo_producto = t.id) join transferencia_producto tp on (p.id = tp.id_producto and id_transferencia = :id_transferencia)");
        $query->bindValue(':id_transferencia', $id_transferencia);
        return $query->queryAll();
    }

    public function actionGetProductosPorIdDev($id_devolucion) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = Yii::$app->db->createCommand("select p.id, p.codigo, p.titulo, p.precio_venta, p.precio_costo, tp.cantidad, (p.precio_venta * tp.cantidad) importe_venta, (p.precio_costo * tp.cantidad) importe_costo, p.numero, p.id_tipo_producto, t.nombre tipo_producto from producto p join tipo_producto t on (p.id_tipo_producto = t.id) join devolucion_producto tp on (p.id = tp.id_producto and id_devolucion = :id_devolucion)");
        $query->bindValue(':id_devolucion', $id_devolucion);
        return $query->queryAll();
    }

    public function actionGetProductosPorIdVenta($id_venta) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = Yii::$app->db->createCommand("select p.id, p.codigo, p.titulo, p.precio_costo, v.precio precio_venta, v.cantidad, (v.precio * v.cantidad) importe_venta from producto p join venta_producto v on (p.id = v.id_producto) where v.id_venta = :id_venta");
        $query->bindValue(':id_venta', $id_venta);
        return $query->queryAll();
    }

    public function actionGetVproductos() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return VProducto::find()->all();
    }

    public function actionIsCantidadOk($id_producto, $cantidad) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Producto::findOne($id_producto);
        return ($model->existencia >= intval($cantidad)) ? 1 : 0;
    }

    public function actionGetVautores() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return VAutor::find()->all();
    }

    public function actionGetAutoresPorIdProducto($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Yii::$app->db->createCommand("select va.* from v_autor va join producto_autor pa on (va.id = pa.id_autor) where id_producto = :id_producto")->bindValue(':id_producto', $id)->queryAll();
    }

    public function actionGetLibreros() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Yii::$app->db->createCommand("select id, trim(concat(nombre1, ' ', apellido1, ' ', apellido2)) nombre, habilitado_sala_comercial from usuario where id_rol = 1")->queryAll();
    }

    public function actionGenerarReporteParaGrafico($id_tipo_reporte, $fecha_inicial, $fecha_final) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = ['titulos' => [], 'totales' => [], 'ingresos' => []];
        switch ($id_tipo_reporte) {
            case 'ejemplares-vendidos':
            case 'ingresos-por-ventas': {
                    $fecha_final = ($fecha_final == '') ? $fecha_inicial : $fecha_final;
                    $sql = "select p.titulo, sum(vp.cantidad) total, sum(vp.precio * vp.cantidad) ingresos from venta v, venta_producto vp, producto p where v.id = vp.id_venta and p.id = vp.id_producto and (v.fecha between '$fecha_inicial' and '$fecha_final') group by p.id order by p.titulo";
                    $valores = Yii::$app->db->createCommand($sql)->queryAll();
                    foreach ($valores as $valor) {
                        $res['titulos'][] = $valor['titulo'];
                        $res['totales'][] = intval($valor['total']);
                        $res['ingresos'][] = intval($valor['ingresos']);
                    }
                }
                break;
            default:
                break;
        }
        return $res;
    }

    public function actionGetDescomercialPorIdEfectEntr($id_efect_entr) {
        return EfectivoEntrega::findOne(['id' => $id_efect_entr])->idReceptor->descuento_comercial;
    }

}
