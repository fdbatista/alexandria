<?php

namespace app\models\views;

use Yii;

/**
 * This is the model class for table "v_usuario".
 *
 * @property integer $id
 * @property string $nombre1
 * @property string $nombre2
 * @property string $apellido1
 * @property string $apellido2
 * @property boolean $habilitado_sala_comercial
 * @property string $nombre_usuario
 * @property string $contrasenha
 * @property boolean $activo
 */
class VUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['habilitado_sala_comercial', 'activo'], 'boolean'],
            [['nombre1', 'nombre2', 'nombre_usuario'], 'string', 'max' => 25],
            [['apellido1', 'apellido2'], 'string', 'max' => 30],
            [['contrasenha'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre1' => 'Nombre1',
            'nombre2' => 'Nombre2',
            'apellido1' => 'Apellido1',
            'apellido2' => 'Apellido2',
            'habilitado_sala_comercial' => 'Habilitado Sala Comercial',
            'nombre_usuario' => 'Nombre Usuario',
            'contrasenha' => 'Contrasenha',
            'activo' => 'Activo',
        ];
    }
}
