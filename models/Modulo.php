<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modulo".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $nombre_html
 *
 * @property Permiso[] $permisos
 * @property SubModulo[] $subModulos
 */
class Modulo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modulo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'nombre_html'], 'required'],
            [['nombre', 'nombre_html'], 'string', 'max' => 50],
            [['nombre_html'], 'unique'],
            [['nombre'], 'unique'],
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
            'nombre_html' => 'Nombre Html',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermisos()
    {
        return $this->hasMany(Permiso::className(), ['id_modulo' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubModulos()
    {
        return $this->hasMany(SubModulo::className(), ['id_modulo' => 'id']);
    }
}
