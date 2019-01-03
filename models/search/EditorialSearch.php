<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Editorial;

/**
 * EditorialSearch represents the model behind the search form about `app\models\Editorial`.
 */
class EditorialSearch extends Editorial {
    
    public $idAsociacion;
    public $idPais;
    public $idProvincia;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_asociacion', 'id_pais', 'id_provincia'], 'integer'],
            [['nombre', 'direccion', 'idAsociacion', 'idPais', 'idProvincia'], 'safe'],
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
        $query = Editorial::find();
        // add conditions that should always apply here
        
        $query->joinWith(['idAsociacion']);
        $query->joinWith(['idPais']);
        $query->joinWith(['idProvincia']);        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);
        
        $dataProvider->sort->attributes['idAsociacion'] = [
            'asc' => ['asociacion.nombre' => SORT_ASC],
            'desc' => ['asociacion.nombre' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['idPais'] = [
            'asc' => ['pais.nombre' => SORT_ASC],
            'desc' => ['pais.nombre' => SORT_DESC],
        ];
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

        $query->andFilterWhere(['ilike', 'editorial.nombre', $this->nombre])
                ->andFilterWhere(['ilike', 'direccion', $this->direccion])
                ->andFilterWhere(['ilike', 'asociacion.nombre', $this->idAsociacion])
                ->andFilterWhere(['ilike', 'pais.nombre', $this->idPais])
                ->andFilterWhere(['ilike', 'provincia.nombre', $this->idProvincia]);

        return $dataProvider;
    }
}
