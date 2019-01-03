<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rol_permiso".
 *
 * @property integer $id
 * @property integer $id_rol
 * @property integer $id_permiso
 *
 * @property Permiso $idPermiso
 * @property Rol $idRol
 */
class RolPermiso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol_permiso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_rol', 'id_permiso'], 'required'],
            [['id_rol', 'id_permiso'], 'integer', 'message' => 'Este campo es obligatorio'],
            [['id_rol', 'id_permiso'], 'unique', 'targetAttribute' => ['id_rol', 'id_permiso'], 'message' => 'Este permiso ya fue asignado a este rol.'],
            [['id_permiso'], 'exist', 'skipOnError' => true, 'targetClass' => Permiso::className(), 'targetAttribute' => ['id_permiso' => 'id']],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['id_rol' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_rol' => 'Rol',
            'id_permiso' => 'Permiso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPermiso()
    {
        return $this->hasOne(Permiso::className(), ['id' => 'id_permiso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'id_rol']);
    }
}
