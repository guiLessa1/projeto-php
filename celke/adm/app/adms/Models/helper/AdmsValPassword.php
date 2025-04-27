<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsValPassword
 *
 * @author Celke
 */
class AdmsValPassword
{

    private string $password;
    private bool $resultado;

    function getResultado(): bool {
        return $this->resultado;
    }

    public function validarPassword($password) {
        $this->password = (string) $password;

        if (stristr($this->password, "'")) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado na senha inválido!</div>";
            $this->resultado = false;
        } else {
            if (stristr($this->password, " ")) {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no campo senha!</div>";
                $this->resultado = false;
            } else {
                $this->valExtensPassword();
            }
        }
    }

    private function valExtensPassword() {
        if ((strlen($this->password) < 6)) {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter no mínimo 6 caracteres!</div>";
            $this->resultado = false;
        } else {
            $this->valValuePassword();
        }
    }

    private function valValuePassword() {
        if (preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]{6,}$/', $this->password)) {
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter letras e números!</div>";
            $this->resultado = false;
        }
    }

}
