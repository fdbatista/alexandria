<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * @property Usuario $usuario
 */

class MiPerfil extends Model
{
    public $contrasenhaActual;
    public $contrasenhaNueva;
    public $contrasenhaConfirmacion;
    
    public function attributeLabels()
    {
        return [
            'contrasenhaActual' => 'Contraseña actual',
            'contrasenhaNueva' => 'Nueva contraseña',
            'contrasenhaConfirmacion' => 'Confirmación',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contrasenhaActual', 'contrasenhaNueva', 'contrasenhaConfirmacion'], 'required'],
            ['contrasenhaConfirmacion', 'compare', 'compareAttribute' => 'contrasenhaNueva', 'message' => 'La nueva contraseña y la confirmación no coinciden'],
            ['contrasenhaActual', 'validarContrasenhaActual'],
        ];
    }
    
    public function validarContrasenhaActual($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!Yii::$app->security->validatePassword($this->contrasenhaActual, $this->usuario->contrasenha)) {
                $this->addError($attribute, 'La contraseña actual no es correcta.');
            }
        }
    }
    
    public function getUsuario() {
        return $this->usuario;
    }
    
    public function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
    }

}
