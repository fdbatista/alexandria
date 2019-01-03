<?php

namespace app\models;

use app\models\DevolucionProducto;
use app\models\EfectivoEntrega;
use app\models\Factura;
use app\models\Usuario;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "devolucion".
 *
 * @property integer $id
 * @property integer $numero
 * @property string $fecha
 * @property integer $id_efect_entr
 * @property integer $id_usuario
 * 
 * @property EfectivoEntrega $idEfectEntr
 * @property Usuario $idUsuario
 * @property DevolucionProducto[] $devolucionProductos
 * @property Factura[] $facturas
 */
class Devolucion extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'devolucion';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['numero', 'fecha', 'id_efect_entr', 'id_usuario'], 'required'],
            [['numero', 'id_efect_entr', 'id_usuario'], 'integer'],
            [['fecha'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_efect_entr'], 'exist', 'skipOnError' => true, 'targetClass' => EfectivoEntrega::className(), 'targetAttribute' => ['id_efect_entr' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'numero' => 'Número',
            'fecha' => 'Fecha',
            'id_efect_entr' => 'Efectivo Entrega',
            'id_usuario' => 'Librero',
            'cantidadTotal' => 'Ejemplares',
            'importeTotal' => 'Importe',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdEfectEntr() {
        return $this->hasOne(EfectivoEntrega::className(), ['id' => 'id_efect_entr']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDevolucionProductos() {
        return $this->hasMany(DevolucionProducto::className(), ['id_devolucion' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFacturas() {
        return $this->hasMany(Factura::className(), ['id_devolucion' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdUsuario() {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }

    public function getCantidadTotal() {
        return $this->hasMany(DevolucionProducto::className(), ['id_devolucion' => 'id'])->sum('cantidad');
    }

    public function getImporteTotal() {
        return $this->getDevolucionProductos()->sum('cantidad * precio_venta');
    }

}
