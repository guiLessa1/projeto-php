<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsValExtImg
 *
 * @author Celke
 */
class AdmsValExtImg
{

    private string $mimeType;
    private bool $resultado;

    function getResultado(): bool {
        return $this->resultado;
    }

    public function valExtImg($mimeType) {
        $this->mimeType = $mimeType;
        switch ($this->mimeType):
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->resultado = true;
                break;
            case 'image/png':
            case 'image/x-png':
                $this->resultado = true;
                break;
            default:
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar imagem JPEG ou PNG!</div>";
                $this->resultado = false;
        endswitch;
    }

}
