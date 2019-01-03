<?php

namespace app\controllers\administracion;

use app\controllers\StaticMembers;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Description of GenericoController
 *
 */
class GenericoAdminController extends Controller {

    public $layout = 'admin';
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
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow' => true,
                        'actions' => ['error'],
                    ],
                        [
                        'allow' => true,
                        'actions' => ['mi-perfil', 'exportar-listado', 'exportar-documento', 'acerca-de'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $controlador = $action->controller->id;
                            $accion = $action->controller->action->id;
                            if ($controlador . '/' . $accion === 'administracion/inicio/inicio') {
                                return Yii::$app->user->identity->esAdmin() ? true : $this->redirect(['/sitio/inicio']);
                            }
                            return StaticMembers::TienePermiso($controlador, $accion);
                        },
                        'denyCallback' => function ($rule, $action) {
                            $this->redirect(['administracion/index']);
                        }
                    ],
                ],
            ],
        ];
    }

}
