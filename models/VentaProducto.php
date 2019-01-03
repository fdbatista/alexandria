<?php

namespace app\models;

use app\models\Producto;
use app\models\Venta;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "venta_producto".
 *
 * @property integer $id
 * @property integer $id_venta
 * @property integer $id_producto
 * @property integer $cantidad
 * @property string $precio
 *
 * @property Producto $idProducto
 * @property Venta $idVenta
 */
class VentaProducto extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'venta_producto';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id_venta', 'id_producto', 'precio', 'cantidad'], 'required'],
            [['id_venta', 'id_producto', 'cantidad'], 'integer'],
            [['precio'], 'number'],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id']],
            [['id_venta'], 'exist', 'skipOnError' => true, 'targetClass' => Venta::className(), 'targetAttribute' => ['id_venta' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'id_venta' => 'Venta',
            'id_producto' => 'Producto',
            'cantidad' => 'Cantidad',
            'precio' => 'Precio',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdProducto() {
        return $this->hasOne(Producto::className(), ['id' => 'id_producto']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdVenta() {
        return $this->hasOne(Venta::className(), ['id' => 'id_venta']);
    }

}
