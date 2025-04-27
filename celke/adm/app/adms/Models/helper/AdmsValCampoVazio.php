<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsValCampoVazio
 *
 * @author Celke
 */
class AdmsValCampoVazio
{
    
    private array $dados;
    private bool $resultado;

    function getResultado(): bool {
        return $this->resultado;
    }
    
    public function validarDados(array $dados) {
        $this->dados = $dados;
        $this->dados = array_map('strip_tags', $this->dados);
        $this->dados = array_map('trim', $this->dados);
        
        if(in_array('', $this->dados)){
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            $this->resultado = false;
        }else{
            $this->resultado = true;
        }
    }
}
