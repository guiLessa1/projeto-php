<?php

namespace App\adms\Models\helper;

if(!defined('R4F5CC')){
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Description of AdmsSlug
 *
 * @author Celke
 */
class AdmsSlug
{

    private string $nome;
    private array $formato;

    public function slug($nome) {
        $this->nome = (string) $nome;

        $this->formato['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
        $this->formato['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
        $this->nome = strtr(utf8_decode($this->nome), utf8_decode($this->formato['a']), $this->formato['b']);
        $this->nome = str_replace(" ", "-", $this->nome);
        $this->nome = str_replace(array('-----', '----', '---', '--'), '-', $this->nome);
        $this->nome = strtolower($this->nome);

        return $this->nome;
    }

}
