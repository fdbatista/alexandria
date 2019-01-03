<?php

namespace app\models\search;

use app\models\Usuario;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UsuarioSearch represents the model behind the search form about `app\models\Usuario`.
 */
class UsuarioSearch extends Usuario {

    public $idRol;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [[/* 'nombre1', 'nombre2', 'apellido1', 'apellido2', */'nombre_completo', 'nombre_usuario', 'contrasenha', 'idRol', 'email'], 'safe'],
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
        $query = Usuario::find()->orderBy(['nombre1' => SORT_ASC]);

        // add conditions that should always apply here

        $query->joinWith(['idRol']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 20],
        ]);

        $dataProvider->sort->attributes['idRol'] = [
            'asc' => ['rol.nombre' => SORT_ASC],
            'desc' => ['rol.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        $query->andFilterWhere(['ilike', 'nombre_completo', $this->nombre_completo])
//            ->andFilterWhere(['ilike', 'nombre2', $this->nombre2])
//            ->andFilterWhere(['ilike', 'apellido1', $this->apellido1])
//            ->andFilterWhere(['ilike', 'apellido2', $this->apellido2])
              ->andFilterWhere(['ilike', 'nombre_usuario', $this->nombre_usuario])
//            ->andFilterWhere(['ilike', 'habilitado_sala_comercial', $this->habilitado_sala_comercial])
              ->andFilterWhere(['ilike', 'activo', $this->activo])
              ->andFilterWhere(['ilike', 'email', $this->email])
              ->andFilterWhere(['ilike', 'rol.nombre', $this->idRol]);

        return $dataProvider;
    }

}
