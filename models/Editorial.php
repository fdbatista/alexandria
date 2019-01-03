<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "editorial".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $id_asociacion
 * @property string $direccion
 * @property integer $id_pais
 * @property integer $id_provincia
 *
 * @property Asociacion $idAsociacion
 * @property Pais $idPais
 * @property Provincia $idProvincia
 * @property Producto[] $productos
 */
class Editorial extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'editorial';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombre', 'id_asociacion', 'id_pais', 'id_provincia'], 'required'],
            [['id_asociacion', 'id_pais', 'id_provincia'], 'integer', 'message' => 'Este campo es obligatorio'],
            [['nombre'], 'string', 'max' => 100],
            [['direccion'], 'string', 'max' => 250],
            [['id_asociacion'], 'exist', 'skipOnError' => true, 'targetClass' => Asociacion::className(), 'targetAttribute' => ['id_asociacion' => 'id']],
            [['id_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['id_pais' => 'id']],
            [['id_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['id_provincia' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'id_asociacion' => 'Asociación',
            'direccion' => 'Dirección',
            'id_pais' => 'País',
            'id_provincia' => 'Provincia',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdAsociacion() {
        return $this->hasOne(Asociacion::className(), ['id' => 'id_asociacion']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdPais() {
        return $this->hasOne(Pais::className(), ['id' => 'id_pais']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdProvincia() {
        return $this->hasOne(Provincia::className(), ['id' => 'id_provincia']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductos() {
        return $this->hasMany(Producto::className(), ['id_editorial' => 'id']);
    }

}
