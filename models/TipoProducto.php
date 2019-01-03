<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_producto".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $id_cuenta
 *
 * @property Producto[] $productos
 * @property Cuenta $idCuenta
 */
class TipoProducto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'id_cuenta'], 'required'],
            [['id_cuenta'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['id_cuenta'], 'exist', 'skipOnError' => true, 'targetClass' => Cuenta::className(), 'targetAttribute' => ['id_cuenta' => 'id']],
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
            'id_cuenta' => 'Cuenta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['id_tipo_producto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCuenta()
    {
        return $this->hasOne(Cuenta::className(), ['id' => 'id_cuenta']);
    }
}
