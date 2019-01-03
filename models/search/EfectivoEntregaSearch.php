<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EfectivoEntrega;

/**
 * EfectivoEntregaSearch represents the model behind the search form about `app\models\EfectivoEntrega`.
 */
class EfectivoEntregaSearch extends EfectivoEntrega {
    
    public $idReceptor;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_receptor'], 'integer'],
            [['nombre', 'idReceptor'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = EfectivoEntrega::find();

        // add conditions that should always apply here
        
        $query->joinWith(['idReceptor']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);
        
        $dataProvider->sort->attributes['idReceptor'] = [
            'asc' => ['receptor.nombre' => SORT_ASC],
            'desc' => ['receptor.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['ilike', 'efectivo_entrega.nombre', $this->nombre])
                ->andFilterWhere(['ilike', 'receptor.nombre', $this->idReceptor]);

        return $dataProvider;
    }
}
