<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventario".
 *
 * @property integer $id
 * @property integer $id_producto
 * @property integer $id_usuario
 * @property integer $cantidad
 * @property boolean $sala_comercial
 *
 * @property Producto $idProducto
 * @property Usuario $idUsuario
 */
class Inventario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producto', 'cantidad'], 'required'],
            [['id_producto', 'id_usuario', 'cantidad'], 'integer'],
            [['sala_comercial'], 'boolean'],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_producto' => 'Producto',
            'id_usuario' => 'Usuario',
            'cantidad' => 'Cantidad',
            'sala_comercial' => 'Sala Comercial',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Producto::className(), ['id' => 'id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
