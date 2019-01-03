<?php

namespace app\models;

use app\models\Editorial;
use app\models\Producto;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "coleccion".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $id_editorial
 *
 * @property Editorial $idEditorial
 * @property Producto[] $productos
 */
class Coleccion extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'coleccion';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombre', 'id_editorial'], 'required'],
            [['id_editorial'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['id_editorial'], 'exist', 'skipOnError' => true, 'targetClass' => Editorial::className(), 'targetAttribute' => ['id_editorial' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'id_editorial' => 'Editorial',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdEditorial() {
        return $this->hasOne(Editorial::className(), ['id' => 'id_editorial']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductos() {
        return $this->hasMany(Producto::className(), ['id_coleccion' => 'id']);
    }

}
