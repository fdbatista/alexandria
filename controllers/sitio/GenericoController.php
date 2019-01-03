<?php

namespace app\controllers\sitio;

use app\controllers\StaticMembers;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Description of GenericoController
 *
 */
class GenericoController extends Controller {

    public $layout = 'main';
    public $defaultAction = 'inicio';
    
    public function actions() {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'guardar' => ['POST'],
                    'salir' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['acerca-de', 'autenticar', 'error', 'recuperar-contrasenha', 'restablecer-contrasenha'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['mi-perfil', 'salir', 'exportar-listado', 'desglose'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['inicio', 'detalles', 'crear', 'actualizar', 'eliminar', 'guardar', 'ejecutar'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return StaticMembers::TienePermiso($action->controller->id, $action->controller->action->id);
                        },
                    ],
                ],
            ],
        ];
    }

}
