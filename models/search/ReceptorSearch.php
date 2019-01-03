<?php

namespace app\models\search;

use app\models\Receptor;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ReceptorSearch represents the model behind the search form about `app\models\Receptor`.
 */
class ReceptorSearch extends Receptor {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['nombre', 'codigo', 'codigo_nit', 'cuenta_bancaria', 'agencia', 'direccion'], 'safe'],
//            [['descuento_comercial'], 'number'],
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
        $query = Receptor::find();

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

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
                ->andFilterWhere(['ilike', 'codigo', $this->codigo])
                ->andFilterWhere(['ilike', 'codigo_nit', $this->codigo_nit])
                ->andFilterWhere(['ilike', 'cuenta_bancaria', $this->cuenta_bancaria])
                ->andFilterWhere(['ilike', 'agencia', $this->agencia])
                ->andFilterWhere(['ilike', 'direccion', $this->direccion]);

        return $dataProvider;
    }

}
