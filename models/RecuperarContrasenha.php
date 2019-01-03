<?php

namespace app\models;

use yii\base\Model;

class RecuperarContrasenha extends Model {

    public $email;

    public function rules() {
        return [
            ['email', 'required', 'message' => 'Este campo es obligatorio.'],
            ['email', 'email', 'message' => 'Escriba una dirección de correo válida.'],
            ['email', 'string', 'max' => 80, 'min' => 5, 'tooShort' => 'Debe tener entre 5 y 80 caracteres.'],
            //['email', 'match', 'pattern' => '/^.{5,80}$/', 'message' => 'Debe tener entre 5 y 80 caracteres.'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Correo electrónico',
        ];
    }

}
