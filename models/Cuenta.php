<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cuenta".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property TipoProducto[] $tipoProductos
 */
class Cuenta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cuenta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoProductos()
    {
        return $this->hasMany(TipoProducto::className(), ['id_cuenta' => 'id']);
    }
}
