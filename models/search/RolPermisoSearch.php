<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RolPermiso;

/**
 * RolPermisoSearch represents the model behind the search form about `app\models\RolPermiso`.
 */
class RolPermisoSearch extends RolPermiso {

    public $idPermiso;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['id', 'id_rol',], 'integer'],
                [['id', 'id_rol', 'id_permiso', 'idPermiso'], 'safe'],
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
        $query = RolPermiso::find();

        $query->joinWith(['idPermiso']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => ['pageSize' => 10],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['ilike', "concat(permiso.entidad_html, permiso.nombre)", $this->idPermiso]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_rol' => $this->id_rol,
            'id_permiso' => $this->id_permiso,
        ]);

        $dataProvider->sort->attributes['idPermiso'] = [
            'asc' => ['permiso.entidad_html' => SORT_ASC],
            'desc' => ['permiso.entidad_html' => SORT_DESC],
        ];

        return $dataProvider;
    }

}
