<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "deterioro".
 *
 * @property integer $id
 * @property integer $cantidad
 * @property string $fecha
 * @property integer $id_producto
 * @property integer $id_usuario
 * @property integer $importe_venta
 * @property integer $importe_costo
 *
 * @property Producto $idProducto
 * @property Usuario $idUsuario
 */
class Deterioro extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'deterioro';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cantidad', 'fecha', 'id_producto', 'id_usuario'], 'required'],
            [['cantidad', 'id_producto', 'id_usuario'], 'integer'],
            [['importe_venta', 'importe_costo'], 'number'],
            [['fecha'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id']],
            [['cantidad'], 'validarCantidad'],
            [['cantidad'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'La cantidad debe ser superior a 0'],
        ];
    }

    public function validarCantidad($attribute) {
        if (!$this->hasErrors()) {
            $producto = Producto::findOne($this->id_producto);
            $cantMax = $this->id ? $this->findOne($this->id)->cantidad + $producto->existencia : $producto->existencia;
            if ($this->cantidad > $cantMax) {
                $this->addError($attribute, 'La cantidad no puede ser superior a ' . $cantMax);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cantidad' => 'Ejemplares',
            'fecha' => 'Fecha',
            'id_producto' => 'Producto',
            'id_usuario' => 'Librero',
            'importe_venta' => 'Importe Venta',
            'importe_costo' => 'Importe Costo',
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
    public function getIdUsuario() {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }

}
