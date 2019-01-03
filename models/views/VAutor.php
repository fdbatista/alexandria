<?php

namespace app\models\views;

use Yii;

/**
 * This is the model class for table "v_autor".
 *
 * @property integer $id
 * @property string $nombre_completo
 * @property string $sexo
 * @property string $pais
 */
class VAutor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_autor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nombre_completo'], 'string'],
            [['sexo'], 'string', 'max' => 9],
            [['pais'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_completo' => 'Nombre Completo',
            'sexo' => 'Sexo',
            'pais' => 'Pais',
        ];
    }
}
