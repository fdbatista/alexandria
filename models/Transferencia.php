<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "transferencia".
 *
 * @property integer $id
 * @property integer $numero
 * @property string $observaciones
 * @property integer $id_almacen
 * @property date $fecha
 *
 * @property Almacen $idAlmacen
 * @property TransferenciaProducto[] $transferenciaProductos
 */
class Transferencia extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'transferencia';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['numero', 'fecha', 'id_almacen'], 'required'],
            [['numero', 'id_almacen'], 'integer'],
            [['fecha'], 'safe'],
            [['observaciones'], 'string', 'max' => 250],
            [['id_almacen'], 'exist', 'skipOnError' => true, 'targetClass' => Almacen::className(), 'targetAttribute' => ['id_almacen' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'numero' => 'Número',
            'observaciones' => 'Observaciones',
            'id_almacen' => 'Proveedor',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdAlmacen() {
        return $this->hasOne(Almacen::className(), ['id' => 'id_almacen']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransferenciaProductos() {
        return $this->hasMany(TransferenciaProducto::className(), ['id_transferencia' => 'id']);
    }

    public function getCantidadTotal() {
        return $this->getTransferenciaProductos()->sum('cantidad');
    }

    public function getImporteVentaTotal() {
        return $this->getTransferenciaProductos()->sum('importe_venta');
    }

    public function getImporteCostoTotal() {
        return $this->getTransferenciaProductos()->sum('importe_costo');
    }

}
