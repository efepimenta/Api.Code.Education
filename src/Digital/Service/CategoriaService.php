<?php

namespace Digital\Service;

use Digital\Entity\Categoria;
use Digital\Database;

class CategoriaService
{
	private $database;

	public function __construct(Database $database) {

		$this->database = $database;
	
	}

	/**
	 * Atualiza uma Categoria
	 * 
	 * @param Categoria $categoria        	
	 * @return boolean
	 */
	public function atualizar(Categoria $categoria) {

		$sql = "UPDATE categorias SET nome='{$categoria->getNome()}',descricao='{$categoria->getDescricao()}'";
		return $this->database->exec($sql);
	
	}

	/**
	 * Insere uma nova Categoria
	 * 
	 * @param Categoria $categoria        	
	 * @return boolean
	 */
	public function inserir(Categoria $categoria) {

		$id = $this->database->nextID('categorias');
		
		$sql = "insert into categorias (id,nome,valor,descricao,id_categoria) values ({$id},'{$categoria->getNome()}',
		'{$categoria->getDescricao()}')";
		return $this->database->exec($sql);
	
	}

	/**
	 * Remove uma Categoria
	 * 
	 * @param unknown $id        	
	 * @return boolean
	 */
	public function deletar($id) {

		$sql = "DELETE FROM categorias WHERE id={$id}";
		return $this->database->exec($sql);
	
	}

	/**
	 * Lista todas as Categorias (id, nome, descricao)
	 */
	public function listar() {

		$sql = 'select id, nome, descricao from categorias';
		return $this->database->select($sql);
	
	}

	/**
	 * Retorna o ID de acordo com a descrição da Categoria
	 * 
	 * @param string $descricao        	
	 * @param boolean $unique        	
	 * @param array $valuesToBind        	
	 */
	public function idPorDescricao($descricao, $unique = false, array $valuesToBind = []) {

		$sql = "select id from categorias where descricao = '{$descricao}'";
		return $this->database->select($sql, $unique, $valuesToBind);
	
	}

}