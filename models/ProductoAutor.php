<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto_autor".
 *
 * @property integer $id_autor
 * @property integer $id_producto
 * @property integer $id
 *
 * @property Autor $idAutor
 * @property Producto $idProducto
 */
class ProductoAutor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto_autor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_producto'], 'required'],
            [['id_autor', 'id_producto'], 'integer'],
            [['id_autor', 'id_producto'], 'unique', 'targetAttribute' => ['id_autor', 'id_producto'], 'message' => 'Esta relación ya ha sido establecida'],
            [['id_autor'], 'exist', 'skipOnError' => true, 'targetClass' => Autor::className(), 'targetAttribute' => ['id_autor' => 'id']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_autor' => 'Id Autor',
            'id_producto' => 'Id Producto',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAutor()
    {
        return $this->hasOne(Autor::className(), ['id' => 'id_autor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProducto()
    {
        return $this->hasOne(Producto::className(), ['id' => 'id_producto']);
    }
}
