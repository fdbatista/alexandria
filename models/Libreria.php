<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "libreria".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $telefono
 * @property string $direccion
 * @property integer $id_municipio
 * @property integer $id_categoria
 *
 * @property Categoria $idCategoria
 * @property Municipio $idMunicipio
 * @property PuntoVenta[] $puntoVentas
 * @property Usuario[] $usuarios
 */
class Libreria extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'libreria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'direccion', 'id_municipio', 'id_categoria'], 'required'],
            [['telefono', 'id_municipio', 'id_categoria'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['direccion'], 'string', 'max' => 250],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['id_categoria' => 'id']],
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
            'telefono' => 'Teléfono',
            'direccion' => 'Dirección',
            'id_municipio' => 'Municipio',
            'id_categoria' => 'Categoría',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'id_categoria']);
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
    public function getPuntoVentas()
    {
        return $this->hasMany(PuntoVenta::className(), ['id_libreria' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['id_libreria' => 'id']);
    }

}
