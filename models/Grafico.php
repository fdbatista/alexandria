<?php
namespace app\models;

use yii\base\Model;

class Grafico extends Model
{
    public $id_tipo_grafico, $id_tipo_reporte, $fecha_inicial, $fecha_final, $generado;
    
    public function attributeLabels()
    {
        return [
            'id_tipo_grafico' => 'Tipo de gráfico',
            'id_tipo_reporte' => 'Tipo de reporte',
            'fecha_inicial' => 'Fecha inicial',
            'fecha_final' => 'Fecha final',
        ];
    }

    public function rules()
    {
        return [
            [['id_tipo_grafico', 'id_tipo_reporte', 'fecha_inicial'], 'required'],
            ['fecha_final', 'compare', 'compareAttribute' => 'fecha_inicial', 'type' => 'date', 'operator' => '>=', 'message' => 'La fecha final debe ser mayor o igual que la inicial'],
        ];
    }
    
    public function getTipoReporte()
    {
        return ($this->id_tipo_reporte) ? TipoReporte::findOne($this->id_tipo_reporte)->nombre : '';
    }

}
