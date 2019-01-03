<?php

namespace app\models\search;

use app\models\Coleccion;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ColeccionSearch represents the model behind the search form about `app\models\Coleccion`.
 */
class ColeccionSearch extends Coleccion {

    public $idEditorial;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'id_editorial'], 'integer'],
            [['nombre', 'idEditorial'], 'safe'],
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
        $query = Coleccion::find();

        // add conditions that should always apply here

        $query->joinWith(['idEditorial']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idEditorial'] = [
            'asc' => ['editorial.nombre' => SORT_ASC],
            'desc' => ['editorial.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['ilike', 'coleccion.nombre', $this->nombre]);
        $query->andFilterWhere(['ilike', 'editorial.nombre', $this->idEditorial]);

        return $dataProvider;
    }

}
