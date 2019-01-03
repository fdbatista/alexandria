<?php

namespace app\models\views;

use Yii;

/**
 * This is the model class for table "v_entidad".
 *
 * @property string $entidad
 * @property string $entidad_html
 */
class VEntidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_entidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entidad', 'entidad_html'], 'string', 'max' => 35],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entidad' => 'Entidad',
            'entidad_html' => 'Entidad Html',
        ];
    }
}
