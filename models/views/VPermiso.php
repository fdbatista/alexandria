<?php

namespace app\models\views;

use Yii;

/**
 * This is the model class for table "v_permiso".
 *
 * @property integer $id
 * @property string $entidad
 * @property string $entidad_html
 * @property string $nombre
 * @property string $accion
 * @property string $descripcion
 * @property string $modulo
 * @property string $modulo_html
 * @property string $sub_modulo
 * @property string $sub_modulo_html
 * @property string $ruta
 */
class VPermiso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_permiso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['descripcion', 'ruta'], 'string'],
            [['entidad', 'entidad_html'], 'string', 'max' => 35],
            [['nombre', 'modulo', 'modulo_html', 'sub_modulo', 'sub_modulo_html'], 'string', 'max' => 50],
            [['accion'], 'string', 'max' => 25],
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
            'accion' => 'Accion',
            'descripcion' => 'Descripcion',
            'modulo' => 'Modulo',
            'modulo_html' => 'Modulo Html',
            'sub_modulo' => 'Sub Modulo',
            'sub_modulo_html' => 'Sub Modulo Html',
            'ruta' => 'Ruta',
        ];
    }
}
