<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsValEmail
 *
 * @author Celke
 */
class AdmsValEmail
{
    
    private string $email;
    private bool $resultado;

    function getResultado(): bool {
        return $this->resultado;
    }
    
    public function validarEmail($email) {
        $this->email = $email;
        
        if(filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail inválido!</div>";
            $this->resultado = false;            
        }
    }
}
