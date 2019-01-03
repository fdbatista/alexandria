<?php

namespace app\models;

use app\models\EfectivoEntrega;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "receptor".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $codigo
 * @property string $codigo_nit
 * @property string $cuenta_bancaria
 * @property string $agencia
 * @property string $direccion
 * @property boolean $descuento_comercial
 *
 * @property EfectivoEntrega[] $efectivoEntregas
 */
class Receptor extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'receptor';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombre', 'codigo', 'cuenta_bancaria', 'agencia', 'direccion', 'descuento_comercial'], 'required'],
            [['descuento_comercial'], 'number'],
            [['nombre'], 'string', 'max' => 100],
            [['codigo', 'codigo_nit', 'cuenta_bancaria'], 'string', 'max' => 20],
            [['agencia'], 'string', 'max' => 10],
            [['direccion'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'codigo' => 'Código',
            'codigo_nit' => 'Codigo NIT',
            'cuenta_bancaria' => 'Cuenta bancaria',
            'agencia' => 'Agencia',
            'direccion' => 'Dirección',
            'descuento_comercial' => 'Descuento comercial',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEfectivoEntregas() {
        return $this->hasMany(EfectivoEntrega::className(), ['id_receptor' => 'id']);
    }

}
