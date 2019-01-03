<?php

namespace app\models\search;

use app\models\Autor;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AutorSearch represents the model behind the search form about `app\models\Autor`.
 */
class AutorSearch extends Autor {

    public $idPais;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'id_pais'], 'integer'],
            [[/* 'nombre1', 'nombre2', 'apellido1', 'apellido2' */'nombre_completo', 'sexo', 'idPais'], 'safe'],
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
        $query = Autor::find();

        // add conditions that should always apply here

        $query->joinWith(['idPais']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idPais'] = [
            'asc' => ['pais.nombre' => SORT_ASC],
            'desc' => ['pais.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->sexo != null) {
            $sexo_minusc = strtolower($this->sexo);
            if (strpos('femenino', $sexo_minusc) >= 0)
                $sexo_search = 'f';
            else if (strpos('masculino', $sexo_minusc) >= 0)
                $sexo_search = 'm';
            else
                $sexo_search = $sexo_minusc;
        } else
            $sexo_search = null;

        // grid filtering conditions

        $query->andFilterWhere(['ilike', 'nombre_completo', $this->nombre_completo])
//                ->andFilterWhere(['ilike', 'nombre2', $this->nombre2])
//                ->andFilterWhere(['ilike', 'apellido1', $this->apellido1])
//                ->andFilterWhere(['ilike', 'apellido2', $this->apellido2])
                ->andFilterWhere(['ilike', 'sexo', $this->sexo])
                ->andFilterWhere(['ilike', 'pais.nombre', $this->idPais]);

        return $dataProvider;
    }

}
