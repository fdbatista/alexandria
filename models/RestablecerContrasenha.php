<?php

namespace app\models;

use yii\base\Model;

class RestablecerContrasenha extends Model {

    public $email;
    public $password;
    public $password_repeat;
    public $verification_code;
    public $recover;

    public function rules() {
        return [
            [['email', 'password', 'password_repeat', 'verification_code', 'recover'], 'required', 'message' => 'Este campo es obligatorio'],
            ['email', 'match', 'pattern' => '/^.{5,80}$/', 'message' => 'Mínimo 5 caracteres y máximo 80'],
            //['email', 'email', 'message' => 'Formato no valido'],
            ['password', 'match', 'pattern' => '/^{7,20}$/', 'message' => 'Mínimo 7 caracteres y máximo 20'],
            ['password_repeat', 'compare', 'compareAtribute' => 'password', 'message' => 'Las contraseñas deben coincidir'],
        ];
    }
    
        /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email' => 'Email',
            'password' => 'Nueva contraseña',
            'password_repeat' => 'Confirmar contraseña',
            'verification_code' => 'Código de verificación',
        ];
    }

}
