<?php

namespace app\models;

use app\models\Devolucion;
use app\models\Producto;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "devolucion_producto".
 *
 * @property integer $id
 * @property integer $cantidad
 * @property string $precio_venta
 * @property string $precio_costo
 * @property string $importe_venta
 * @property string $importe_costo
 * @property integer $id_producto
 * @property integer $id_devolucion
 *
 * @property Devolucion $idDevolucion
 * @property Producto $idProducto
 */
class DevolucionProducto extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'devolucion_producto';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cantidad', 'precio_venta', 'precio_costo', 'importe_venta', 'importe_costo', 'id_producto', 'id_devolucion'], 'required'],
            [['cantidad', 'id_producto', 'id_devolucion'], 'integer'],
            [['precio_venta', 'precio_costo', 'importe_venta', 'importe_costo'], 'number'],
            [['id_devolucion'], 'exist', 'skipOnError' => true, 'targetClass' => Devolucion::className(), 'targetAttribute' => ['id_devolucion' => 'id']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cantidad' => 'Cantidad',
            'precio_venta' => 'Precio Venta',
            'precio_costo' => 'Precio Costo',
            'importe_venta' => 'Importe Venta',
            'importe_costo' => 'Importe Costo',
            'id_producto' => 'Id Producto',
            'id_devolucion' => 'Id Devolucion',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdDevolucion() {
        return $this->hasOne(Devolucion::className(), ['id' => 'id_devolucion']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdProducto() {
        return $this->hasOne(Producto::className(), ['id' => 'id_producto']);
    }

}
