<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipio".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $id_provincia
 *
 * @property Almacen[] $almacens
 * @property Libreria[] $librerias
 * @property Provincia $idProvincia
 */
class Municipio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'municipio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'id_provincia'], 'required'],
            [['id_provincia'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['id_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['id_provincia' => 'id']],
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
            'id_provincia' => 'Provincia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlmacens()
    {
        return $this->hasMany(Almacen::className(), ['id_almacenes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibrerias()
    {
        return $this->hasMany(Libreria::className(), ['id_municipio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProvincia()
    {
        return $this->hasOne(Provincia::className(), ['id' => 'id_provincia']);
    }
}
