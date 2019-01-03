<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Traza;

/**
 * TrazaSearch represents the model behind the search form about `app\models\Traza`.
 */
class TrazaSearch extends Traza {

    public $idUsuario;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['id', 'id_usuario', 'id_objeto'], 'integer'],
                [['fecha_hora', 'tipo_objeto', 'idUsuario', 'descripcion', 'accion'], 'safe'],
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
        $query = Traza::find()->orderBy(['fecha_hora' => SORT_DESC]);;

        // add conditions that should always apply here
        $query->joinWith(['idUsuario']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idUsuario'] = [
            'asc' => ['usuario.nombre_usuario' => SORT_ASC],
            'desc' => ['usuario.nombre_usuario' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_usuario' => $this->id_usuario,
            'fecha_hora' => $this->fecha_hora,
            'id_objeto' => $this->id_objeto,
        ]);

        $query->andFilterWhere(['like', 'tipo_objeto', $this->tipo_objeto])
                ->andFilterWhere(['like', 'descripcion', $this->descripcion])
                ->andFilterWhere(['like', 'accion', $this->accion])
                ->andFilterWhere(['ilike', 'usuario.nombre_usuario', $this->idUsuario]);

        return $dataProvider;
    }

}
