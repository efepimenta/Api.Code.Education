<?php

namespace Digital\Service\Validator;

use Digital\Entity\Produto;
use Digital\Service\CategoriaService;
use Doctrine\ORM\EntityManager;

class ProdutoValidator
{
	private $mensagemDeErro = "Informe o(s) seguinte(s) valores:";
	private $produto;
	private $id;
	private $nome;
	private $descricao;
	private $categoria;
	private $valor;
	private $erros;

	public function validar(EntityManager $em, $acao, $id = '', $nome = '', $descricao = '', $categoria = '', $valor = '') {

		$falta = '';
		$this->erros = false;
		switch ($acao) {
			case 'listar' :
				{
					if (empty($id)) {
						$this->erros = true;
						$falta = ' -> id ';
					}
					break;
				}
			case 'inserir' :
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
					break;
				}
			case 'atualizar' :
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
					break;
				}
			case 'deletar' :
				{
					if (empty($id)) {
						$this->erros = true;
						$falta = ' -> id ';
					}
					break;
				}
			default :
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
			$this->produto = new Produto();
			$catObj = new CategoriaService();
			if ($acao !== 'inserir') {
				$this->produto->setId($id);
			}
			$this->produto->setNome($nome);
			$this->produto->setDescricao($descricao);
			$cat = $catObj->find($em,$categoria);
			$this->produto->setId_categoria($cat);
			$this->produto->setValor($valor);
			if (!isset($this->produto)){
				$this->mensagemDeErro = 'Produto não encontrado';
				return false;
			}
		}
		return true;
	
	}

	public function getProduto() {

		if (! $this->erros) {
			return $this->produto;
		}
		return null;
	
	}

	public function mensagemDeErro() {

		return $this->mensagemDeErro;
	
	}

}



