<?php

namespace app\models\views;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "v_producto".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $titulo
 * @property string $precio_venta
 * @property string $precio_costo
 * @property integer $existencia
 * @property integer $tomo
 * @property integer $numero
 * @property integer $volumen
 * @property string $observaciones
 * @property integer $anho_revista
 * @property string $issn
 * @property string $isbn
 * @property integer $anho_edicion
 * @property string $genero
 * @property string $tematica
 * @property string $tipo_literatura
 * @property string $tipo_publico
 * @property string $frecuencia
 * @property string $editorial
 * @property string $tipo_producto
 * @property string $criterio_busqueda
 */
class VProducto extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'v_producto';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'existencia', 'tomo', 'numero', 'volumen', 'anho_revista', 'anho_edicion'], 'integer'],
            [['precio_venta', 'precio_costo'], 'number'],
            [['criterio_busqueda'], 'string'],
            [['codigo'], 'string', 'max' => 20],
            [['titulo', 'observaciones'], 'string', 'max' => 250],
            [['issn', 'isbn'], 'string', 'max' => 25],
            [['genero', 'tematica', 'tipo_literatura', 'tipo_publico', 'frecuencia', 'editorial', 'tipo_producto'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'titulo' => 'Titulo',
            'precio_venta' => 'Precio Venta',
            'precio_costo' => 'Precio Costo',
            'existencia' => 'Existencia',
            'tomo' => 'Tomo',
            'numero' => 'Numero',
            'volumen' => 'Volumen',
            'observaciones' => 'Observaciones',
            'anho_revista' => 'Anho Revista',
            'issn' => 'Issn',
            'isbn' => 'Isbn',
            'anho_edicion' => 'Anho Edicion',
            'genero' => 'Genero',
            'tematica' => 'Tematica',
            'tipo_literatura' => 'Tipo Literatura',
            'tipo_publico' => 'Tipo Publico',
            'frecuencia' => 'Frecuencia',
            'editorial' => 'Editorial',
            'tipo_producto' => 'Tipo Producto',
            'criterio_busqueda' => 'Criterio Busqueda',
        ];
    }

}
