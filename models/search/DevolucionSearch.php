<?php

namespace app\models\search;

use app\models\Devolucion;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DevolucionSearch represents the model behind the search form about `app\models\Devolucion`.
 */
class DevolucionSearch extends Devolucion {

    public $idEfectEntr, $idUsuario;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'numero', 'id_efect_entr', 'id_usuario'], 'integer'],
            [['fecha', 'idEfectEntr', 'idUsuario'], 'safe'],
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
        $query = Devolucion::find()->orderBy(['fecha' => SORT_DESC]);

        //$query = Devolucion::find();
        // add conditions that should always apply here
        $query->joinWith(['idEfectEntr']);
        $query->joinWith(['idUsuario']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idEfectEntr'] = [
            'asc' => ['efect_entr.nombre' => SORT_ASC],
            'desc' => ['efect_entr.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['idUsuario'] = [
            'asc' => ['usuario.nombre1' => SORT_ASC],
            'desc' => ['usuario.nombre1' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['like', 'text(numero)', $this->numero])
                ->andFilterWhere(['ilike', 'text(fecha)', $this->fecha])
                ->andFilterWhere(['ilike', 'efectivo_entrega.nombre', $this->idEfectEntr])
                ->andFilterWhere(['like', 'usuario.nombre1', $this->idUsuario]);

        return $dataProvider;
    }

    public function datosXId($id, $params) {
        $query = Devolucion::find()->where(['id_usuario' => $id])->orderBy(['fecha' => SORT_DESC]);

        // add conditions that should always apply here
        $query->joinWith(['idEfectEntr']);
        $query->joinWith(['idUsuario']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idEfectEntr'] = [
            'asc' => ['efect_entr.nombre' => SORT_ASC],
            'desc' => ['efect_entr.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['idUsuario'] = [
            'asc' => ['usuario.nombre1' => SORT_ASC],
            'desc' => ['usuario.nombre1' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['like', 'text(numero)', $this->numero])
                ->andFilterWhere(['ilike', 'text(fecha)', $this->fecha])
                ->andFilterWhere(['ilike', 'efectivo_entrega.nombre', $this->idEfectEntr])
                ->andFilterWhere(['like', 'usuario.nombre1', $this->idUsuario]);

        return $dataProvider;
    }

}
