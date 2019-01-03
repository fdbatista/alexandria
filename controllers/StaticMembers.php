<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\Traza;
use Exception;
use Yii;
use yii\base\Model;

/**
 * Description of Static
 *
 */
class StaticMembers {

    public static function MostrarMensajes() {
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . ' fade in">' . $message . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>';
        }
    }

    public static function CargarNomenclador($nombre) {
        try {
            $elems = \Yii::$app->db->createCommand("select nombre from $nombre")->queryAll();
            $res = [];
            foreach ($elems as $elem) {
                $res[] = $elem['nombre'];
            }
            return json_encode($res);
        } catch (Exception $exc) {
            return json_encode([]);
        }
    }

    public static function CargarProductos() {
        try {
            $elems = \Yii::$app->db->createCommand("select titulo from producto")->queryAll();
            $res = [];
            foreach ($elems as $elem) {
                $res[] = $elem['nombre'];
            }
            return json_encode($res);
        } catch (Exception $exc) {
            return json_encode([]);
        }
    }

    public static function EliminarMensajes() {
        Yii::$app->session->removeAllFlashes();
    }

    public static function TienePermiso($controlador, $accion) {
        $ruta = $controlador . '/' . ($accion === 'guardar' ? 'crear' : $accion);
        return ($ruta === 'sitio/inicio/inicio' || $ruta === 'sitio/producto/detalles') ? true : static::TienePermisoRuta($ruta);
    }

    public static function GetDatosUsuario() {
        $modulos = [];
        $rutas = [];
        if (!Yii::$app->user->isGuest) {
            $permisos = Yii::$app->db->createCommand("select v.modulo_html, v.ruta from v_permiso v where id in (select id_permiso from rol_permiso where id_rol = :id_rol)")->bindValues([':id_rol' => Yii::$app->user->identity->id_rol])->queryAll();
            $modulos = [];
            $rutas = [];
            foreach ($permisos as $permiso) {
                $rutas[$permiso['ruta']] = 1;
                if (!in_array($permiso['modulo_html'], $modulos)) {
                    $modulos[$permiso['modulo_html']] = 1;
                }
            }
        }
        return ['modulos' => $modulos, 'rutas' => $rutas];
    }

    public static function TienePermisoRuta($ruta) {
        $datos_usuario = StaticMembers::GetDatosUsuario();
        return ($datos_usuario['rutas']) ? array_key_exists($ruta, $datos_usuario['rutas']) : false;
    }

    public static function AccesoAModulo($modulo_html) {
        $datos_usuario = StaticMembers::GetDatosUsuario();
        return ($datos_usuario['modulos']) ? array_key_exists($modulo_html, $datos_usuario['modulos']) : false;
    }

    public static function RegistrarTraza(Model $model, $atributos_viejos, $accion, $identificador, $descripcion_adic = '') {
        $traza = new Traza();
        $traza->id_usuario = Yii::$app->user->identity->id;
        $traza->tipo_objeto = str_replace('app\models\\', '', $model->className());
        $traza->id_objeto = $model->id;
        $tipoLabel = '';
        if ($accion == 'crear') {
            $tipoLabel = 'success';
        } elseif ($accion == 'actualizar') {
            $tipoLabel = 'warning';
        } elseif ($accion == 'eliminar') {
            $tipoLabel = 'danger';
        } elseif ($accion == 'ejecutar') {
            $tipoLabel = 'danger';
        } else {
            $tipoLabel = 'primary';
        }
        
        $accion_participio = str_replace('ar', 'ado', $accion);
        $descrip_no_eliminados = $accion === 'eliminar' ? "." : " con la información siguiente: ";

        $descripcion = "El objeto <b>$identificador</b>, de tipo $traza->tipo_objeto, fue $accion_participio$descrip_no_eliminados";
        $cantCambios = 0;
        foreach ($model->attributes as $key => $value) {
            if ($value != $atributos_viejos[$key] && $key != 'id') {
                $cantCambios++;
                $valorViejo = $atributos_viejos[$key];
                $valorNuevo = $value;
                if (strstr($key, 'id_')) {
                    $nombreTabla = str_replace('id_', '', $key);
                    if ($key === 'id_usuario') {
                        $columna = "concat(nombre1, ' ', apellido1)";
                    } else if ($key === 'id_producto') {
                        $columna = "titulo";
                    } else if ($key === 'id_devolucion') {
                        $columna = "numero";
                    } else if ($key === 'id_efect_entr') {
                        $nombreTabla = 'efectivo_entrega';
                        $columna = "nombre";
                    } else {
                        $columna = "nombre";
                    }
                    /* $query = Yii::$app->db->createCommand("select nombre from $nombreTabla where id = :id");
                      $query->bindValue(':id', $valorViejo);
                      $valorViejo = $query->queryScalar();

                      $query = Yii::$app->db->createCommand("select nombre from $nombreTabla where id = :id");
                      $query->bindValue(':id', $valorNuevo);
                      $valorNuevo = $query->queryScalar(); */
                    $res = Yii::$app->db->createCommand("select coalesce((select text($columna) from $nombreTabla where id = :id_viejo), '') nombre union all select coalesce((select text($columna) from $nombreTabla where id = :id_nuevo), '') nombre")->bindValues([':id_viejo' => $valorViejo ? $valorViejo : -1, ':id_nuevo' => $valorNuevo ? $valorNuevo : -1])->queryAll();
                    $valorViejo = $res[0]['nombre'];
                    $valorNuevo = $res[1]['nombre'];
                }
                $valorViejo = !$valorViejo ? '<i class="fa fa-times" style="color: #d9534f;"></i>' : $valorViejo;
                $valorNuevo = !$valorNuevo ? '<i class="fa fa-times" style="color: #d9534f;"></i>' : $valorNuevo;
                $nombreAtrib = strtoupper(str_replace('id_', '', $key));
                $descripcion .= ($key === 'contrasenha') ? ($nombreAtrib . ', ') : ($nombreAtrib . ' (dato anterior: ' . $valorViejo . ', dato nuevo: ' . $valorNuevo . '), ');
            }
        }
        if ($cantCambios > 0 || $accion == 'eliminar') {
            $traza->descripcion = trim($descripcion . $descripcion_adic, ', ');
            $traza->accion = "<span class='label label-$tipoLabel'>" . $accion . "</span> ";
            $traza->save();
        }
    }

}
