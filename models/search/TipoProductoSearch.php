<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TipoProducto;

/**
 * TipoProductoSearch represents the model behind the search form about `app\models\TipoProducto`.
 */
class TipoProductoSearch extends TipoProducto {
    
    public $idCuenta;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cuenta'], 'integer'],
            [['nombre', 'idCuenta'], 'safe'],
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
        $query = TipoProducto::find();

        // add conditions that should always apply here
         $query->joinWith(['idCuenta']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

         $dataProvider->sort->attributes['idCuenta'] = [
            'asc' => ['cuenta.nombre' => SORT_ASC],
            'desc' => ['cuenta.nombre' => SORT_DESC],
        ];
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['ilike', 'tipo_producto.nombre', $this->nombre])
                ->andFilterWhere(['ilike', 'cuenta.nombre', $this->idCuenta]);

        return $dataProvider;
    }
}
