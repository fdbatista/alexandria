<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asociacion".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Editorial[] $editorials
 */
class Asociacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asociacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditorials()
    {
        return $this->hasMany(Editorial::className(), ['id_asociacion' => 'id']);
    }
}
