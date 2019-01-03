<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "config_app".
 *
 * @property integer $id
 * @property string $nombre_app
 * @property integer $id_libreria
 * @property integer $id_categoria
 *
 * @property Categoria $idCategoria
 */
class ConfigApp extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'config_app';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'nombre_app', 'id_libreria', 'id_categoria'], 'required'],
            [['id', 'id_categoria',], 'integer'],
            [['nombre_app'], 'string', 'max' => 25],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['id_categoria' => 'id']],
            [['id_libreria'], 'exist', 'skipOnError' => true, 'targetClass' => Libreria::className(), 'targetAttribute' => ['id_libreria' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'nombre_app' => 'Nombre de la Aplicación',
            'id_libreria' => 'Librería',
            'id_categoria' => 'Categoría de la Librería',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdCategoria() {
        return $this->hasOne(Categoria::className(), ['id' => 'id_categoria']);
    }
    
     /**
     * @return ActiveQuery
     */
    public function getIdLibreria() {
        return $this->hasOne(Libreria::className(), ['id' => 'id_libreria']);
    }

}
