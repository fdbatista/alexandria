<?php

namespace app\models\search;

use app\models\Libreria;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LibreriaSearch represents the model behind the search form about `app\models\Libreria`.
 */
class LibreriaSearch extends Libreria {

    public $idProvincia, $idMunicipio, $idCategoria;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['id', 'telefono', 'id_municipio', 'id_categoria'], 'integer'],
                [['nombre', 'direccion', 'idProvincia', 'idMunicipio', 'idCategoria', 'idMunicipio.getIdProvincia'], 'safe'],
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
        $query = Libreria::find();

        // add conditions that should always apply here

        $query->joinWith(['idMunicipio'])->joinWith(['idMunicipio.idProvincia']);
        $query->joinWith(['idCategoria']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idMunicipio'] = [
            'asc' => ['municipio.nombre' => SORT_ASC],
            'desc' => ['municipio.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['idMunicipio.idProvincia'] = [
            'asc' => ['provincia.nombre' => SORT_ASC],
            'desc' => ['provincia.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['idCategoria'] = [
            'asc' => ['categoria.nombre' => SORT_ASC],
            'desc' => ['categoria.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['ilike', 'libreria.nombre', $this->nombre])
                ->andFilterWhere(['ilike', 'text(telefono)', $this->telefono])
                ->andFilterWhere(['ilike', 'direccion', $this->direccion])
                ->andFilterWhere(['ilike', 'municipio.nombre', $this->idMunicipio])
                ->andFilterWhere(['ilike', 'provincia.nombre', $this->idProvincia])
                ->andFilterWhere(['ilike', 'categoria.nombre', $this->idCategoria]);

        return $dataProvider;
    }

}
