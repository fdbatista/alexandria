<?php

namespace app\models;

class HtmlHelpers {

    public static function dropDownList($model, $parent_model_id, $id, $value, $string) {
        $rows = $model::find()->where([$parent_model_id => $id])->all();
        $droptions = "<option>Seleccione...</option>";
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $droptions .= '<option value=' . $row->$value . '>' . $row->$string . '</option>';
            }
        } else {
            $droptions .= "<option>No hay resultados</option>";
        }
        return $droptions;
    }
    
    public static function dropDownListByRows($rows, $value, $string) {
        $droptions = "<option>Seleccione...</option>";
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $droptions .= '<option value=' . $row->$value . '>' . $row->$string . '</option>';
            }
        } else {
            $droptions .= "<option>No hay resultados</option>";
        }
        return $droptions;
    }
    
    public static function dropDownListFull($model, $value, $string) {
        $rows = $model::find()->all();
        $droptions = "<option>Seleccione...</option>";
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $droptions .= '<option value=' . $row->$value . '>' . $row->$string . '</option>';
            }
        } else {
            $droptions .= "<option>No hay resultados</option>";
        }
        return $droptions;
    }

}
