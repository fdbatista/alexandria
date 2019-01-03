<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property string $nombre1
 * @property string $nombre2
 * @property string $apellido1
 * @property string $apellido2
 * @property string $nombre_completo
 * @property boolean $habilitado_sala_comercial
 * @property string $nombre_usuario
 * @property string $contrasenha
 * @property integer $id_rol
 * @property boolean $activo
 * @property string $email
 * @property string $codigo_verificacion
 * 
 *
 * @property Venta[] $ventas
 * @property Venta[] $ventas0
 * @property Rol $idRol
 */
class Usuario extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public $contrasenha_confirmacion;
    
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contrasenha'], 'string', 'min' => 8, 'tooShort' => 'La contraseña debe tener al menos 8 caracteres'],
            //['contrasenha', 'match', 'pattern' => '/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/'],
            ['contrasenha', 'match', 'pattern' => '/^(?=(?:.*[A-Z]){1,})(?=(?:.*[a-z]){1,})(?=(?:.*\d){1,})(?=(?:.*[!@#$%^&*()\-_=+{};:,<.>]){1,})(.{8,})$/', 'message' => 'La contraseña debe tener al menos una mayúscula, una minúscula, un número y un caracter especial.'],
            [['contrasenha', 'contrasenha_confirmacion'], 'required', 'when' => function($model) {
                return $this->id == null;
            }, 'whenClient' => "function (attribute, value) {
                return !$('#usuario-id').val();
            }"],
            [['nombre1', 'apellido1', 'nombre_usuario', 'id_rol', 'activo', 'email'], 'required'],
            [['habilitado_sala_comercial', 'activo'], 'boolean'],
            [['nombre1', 'nombre2', 'nombre_usuario'], 'string', 'max' => 25],
            [['apellido1', 'apellido2'], 'string', 'max' => 30],
            [['nombre_completo'], 'string', 'max' => 120],
            [['email', 'codigo_verificacion'], 'string', 'max' => 250],
            [['nombre_usuario'], 'unique', 'targetAttribute' => ['nombre_usuario'], 'message' => 'Este nombre de usuario ya existe.'],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['id_rol' => 'id']],
            ['contrasenha_confirmacion', 'compare', 'compareAttribute' => 'contrasenha', 'message' => 'Las contraseñas no coinciden'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'nombre1' => 'Primer nombre',
            'nombre2' => 'Segundo nombre',
            'apellido1' => 'Primer apellido',
            'apellido2' => 'Segundo apellido',
            'habilitado_sala_comercial' => 'Trabaja en Sala Comercial',
            'nombre_completo' => 'Nombre completo',
            'nombre_usuario' => 'Nombre de usuario',
            'contrasenha' => 'Contraseña',
            'contrasenha_confirmacion' => 'Confirmación de la contraseña',
            'id_rol' => 'Rol',
            'activo' => 'Activo',
            'email' => 'Email',
            'codigo_verificacion' => 'Código de verificación',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Venta::className(), ['id_usuario' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVentas0()
    {
        return $this->hasMany(Venta::className(), ['id_usuario_inventario' => 'id']);
    }
    
    public function getIdRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'id_rol']);
    }
    
    public function getNombreCompleto()
    {
        return $this->nombre1 . ' ' . $this->nombre2 . ' ' . $this->apellido1 . ' ' . $this->apellido2;
    }
    
}
