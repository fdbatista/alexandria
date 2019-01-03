<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "venta".
 *
 * @property integer $id
 * @property string $fecha
 * @property integer $id_usuario
 *
 * @property Usuario $idUsuario
 * @property VentaProducto[] $ventaProductos
 */
class Venta extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'venta';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['fecha', 'id_usuario'], 'required'],
            [['id_usuario',], 'integer'],
            [['fecha'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'id_usuario' => 'Librero',
            'cantidadTotal' => 'Ejemplares',
            'importeTotal' => 'Importe',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdUsuario() {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVentaProductos() {
        return $this->hasMany(VentaProducto::className(), ['id_venta' => 'id']);
    }

    public function getCantidadTotal() {
        return $this->hasMany(VentaProducto::className(), ['id_venta' => 'id'])->sum('cantidad');
    }

    public function getImporteTotal() {
        return $this->getVentaProductos()->sum('cantidad * precio');
    }

}
