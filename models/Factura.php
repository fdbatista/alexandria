<?php

namespace app\models;

use app\models\Devolucion;
use app\models\Suministrador;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "factura".
 *
 * @property integer $id
 * @property integer $numero
 * @property string $fecha
 * @property integer $id_suministrador
 * @property integer $id_devolucion
 *
 * @property Devolucion $idDevolucion
 * @property Suministrador $idSuministrador
 */
class Factura extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'factura';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['numero', 'fecha', 'id_suministrador', 'id_devolucion'], 'required'],
            [['numero', 'id_suministrador', 'id_devolucion'], 'integer'],
            [['fecha'], 'safe'],
            [['id_devolucion'], 'exist', 'skipOnError' => true, 'targetClass' => Devolucion::className(), 'targetAttribute' => ['id_devolucion' => 'id']],
            [['id_suministrador'], 'exist', 'skipOnError' => true, 'targetClass' => Suministrador::className(), 'targetAttribute' => ['id_suministrador' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'numero' => 'Número',
            'fecha' => 'Fecha',
            'id_suministrador' => 'Suministrador',
            'id_devolucion' => 'Devolución',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getIdDevolucion() {
        return $this->hasOne(Devolucion::className(), ['id' => 'id_devolucion']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdSuministrador() {
        return $this->hasOne(Suministrador::className(), ['id' => 'id_suministrador']);
    }

}
