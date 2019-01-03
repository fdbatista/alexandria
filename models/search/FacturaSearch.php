<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Factura;

/**
 * FacturaSearch represents the model behind the search form about `app\models\Factura`.
 */
class FacturaSearch extends Factura {
    
    public $idDevolucion;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'numero', 'id_suministrador', 'id_devolucion'], 'integer'],
            [['fecha', 'idDevolucion'], 'safe'],
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
        $query = Factura::find();

        // add conditions that should always apply here
        
        $query->joinWith(['idDevolucion']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);
        
        $dataProvider->sort->attributes['idDevolucion'] = [
            'asc' => ['devolucion.numero' => SORT_ASC],
            'desc' => ['devolucion.numero' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        
        $query->andFilterWhere(['ilike', 'text(factura.numero)', $this->numero])
                ->andFilterWhere(['ilike', 'text(factura.fecha)', $this->fecha])
                ->andFilterWhere(['ilike', 'text(devolucion.numero)', $this->idDevolucion]);

        return $dataProvider;
    }
}
