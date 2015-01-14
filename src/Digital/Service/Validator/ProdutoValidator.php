<?php
namespace Digital\Service\Validator;

use Digital\Entity\Produto;
use Digital\Service\CategoriaService;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Digital\Service\TagService;

class ProdutoValidator
{

    private $mensagemDeErro = "Informe o(s) seguinte(s) valores:";

    private $produto;

    private $id;

    private $nome;

    private $descricao;

    private $categoria;

    private $tags;

    private $valor;

    private $erros;

    private $entra;

    public function validar(EntityManager $em, $acao, $id = '', $nome = '', $descricao = '', $categoria = '', $valor = '', $tags = '')
    {
        $falta = '';
        $this->erros = false;
        $this->entra = true;
        switch ($acao) {
            case 'listar':
                {
                    $this->entra = false;
                    if (empty($id)) {
                        $this->erros = true;
                        $falta = ' -> id ';
                    }
                    break;
                }
            case 'inserir':
                {
                    if (empty($nome)) {
                        $this->erros = true;
                        $falta = $falta . ' -> nome ';
                    }
                    if (empty($descricao)) {
                        $this->erros = true;
                        $falta = $falta . ' -> descricao ';
                    }
                    if (empty($categoria)) {
                        $this->erros = true;
                        $falta = $falta . ' -> categoria ';
                    }
                    if (empty($valor)) {
                        $this->erros = true;
                        $falta = $falta . ' -> valor ';
                    }
                    if (empty($tags)) {
                        $this->erros = true;
                        $falta = $falta . ' -> tags ';
                    }
                    break;
                }
            case 'atualizar':
                {
                    if (empty($id)) {
                        $this->erros = true;
                        $falta = ' -> id ';
                    }
                    if (empty($nome)) {
                        $this->erros = true;
                        $falta = $falta . ' -> nome ';
                    }
                    if (empty($descricao)) {
                        $this->erros = true;
                        $falta = $falta . ' -> descricao ';
                    }
                    if (empty($categoria)) {
                        $this->erros = true;
                        $falta = $falta . ' -> categoria ';
                    }
                    if (empty($valor)) {
                        $this->erros = true;
                        $falta = $falta . ' -> valor ';
                    }
                    if (empty($tags)) {
                        $this->erros = true;
                        $falta = $falta . ' -> tags ';
                    }
                    break;
                }
            case 'deletar':
                {
                    $this->entra = false;
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
                    $this->entra = false;
                    break;
                }
        }
        
        if ($this->entra) {
            if (empty($valor)){
                $valor = 0;
            }
            // remover todos os caracteres nao numericos de $valor
            if ( ! is_int($valor) ) {
                $valor = formatFloat($valor);
            } else {
                $valor = formatarValor($valor);
            }
            
            /* verifica se valor é mairo que 0 */
            if (($valor < 0)) {
                $this->mensagemDeErro = $falta . '-> Valor tem que ser maior que 0';
                $this->erros = true;
            }
            
            /* verifica se categoria é numerico */
            $ct = new CategoriaService();
            $cat = $ct->find($em, $categoria);
            if ($cat == NULL) {
                $cat = $ct->idPorDescricao($em, $categoria);
                if ($cat == NULL) {
                    $this->mensagemDeErro = $falta . '-> Categoria não encontrada';
                    $this->erros = true;
                }
            }
            /* verifica se as tags estao preenchidas */
            $tag = \explode(';', $tags);
            if ($tag == NULL) {
                $this->mensagemDeErro = $falta . '-> Nenhuma tag encontrada';
                $this->erros = true;
            }
            foreach ($tag as $t) {
                // se a tag nao existir eu tenho que adicionar no banco de tags e adiciono na lista
                if (! empty($t)) {
                    $ts = new TagService();
                    $tg = $ts->idPorTag($em, $t);
                    if (count($tg) == 0) {
                        $tagValid = new TagValidator();
                        $tagValid->validar($em, 'inserir', '', $t);
                        $tg = $tagValid->getTag();
                        $ts->persist($em, $tg);
                        $this->tags[] = $tg;
                    } else {
                        $this->tags[] = $tg[0];
                    }
                    // se existir eu adiciono na lista
                    
                } else {
                    $this->mensagemDeErro = $falta . '-> Erro ao informar as tags';
                    $this->erros = true;
                }
            }
        }
        
        if ($this->erros) {
            $this->mensagemDeErro = $this->mensagemDeErro . $falta;
            return false;
        }
        
        $this->mensagemDeErro = 'OK';
        
        if (($acao !== 'listar')) {
            $this->produto = new Produto();
            if ($acao !== 'inserir') {
                $this->produto->setId($id);
            }
            if ($this->entra) {
                $this->produto->setNome($nome);
                $this->produto->setDescricao($descricao);
                $this->produto->setIdCategoria($cat);
                $this->produto->setValor($valor);
                foreach ($this->tags as $tg) {
                    $this->produto->addTags($tg);
                }
            }
            if (! isset($this->produto)) {
                $this->mensagemDeErro = 'Produto não encontrado';
                return false;
            }
        }
        return true;
    }

    public function getProduto()
    {
        if (! $this->erros) {
            return $this->produto;
        }
        return null;
    }

    public function mensagemDeErro()
    {
        return $this->mensagemDeErro;
    }
}



