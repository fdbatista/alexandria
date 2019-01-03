<?php

namespace app\models\search;

use app\models\ConfigApp;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ConfigAppSearch represents the model behind the search form about `app\models\ConfigApp`.
 */
class ConfigAppSearch extends ConfigApp {

    public $idCategoria;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'id_categoria'], 'integer'],
            [['nombre_app', 'nombre_libreria', 'idCategoria'], 'safe'],
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
        $query = ConfigApp::find();

        // add conditions that should always apply here

        $query->joinWith(['idCategoria']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

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

        $query->andFilterWhere(['ilike', 'nombre_app', $this->nombre_app])
                ->andFilterWhere(['ilike', 'nombre_libreria', $this->nombre_libreria])
                ->andFilterWhere(['ilike', 'categoria.nombre', $this->idCategoria]);

        return $dataProvider;
    }

}
