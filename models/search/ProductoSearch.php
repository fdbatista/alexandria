<?php

namespace app\models\search;

use app\models\Producto;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductoSearch represents the model behind the search form about `app\models\Producto`.
 */
class ProductoSearch extends Producto {

    public $idGenero;
    public $idEditorial;
    public $idTipoLiteratura;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'existencia', 'anho_edicion', 'id_genero', 'id_editorial', 'id_tipo_literatura'], 'integer'],
            [['codigo', 'titulo', 'idGenero', 'idEditorial', 'idTipoLiteratura'], 'safe'],
            [['precio_venta', 'precio_costo'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Producto::find()->orderBy(['titulo' => SORT_ASC]);

        // add conditions that should always apply here
        $query->joinWith(['idGenero']);
        $query->joinWith(['idEditorial']);
        $query->joinWith(['idTipoLiteratura']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idGenero'] = [
            'asc' => ['genero.nombre' => SORT_ASC],
            'desc' => ['genero.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['idEditorial'] = [
            'asc' => ['editorial.nombre' => SORT_ASC],
            'desc' => ['editorial.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['idTipoLiteratura'] = [
            'asc' => ['tipo_literatura.nombre' => SORT_ASC],
            'desc' => ['tipo_literatura.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['ilike', 'codigo', $this->codigo])
                ->andFilterWhere(['ilike', 'titulo', $this->titulo])
                ->andFilterWhere(['ilike', 'precio_venta', $this->precio_venta])
                ->andFilterWhere(['ilike', 'precio_costo', $this->precio_costo])
                ->andFilterWhere(['ilike', 'existencia', $this->existencia])
                ->andFilterWhere(['ilike', 'anho_edicion', $this->anho_edicion])
                ->andFilterWhere(['ilike', 'genero.nombre', $this->idGenero])
                ->andFilterWhere(['ilike', 'editorial.nombre', $this->idEditorial])
                ->andFilterWhere(['ilike', 'tipo_literatura.nombre', $this->idTipoLiteratura]);

        return $dataProvider;
    }

}
