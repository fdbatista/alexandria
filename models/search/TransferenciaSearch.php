<?php

namespace app\models\search;

use app\models\Transferencia;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TransferenciaSearch represents the model behind the search form about `app\models\Transferencia`.
 */
class TransferenciaSearch extends Transferencia {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'numero', 'id_almacen'], 'integer'],
            [['fecha'], 'safe'],
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
        $query = Transferencia::find()->orderBy(['fecha' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions


        $query->andFilterWhere(['ilike', 'text(numero)', $this->numero])
                ->andFilterWhere(['ilike', 'text(fecha)', $this->fecha]);

        return $dataProvider;
    }

}
