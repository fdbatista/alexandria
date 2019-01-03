<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "efectivo_entrega".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $id_receptor
 *
 * @property Devolucion[] $devolucions
 * @property Receptor $idReceptor
 */
class EfectivoEntrega extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efectivo_entrega';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'id_receptor'], 'required'],
            [['id_receptor'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['id_receptor'], 'exist', 'skipOnError' => true, 'targetClass' => Receptor::className(), 'targetAttribute' => ['id_receptor' => 'id']],
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
            'id_receptor' => 'Receptor',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDevolucions()
    {
        return $this->hasMany(Devolucion::className(), ['id_efect_entr' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdReceptor()
    {
        return $this->hasOne(Receptor::className(), ['id' => 'id_receptor']);
    }
}
