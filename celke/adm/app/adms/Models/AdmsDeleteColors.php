<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsDeleteColors
 *
 * @author Celke
 */
class AdmsDeleteColors
{

    private bool $resultado;
    private int $id;
    private $resultadoBd;

    function getResultado(): bool {
        return $this->resultado;
    }
    
    public function deleteColors($id) {
        $this->id = (int) $id;

        if ($this->viewColors() AND $this->verSitUserCad()) {
            $deleteColors = new \App\adms\Models\helper\AdmsDelete();
            $deleteColors->exeDelete("adms_colors", "WHERE id =:id", "id={$this->id}");

            if ($deleteColors->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cor apagada com sucesso!</div>";
                $this->resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não apagada com sucesso!</div>";
                $this->resultado = false;
            }
        } else {
            $this->resultado = false;
        }
    }

    private function viewColors() {
        $viewColors = new \App\adms\Models\helper\AdmsRead();
        $viewColors->fullRead("SELECT id FROM adms_colors
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultadoBd = $viewColors->getResult();
        if ($this->resultadoBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
            return false;
        }
    }
    
    private function verSitUserCad() {
        $viewSitUserCad = new \App\adms\Models\helper\AdmsRead();
        $viewSitUserCad->fullRead("SELECT id FROM adms_sits_users WHERE adms_color_id=:adms_color_id LIMIT :limit", "adms_color_id={$this->id}&limit=1");
        if($viewSitUserCad->getResult()){
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: A cor não pode ser apagada, há situação de usuário cadastrado com essa cor!</div>";
            return false;
        }else{
            return true;
        }
    }

}
