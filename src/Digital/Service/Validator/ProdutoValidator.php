<?php

namespace Digital\Service\Validator;

use Digital\Entity\Produto;
use Digital\Service\CategoriaService;
use Doctrine\ORM\EntityManager;

class ProdutoValidator {
	private $mensagemDeErro = "Informe o(s) seguinte(s) valores:";
	private $produto;
	private $id;
	private $nome;
	private $descricao;
	private $categoria;
	private $valor;
	private $erros;
	private $entra;
	public function validar(EntityManager $em, $acao, $id = '', $nome = '', $descricao = '', $categoria = '', $valor = '') {
		$falta = '';
		$this->erros = false;
		$this->entra = true;
		switch ($acao) {
			case 'listar' :
				{
					$this->entra = false;
					if (empty ( $id )) {
						$this->erros = true;
						$falta = ' -> id ';
					}
					break;
				}
			case 'inserir' :
				{
					if (empty ( $nome )) {
						$this->erros = true;
						$falta = $falta . ' -> nome ';
					}
					if (empty ( $descricao )) {
						$this->erros = true;
						$falta = $falta . ' -> descricao ';
					}
					if (empty ( $categoria )) {
						$this->erros = true;
						$falta = $falta . ' -> categoria ';
					}
					if (empty ( $valor )) {
						$this->erros = true;
						$falta = $falta . ' -> valor ';
					}
					break;
				}
			case 'atualizar' :
				{
					if (empty ( $id )) {
						$this->erros = true;
						$falta = ' -> id ';
					}
					if (empty ( $nome )) {
						$this->erros = true;
						$falta = $falta . ' -> nome ';
					}
					if (empty ( $descricao )) {
						$this->erros = true;
						$falta = $falta . ' -> descricao ';
					}
					if (empty ( $categoria )) {
						$this->erros = true;
						$falta = $falta . ' -> categoria ';
					}
					if (empty ( $valor )) {
						$this->erros = true;
						$falta = $falta . ' -> valor ';
					}
					break;
				}
			case 'deletar' :
				{
					$this->entra = false;
					if (empty ( $id )) {
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
					$this->entra = false;
					break;
				}
		}
		
		if ($this->entra) {
			// remover todos os caracteres nao numericos de $valor
			
			$valor = soNumero ( $valor );
			
			/* verifica se valor é numerico */
			if (! is_numeric ( $valor )) {
				$this->mensagemDeErro = $falta . '-> Valor tem que ser numérico';
				$this->erros = true;
			}
			/* verifica se valor é mairo que 0 */
			if (($valor < 0)) {
				$this->mensagemDeErro = $falta . '-> Valor tem que ser maior que 0';
				$this->erros = true;
			}
			
			/* verifica se categoria é numerico */
			$ct = new CategoriaService ();
			$cat = $ct->find ( $em, $categoria );
			if ($cat == NULL) {
				$cat = $ct->idPorDescricao ( $em, $categoria );
				if ($cat == NULL) {
					$this->mensagemDeErro = $falta . '-> Categoria não encontrada';
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
			$this->produto = new Produto ();
			if ($acao !== 'inserir') {
				$this->produto->setId ( $id );
			}
			if ($this->entra) {
				$this->produto->setNome ( $nome );
				$this->produto->setDescricao ( $descricao );
				$this->produto->setId_categoria ( $cat );
				$this->produto->setValor ( $valor );
			}
			if (! isset ( $this->produto )) {
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



