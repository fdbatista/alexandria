<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "transferencia_producto".
 *
 * @property integer $id
 * @property integer $cantidad
 * @property string $precio_venta
 * @property string $importe_costo
 * @property string $importe_venta
 * @property integer $id_transferencia
 * @property integer $id_producto
 *
 * @property Producto $idProducto
 * @property Transferencia $idTransferencia
 */
class TransferenciaProducto extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'transferencia_producto';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cantidad', 'importe_costo', 'importe_venta', 'id_transferencia', 'id_producto', 'precio_venta'], 'required'],
            [['cantidad', 'id_transferencia', 'id_producto'], 'integer'],
            [['importe_costo', 'importe_venta', 'precio_venta'], 'number'],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id']],
            [['id_transferencia'], 'exist', 'skipOnError' => true, 'targetClass' => Transferencia::className(), 'targetAttribute' => ['id_transferencia' => 'id']],
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
            'importe_costo' => 'Importe Costo',
            'importe_venta' => 'Importe Venta',
            'id_transferencia' => 'Transferencia',
            'id_producto' => 'Producto',
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
    public function getIdTransferencia() {
        return $this->hasOne(Transferencia::className(), ['id' => 'id_transferencia']);
    }

}
