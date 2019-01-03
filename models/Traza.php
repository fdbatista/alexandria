<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "traza".
 *
 * @property integer $id
 * @property integer $id_usuario
 * @property string $fecha_hora
 * @property string $tipo_objeto
 * @property integer $id_objeto
 * @property string $descripcion
 * @property string $accion
 *
 * @property Usuario $idUsuario
 */
class Traza extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traza';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_objeto'], 'integer'],
            [['fecha_hora'], 'safe'],
            [['tipo_objeto', 'accion'], 'required'],
            [['tipo_objeto'], 'string', 'max' => 30],
            [['descripcion'], 'string', 'max' => 1024],
            [['accion'], 'string', 'max' => 64],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario' => 'Usuario',
            'fecha_hora' => 'Fecha y hora',
            'tipo_objeto' => 'Entidad modificada',
            'id_objeto' => 'Objeto',
            'descripcion' => 'Descripción',
            'accion' => 'Acción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
