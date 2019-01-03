<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Municipio;

/**
 * MunicipioSearch represents the model behind the search form about `app\models\Municipio`.
 */
class MunicipioSearch extends Municipio { 
    
    public $idProvincia;
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_provincia'], 'integer'],
            [['nombre', 'idProvincia'], 'safe'],
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
        $query = Municipio::find();

        // add conditions that should always apply here
        $query->joinWith(['idProvincia']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);
           
        $dataProvider->sort->attributes['idProvincia'] = [
            'asc' => ['provincia.nombre' => SORT_ASC],
            'desc' => ['provincia.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['ilike', 'municipio.nombre', $this->nombre])
                ->andFilterWhere(['ilike', 'provincia.nombre', $this->idProvincia]);

        return $dataProvider;
    }
}
