<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RebajaPrecio;

/**
 * RebajaPrecioSearch represents the model behind the search form about `app\models\RebajaPrecio`.
 */
class RebajaPrecioSearch extends RebajaPrecio {
    
    public $idProducto;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_producto'], 'integer'],
            [['fecha', 'idProducto', 'precio_anterior', 'precio_nuevo'], 'safe'],
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
        $query = RebajaPrecio::find()->orderBy(['fecha' => SORT_DESC]);;

        // add conditions that should always apply here
        
        $query->joinWith(['idProducto']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);
        
        $dataProvider->sort->attributes['idProducto'] = [
            'asc' => ['producto.titulo' => SORT_ASC],
            'desc' => ['producto.titulo' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        
        $query->andFilterWhere(['ilike', 'text(precio_anterior)', $this->precio_anterior])
                ->andFilterWhere(['ilike', 'text(precio_nuevo)', $this->precio_nuevo])
                ->andFilterWhere(['ilike', 'text(fecha)', $this->fecha])
                ->andFilterWhere(['ilike', 'producto.titulo', $this->idProducto]);

        return $dataProvider;
    }
}
