<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provincia".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $id_pais
 *
 * @property Editorial[] $editorials
 * @property Municipio[] $municipios
 * @property Pais $idPais
 */
class Provincia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provincia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'id_pais'], 'required'],
            [['id_pais'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['nombre', 'id_pais'], 'unique', 'targetAttribute' => ['nombre', 'id_pais'], 'message' => 'The combination of Nombre and Id Pais has already been taken.'],
            [['id_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['id_pais' => 'id']],
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
            'id_pais' => 'País',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditorials()
    {
        return $this->hasMany(Editorial::className(), ['id_provincia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios()
    {
        return $this->hasMany(Municipio::className(), ['id_provincia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'id_pais']);
    }
}
