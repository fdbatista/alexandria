<?php

namespace app\models;

use app\models\Deterioro;
use app\models\DevolucionProducto;
use app\models\Editorial;
use app\models\Genero;
use app\models\ProductoAutor;
use app\models\RebajaPrecio;
use app\models\Tematica;
use app\models\TipoLiteratura;
use app\models\TipoProducto;
use app\models\TipoPublico;
use app\models\TransferenciaProducto;
use app\models\VentaProducto;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "producto".
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
 * @property integer $id_genero
 * @property integer $id_tematica
 * @property integer $id_tipo_literatura
 * @property integer $id_tipo_publico
 * @property integer $id_editorial
 * @property integer $id_tipo_producto
 *
 * @property Deterioro[] $deterioros
 * @property DevolucionProducto[] $devolucionProductos
 * @property Movimiento[] $movimientos
 * @property Editorial $idEditorial
 * @property Genero $idGenero
 * @property Tematica $idTematica
 * @property TipoLiteratura $idTipoLiteratura
 * @property TipoProducto $idTipoProducto
 * @property TipoPublico $idTipoPublico
 * @property ProductoAutor[] $productoAutors
 * @property RebajaPrecio[] $rebajaPrecios
 * @property TransferenciaProducto[] $transferenciaProductos
 * @property VentaProducto[] $ventaProductos
 */
class Producto extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'producto';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['codigo', 'titulo', 'precio_venta', 'precio_costo', 'existencia', 'id_tipo_producto'], 'required'],
            [['precio_venta', 'precio_costo'], 'number'],
            [['existencia', 'tomo', 'numero', 'volumen', 'anho_revista', 'anho_edicion'], 'integer',],
            [['id_genero', 'id_tematica', 'id_tipo_literatura', 'id_tipo_publico', 'id_editorial'], 'integer', 'message' => 'Debe seleccionar un elemento'],
            [['id_tipo_producto'], 'integer', 'message' => 'Este campo es obligatorio'],
            [['codigo'], 'string', 'max' => 20],
            [['titulo', 'observaciones'], 'string', 'max' => 250],
            [['issn', 'isbn'], 'string', 'max' => 25],
            [['id_editorial'], 'exist', 'skipOnError' => true, 'targetClass' => Editorial::className(), 'targetAttribute' => ['id_editorial' => 'id']],
            [['id_genero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::className(), 'targetAttribute' => ['id_genero' => 'id']],
            [['id_tematica'], 'exist', 'skipOnError' => true, 'targetClass' => Tematica::className(), 'targetAttribute' => ['id_tematica' => 'id']],
            [['id_tipo_literatura'], 'exist', 'skipOnError' => true, 'targetClass' => TipoLiteratura::className(), 'targetAttribute' => ['id_tipo_literatura' => 'id']],
            [['id_tipo_producto'], 'exist', 'skipOnError' => true, 'targetClass' => TipoProducto::className(), 'targetAttribute' => ['id_tipo_producto' => 'id']],
            [['id_tipo_publico'], 'exist', 'skipOnError' => true, 'targetClass' => TipoPublico::className(), 'targetAttribute' => ['id_tipo_publico' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'codigo' => 'Código',
            'titulo' => 'Título',
            'precio_venta' => 'Precio Venta',
            'precio_costo' => 'Precio Costo',
            'existencia' => 'Existencia',
            'tomo' => 'Tomo',
            'numero' => 'Número',
            'volumen' => 'Volumen',
            'observaciones' => 'Observaciones',
            'anho_revista' => 'Año de la Revista',
            'anho_edicion' => 'Año Edición',
            'id_genero' => 'Género',
            'id_tematica' => 'Temática',
            'id_tipo_literatura' => 'Tipo de Literatura',
            'id_tipo_publico' => 'Tipo de público',
            'id_editorial' => 'Editorial',
            'id_tipo_producto' => 'Tipo de producto',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDeterioros() {
        return $this->hasMany(Deterioro::className(), ['id_producto' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDevolucionProductos() {
        return $this->hasMany(DevolucionProducto::className(), ['id_producto' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMovimientos() {
        return $this->hasMany(Movimiento::className(), ['id_producto' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdEditorial() {
        return $this->hasOne(Editorial::className(), ['id' => 'id_editorial']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdGenero() {
        return $this->hasOne(Genero::className(), ['id' => 'id_genero']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdTematica() {
        return $this->hasOne(Tematica::className(), ['id' => 'id_tematica']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdTipoLiteratura() {
        return $this->hasOne(TipoLiteratura::className(), ['id' => 'id_tipo_literatura']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdTipoProducto() {
        return $this->hasOne(TipoProducto::className(), ['id' => 'id_tipo_producto']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIdTipoPublico() {
        return $this->hasOne(TipoPublico::className(), ['id' => 'id_tipo_publico']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductoAutors() {
        return $this->hasMany(ProductoAutor::className(), ['id_producto' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRebajaPrecios() {
        return $this->hasMany(RebajaPrecio::className(), ['id_producto' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransferenciaProductos() {
        return $this->hasMany(TransferenciaProducto::className(), ['id_producto' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVentaProductos() {
        return $this->hasMany(VentaProducto::className(), ['id_producto' => 'id']);
    }

}
