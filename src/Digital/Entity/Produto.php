<?php

/**
 * Created by PhpStorm.
 * User: fabio
 * Date: 09/12/14
 * Time: 13:40
 */
namespace Digital\Entity;

class Produto
{
	private $id;
	private $codigo;
	private $nome;
	private $descricao;
	private $categoria;
	private $valor;

	public function getCategoria() {

		return $this->categoria;
	
	}

	public function setCategoria($categoria) {

		$this->categoria = $categoria;
	
	}

	public function getCodigo() {

		return $this->codigo;
	
	}

	public function setCodigo($codigo) {

		$this->codigo = $codigo;
	
	}

	public function getDescricao() {

		return $this->descricao;
	
	}

	public function setDescricao($descricao) {

		$this->descricao = $descricao;
	
	}

	public function getId() {

		return $this->id;
	
	}

	public function setId($id) {

		$this->id = $id;
	
	}

	public function getNome() {

		return $this->nome;
	
	}

	public function setNome($nome) {

		$this->nome = $nome;
	
	}

	public function getValor() {

		return $this->valor;
	
	}

	public function setValor($valor) {

		$this->valor = $valor;
	
	}

} 