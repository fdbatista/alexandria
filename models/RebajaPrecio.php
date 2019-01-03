<?php

namespace app\models;

use app\models\Producto;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "rebaja_precio".
 *
 * @property integer $id
 * @property string $precio_anterior
 * @property integer $id_producto
 * @property string $fecha
 * @property string $precio_nuevo
 *
 * @property Producto $idProducto
 */
class RebajaPrecio extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'rebaja_precio';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['precio_anterior', 'id_producto', 'precio_nuevo', 'fecha'], 'required'],
            [['precio_anterior', 'precio_nuevo'], 'number'],
            [['id_producto'], 'integer'],
            [['fecha'], 'safe'],
            ['precio_nuevo', 'compare', 'type' => 'number', 'compareAttribute' => 'precio_anterior', 'operator' => '<', 'message' => 'El precio nuevo debe ser inferior'],
            ['precio_nuevo', 'compare', 'type' => 'number', 'compareValue' => 0, 'operator' => '>', 'message' => 'El precio nuevo debe ser mayor que cero.'],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'precio_anterior' => 'Precio anterior',
            'id_producto' => 'Producto',
            'fecha' => 'Fecha',
            'precio_nuevo' => 'Precio nuevo',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdProducto() {
        return $this->hasOne(Producto::className(), ['id' => 'id_producto']);
    }

}
