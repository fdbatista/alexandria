<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permiso".
 *
 * @property integer $id
 * @property string $entidad
 * @property string $entidad_html
 * @property string $nombre
 * @property integer $id_modulo
 * @property integer $id_sub_modulo
 * @property string $accion
 *
 * @property Modulo $idModulo
 * @property SubModulo $idSubModulo
 * @property RolPermiso[] $rolPermisos
 * @property Rol[] $idRols
 */
class Permiso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permiso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entidad', 'entidad_html', 'nombre', 'id_modulo'], 'required'],
            [['id_modulo', 'id_sub_modulo'], 'integer'],
            [['entidad', 'entidad_html'], 'string', 'max' => 35],
            [['nombre'], 'string', 'max' => 50],
            [['accion'], 'string', 'max' => 25],
            [['entidad', 'nombre'], 'unique', 'targetAttribute' => ['entidad', 'nombre'], 'message' => 'The combination of Entidad and Nombre has already been taken.'],
            [['id_modulo'], 'exist', 'skipOnError' => true, 'targetClass' => Modulo::className(), 'targetAttribute' => ['id_modulo' => 'id']],
            [['id_sub_modulo'], 'exist', 'skipOnError' => true, 'targetClass' => SubModulo::className(), 'targetAttribute' => ['id_sub_modulo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entidad' => 'Entidad',
            'entidad_html' => 'Entidad Html',
            'nombre' => 'Nombre',
            'id_modulo' => 'Módulo',
            'id_sub_modulo' => 'Sub Módulo',
            'accion' => 'Acción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdModulo()
    {
        return $this->hasOne(Modulo::className(), ['id' => 'id_modulo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubModulo()
    {
        return $this->hasOne(SubModulo::className(), ['id' => 'id_sub_modulo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolPermisos()
    {
        return $this->hasMany(RolPermiso::className(), ['id_permiso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRols()
    {
        return $this->hasMany(Rol::className(), ['id' => 'id_rol'])->viaTable('rol_permiso', ['id_permiso' => 'id']);
    }
}
