<?php

namespace Digital\Service;

use Digital\Entity\Produto;
use Digital\Database;

class ProdutoService
{
	private $database;

	public function __construct(Database $database) {

		$this->database = $database;
	
	}

	public function atualizar(Produto $produto) {

		$sql = "UPDATE produtos SET nome='{$produto->getNome()}',descricao='{$produto->getDescricao()}',
		id_categoria='{$produto->getCategoria()}',valor='{$produto->getValor()}' where id='{$produto->getId()}'";
		return $this->database->exec($sql);
	
	}

	/**
	 * Atualiza um Produto
	 * 
	 * @param Produto $produto        	
	 * @return boolean
	 */
	public function inserir(Produto $produto) {

	
	}

	/**
	 * Remove um Produto
	 * 
	 * @param integer $id        	
	 * @return boolean
	 */
	public function deletar($id) {

		$sql = "DELETE FROM produtos WHERE id={$id}";
		return $this->database->exec($sql);
	
	}

	public function listar() {
		$sql = 'SELECT produtos.id, produtos.codigo, produtos.nome, produtos.descricao,
        produtos.valor, produtos.imagem, categorias.nome as cat_nome, categorias.descricao as cat_descricao
        FROM produtos
        inner join categorias on produtos.id_categoria = categorias.id';
		return $this->database->select($sql);
	
	}

}