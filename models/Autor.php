<?php

namespace app\models;

use app\models\Pais;
use app\models\ProductoAutor;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "autor".
 *
 * @property integer $id
 * @property string $nombre1
 * @property string $nombre2
 * @property string $apellido1
 * @property string $apellido2
 * @property string $nombre_completo
 * @property string $sexo
 * @property integer $id_pais
 *
 * @property Pais $idPais
 * @property ProductoAutor[] $productoAutors
 */
class Autor extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'autor';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombre1', 'sexo', 'id_pais'], 'required'],
            [['id_pais'], 'integer'],
            [['nombre1', 'nombre2'], 'string', 'max' => 25],
            [['apellido1', 'apellido2'], 'string', 'max' => 30],
            [['nombre_completo'], 'string', 'max' => 120],
            [['sexo'], 'string', 'max' => 9],
            [['id_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['id_pais' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nombre1' => 'Primer nombre',
            'nombre2' => 'Segundo nombre',
            'apellido1' => 'Primer apellido',
            'apellido2' => 'Segundo apellido',
            'nombre_completo' => 'Nombre completo',
            'sexo' => 'Sexo',
            'id_pais' => 'País',
        ];
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
    public function getProductoAutors() {
        return $this->hasMany(ProductoAutor::className(), ['id_autor' => 'id']);
    }

    public function getNombreCompleto() {
        return $this->nombre1 . ' ' . $this->nombre2 . ' ' . $this->apellido1 . ' ' . $this->apellido2;
    }

}
