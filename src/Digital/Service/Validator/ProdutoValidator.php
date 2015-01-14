<?php
namespace Digital\Service\Validator;

use Digital\Entity\Produto;
use Digital\Service\CategoriaService;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Digital\Service\TagService;

class ProdutoValidator
{

    private $mensagemDeErro;

    private $produto;

    private $id;

    private $nome;

    private $descricao;

    private $categoria;

    private $tags;

    private $valor;

    private $imagem;

    private $erros;

    private $entra;

    public function __construct()
    {
        $this->mensagemDeErro[] = "Informe o(s) seguinte(s) valores:<br>";
    }

    public function validar(EntityManager $em, $acao, $id = '', $nome = '', $descricao = '', $categoria = '', $valor = '', $imagem = '', $tags = '')
    {
        $this->erros = false;
        $this->entra = true;
        switch ($acao) {
            case 'listar':
                {
                    $this->entra = false;
                    if (empty($id)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'id<br>';
                    }
                    break;
                }
            case 'inserir':
                {
                    if (empty($nome)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'nome<br>';
                    }
                    if (empty($descricao)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'descrição<br>';
                    }
                    if (empty($categoria)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'categoria<br>';
                    }
                    if (empty($valor)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'valor<br>';
                    }
//                     if (empty($imagem)) {
//                         $this->erros = true;
//                         $this->mensagemDeErro[] = 'imagem<br>';
//                     }
                    if (empty($tags)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'tags<br>';
                    }
                    break;
                }
            case 'atualizar':
                {
                    if (empty($id)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'id<br>';
                    }
                    if (empty($nome)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'nome<br>';
                    }
                    if (empty($descricao)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'descrição<br>';
                    }
                    if (empty($categoria)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'categoria<br>';
                    }
                    if (empty($valor)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'valor<br>';
                    }
//                     if (empty($imagem)) {
//                         $this->erros = true;
//                         $this->erros = true;
//                         $this->mensagemDeErro[] = 'imagem<br>';
//                     }
                    if (empty($tags)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'tags<br>';
                    }
                    break;
                }
            case 'deletar':
                {
                    $this->entra = false;
                    if (empty($id)) {
                        $this->erros = true;
                        $this->mensagemDeErro[] = 'id<br>';
                    }
                    break;
                }
            default:
                {
                    $this->mensagemDeErro[] = 'Ação não reconhecida';
                    $this->erros = true;
                    $this->entra = false;
                    break;
                }
        }
        
        if ($this->entra) {
            if (empty($valor)) {
                $valor = 0;
            }
            // remover todos os caracteres nao numericos de $valor
            if (! is_int($valor)) {
                $valor = formatFloat($valor);
            } else {
                $valor = formatarValor($valor);
            }
            
            /* verifica se valor é mairo que 0 */
            if (($valor < 0)) {
                $this->mensagemDeErro[] = 'Valor tem que ser maior que 0<br>';
                $this->erros = true;
            }
            
            /* verifica se categoria é numerico */
            $ct = new CategoriaService();
            $cat = $ct->find($em, $categoria);
            if ($cat == NULL) {
                $cat = $ct->idPorDescricao($em, $categoria);
                if ($cat == NULL) {
                    $this->mensagemDeErro[] = 'Categoria não encontrada<br>';
                    $this->erros = true;
                }
            }
            /* verifica se as tags estao preenchidas */
            $tag = \explode(';', $tags);
            if ($tag == NULL) {
                $this->mensagemDeErro[] = 'Nenhuma tag encontrada<br>';
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
                    $this->mensagemDeErro[] = 'Erro ao informar as tags<br>';
                    $this->erros = true;
                }
            }
        }
        
        if ($this->erros) {
            return false;
        }
        
        $this->mensagemDeErro[] = 'OK';
        
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
//                 if ($imagem != 'api') {
                    $this->produto->setImagem($imagem);
//                 }
                foreach ($this->tags as $tg) {
                    $this->produto->addTags($tg);
                }
            }
            if (! isset($this->produto)) {
                $this->mensagemDeErro[] = 'Produto não encontrado<br>';
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
        foreach ($this->mensagemDeErro as $msg) {
            $m = $msg . $msg;
        }
        return $m;
    }
}



