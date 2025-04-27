<?php

namespace App\adms\Models;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsViewColors
 *
 * @author Celke
 */
class AdmsViewColors
{
    private $resultadoBd;
    private bool $resultado;
    private int $id;

    function getResultado(): bool {
        return $this->resultado;
    }
    
    function getResultadoBd() {
        return $this->resultadoBd;
    }

    public function viewColors($id) {
        $this->id = (int) $id;
        $viewColors = new \App\adms\Models\helper\AdmsRead();
        $viewColors->fullRead("SELECT id, name, color
                FROM adms_colors 
                WHERE id=:id
                LIMIT :limit", "id={$this->id}&limit=1");
                
        $this->resultadoBd = $viewColors->getResult();
        if($this->resultadoBd){
            $this->resultado = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
            $this->resultado = false;
        }
    }

}
