<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_modulo".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $nombre_html
 * @property integer $id_modulo
 *
 * @property Permiso[] $permisos
 * @property Modulo $idModulo
 */
class SubModulo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_modulo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'id_modulo'], 'required'],
            [['id_modulo'], 'integer'],
            [['nombre', 'nombre_html'], 'string', 'max' => 50],
            [['id_modulo', 'nombre_html'], 'unique', 'targetAttribute' => ['id_modulo', 'nombre_html'], 'message' => 'The combination of Nombre Html and Id Modulo has already been taken.'],
            [['id_modulo', 'nombre'], 'unique', 'targetAttribute' => ['id_modulo', 'nombre'], 'message' => 'The combination of Nombre and Id Modulo has already been taken.'],
            [['id_modulo'], 'exist', 'skipOnError' => true, 'targetClass' => Modulo::className(), 'targetAttribute' => ['id_modulo' => 'id']],
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
            'id_modulo' => 'Módulo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermisos()
    {
        return $this->hasMany(Permiso::className(), ['id_sub_modulo' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdModulo()
    {
        return $this->hasOne(Modulo::className(), ['id' => 'id_modulo']);
    }
}
