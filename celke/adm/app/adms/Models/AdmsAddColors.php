<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsAddColors
 *
 * @author Celke
 */
class AdmsAddColors
{

    private array $dados;
    private bool $resultado;

    function getResultado() {
        return $this->resultado;
    }

    public function create(array $dados = null) {
        $this->dados = $dados;
        $valCampoVazio = new \App\adms\Models\helper\AdmsValCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResultado()) {
            $this->add();
        } else {
            $this->resultado = false;
        }
    }

    private function add() {
        $this->dados['created'] = date("Y-m-d H:i:s");
        
        $createColor = new \App\adms\Models\helper\AdmsCreate();
        $createColor->exeCreate("adms_colors", $this->dados);

        if ($createColor->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cor cadastrada com sucesso!</div>";
            $this->resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não cadastrada com sucesso. Tente mais tarde!</div>";
            $this->resultado = false;
        }
    }

}
