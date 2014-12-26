<?php

namespace Digital\Service\Validator;

use Digital\Service\CategoriaService;
use Doctrine\ORM\EntityManager;
use Digital\Entity\Categoria;

class CategoriaValidator
{
	private $mensagemDeErro = "Informe o(s) seguinte(s) valores:";
	private $categoria;
	private $id;
	private $nome;
	private $descricao;
	private $erros;

	public function validar(EntityManager $em, $acao, $id = '', $nome = '', $descricao = '') {

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
			$this->categoria = new Categoria();
			if ($acao !== 'inserir') {
				$this->categoria->setId($id);
			}
			$this->categoria->setNome($nome);
			$this->categoria->setDescricao($descricao);
			if (!isset($this->categoria)){
				$this->mensagemDeErro = 'Categoria não encontrada';
				return false;
			}
		}
		return true;
	
	}

	public function getCategoria() {

		if (! $this->erros) {
			return $this->categoria;
		}
		return null;
	
	}

	public function mensagemDeErro() {

		return $this->mensagemDeErro;
	
	}

}



