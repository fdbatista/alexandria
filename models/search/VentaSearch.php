<?php

namespace app\models\search;

use app\models\Venta;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VentaSearch represents the model behind the search form about `app\models\Venta`.
 */
class VentaSearch extends Venta {

    public $idUsuario;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['id', 'id_usuario'], 'integer'],
                [['fecha', 'idUsuario'], 'safe'],
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
    public function search($id, $fecha, $params) {
        
        if($id == NULL){
            $query = Venta::find()->where(['fecha' => $fecha])->orderBy(['id' => SORT_DESC]);
        }else{
            $query = Venta::find()->where(['fecha' => $fecha])->andWhere(['id_usuario' => $id])->orderBy(['id' => SORT_DESC]);
        }
        

        // add conditions that should always apply here
        $query->joinWith(['idUsuario']);

        $dataProvider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 20],]);

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

        $query->andFilterWhere(['ilike', 'text(fecha)', $this->fecha])
                ->andFilterWhere(['ilike', 'usuario.nombre_completo', $this->idUsuario]);

        return $dataProvider;
    }
    
}
