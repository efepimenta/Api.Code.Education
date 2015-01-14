<?php
namespace Digital\Service\Validator;

use Digital\Entity\Categoria;
use Doctrine\ORM\EntityManager;
use Digital\Entity\Tag;

class TagValidator
{

    private $mensagemDeErro = "Informe o(s) seguinte(s) valores:";

    private $tag;

    private $id;

    private $erros;

    public function validar(EntityManager $em, $acao, $id = '', $tag = '')
    {
        $falta = '';
        $this->erros = false;
        switch ($acao) {
            case 'listar':
                {
                    if (empty($id)) {
                        $this->erros = true;
                        $falta = ' -> id ';
                    }
                    break;
                }
            case 'inserir':
                {
                    if (empty($tag)) {
                        $this->erros = true;
                        $falta = $falta . ' -> nome ';
                    }
                    break;
                }
            case 'atualizar':
                {
                    if (empty($id)) {
                        $this->erros = true;
                        $falta = ' -> id ';
                    }
                    if (empty($tag)) {
                        $this->erros = true;
                        $falta = $falta . ' -> nome ';
                    }
                    break;
                }
            case 'deletar':
                {
                    if (empty($id)) {
                        $this->erros = true;
                        $falta = ' -> id ';
                    }
                    break;
                }
            default:
                {
                    $this->mensagemDeErro = 'Ação não reconhecida';
                    $falta = '';
                    $this->erros = true;
                    break;
                }
        }
        
        if ($this->erros) {
            $this->mensagemDeErro = $this->mensagemDeErro . $falta;
            return false;
        }
        $this->mensagemDeErro = 'OK';
        
        if (($acao !== 'listar')) {
            $this->tag = new Tag();
            if ($acao !== 'inserir') {
                $this->tag->setId($id);
            }
            $this->tag->setTag($tag);
            if (! isset($this->tag)) {
                $this->mensagemDeErro = 'Tag não encontrada';
                return false;
            }
        }
        return true;
    }

    public function getTag()
    {
        if (! $this->erros) {
            return $this->tag;
        }
        return null;
    }

    public function mensagemDeErro()
    {
        return $this->mensagemDeErro;
    }
}



