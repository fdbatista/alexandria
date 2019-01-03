<?php

namespace app\models\search;

use app\models\Deterioro;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DeterioroSearch represents the model behind the search form about `app\models\Deterioro`.
 */
class DeterioroSearch extends Deterioro {

    public $idProducto, $idUsuario;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'cantidad', 'id_producto', 'id_usuario'], 'integer'],
            [['fecha', 'idProducto', 'idUsuario'], 'safe'],
            [['importe_venta', 'importe_costo'], 'number'],
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
        $query = Deterioro::find()->orderBy(['fecha' => SORT_DESC]);

        // add conditions that should always apply here

        $query->joinWith(['idProducto']);
        $query->joinWith(['idUsuario']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idProducto'] = [
            'asc' => ['producto.titulo' => SORT_ASC],
            'desc' => ['producto.titulo' => SORT_DESC],
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
        $query->andFilterWhere(['ilike', 'producto.titulo', $this->idProducto])
                ->andFilterWhere(['like', 'usuario.nombre1', $this->idUsuario])
                ->andFilterWhere(['ilike', 'text(fecha)', $this->fecha]);

        return $dataProvider;
    }

    public function datosXId($id, $params) {
        $query = Deterioro::find()->where(['id_usuario' => $id])->orderBy(['fecha' => SORT_DESC]);

        // add conditions that should always apply here

        $query->joinWith(['idProducto']);
        $query->joinWith(['idUsuario']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idProducto'] = [
            'asc' => ['producto.titulo' => SORT_ASC],
            'desc' => ['producto.titulo' => SORT_DESC],
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
        $query->andFilterWhere(['ilike', 'producto.titulo', $this->idProducto])
                ->andFilterWhere(['like', 'usuario.nombre1', $this->idUsuario])
                ->andFilterWhere(['ilike', 'text(fecha)', $this->fecha]);

        return $dataProvider;
    }

}
