<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "almacen".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $direccion
 * @property integer $id_municipio
 *
 * @property Municipio $idMunicipio
 * @property Transferencia[] $transferencias
 */
class Almacen extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'almacen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'direccion', 'id_municipio'], 'required'],
            [['id_municipio'], 'integer', 'message' => 'Este campo es obligatorio'],
            [['nombre'], 'string', 'max' => 100],
            [['direccion'], 'string', 'max' => 250],
            [['id_municipio'], 'exist', 'skipOnError' => true, 'targetClass' => Municipio::className(), 'targetAttribute' => ['id_municipio' => 'id']],
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
            'direccion' => 'Dirección',
            'id_municipio' => 'Municipio',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdMunicipio()
    {
        return $this->hasOne(Municipio::className(), ['id' => 'id_municipio']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransferencias()
    {
        return $this->hasMany(Transferencia::className(), ['id_almacen' => 'id']);
    }
}
