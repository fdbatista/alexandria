<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "suministrador".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $codigo
 * @property string $codigo_nit
 * @property string $cuenta_bancaria
 * @property string $agencia
 * @property string $direccion
 *
 * @property Factura[] $facturas
 */
class Suministrador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'suministrador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'codigo', 'codigo_nit', 'cuenta_bancaria', 'agencia', 'direccion'], 'required'],
            [['nombre'], 'string', 'max' => 70],
            [['codigo', 'codigo_nit', 'cuenta_bancaria'], 'string', 'max' => 20],
            [['agencia'], 'string', 'max' => 10],
            [['direccion'], 'string', 'max' => 100],
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
            'codigo' => 'Código',
            'codigo_nit' => 'Código NIT',
            'cuenta_bancaria' => 'Cuenta bancaria',
            'agencia' => 'Agencia',
            'direccion' => 'Dirección',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturas()
    {
        return $this->hasMany(Factura::className(), ['id_suministrador' => 'id']);
    }
}
