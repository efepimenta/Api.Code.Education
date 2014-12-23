<?php

/*
 * esse é o Model Produto
 */

namespace Digital\Service;

use Digital\Entity\Produto;
use Digital\Database;
use Doctrine\ORM\EntityManager;
use Digital\Entity\PersistentInterface;
use Digital\DatabaseDoctrine;

/*
 * as funcoes da classe Database serao removidas....
 */
class ProdutoService extends DatabaseDoctrine
{
	private $database;

	public function __construct(Database $database) {

		$this->database = $database;
		/* classe que o doctrine vai mapear */
		parent::setClass('Digital\Entity\Produto');
	
	}

	public function nextID() {

		return $this->database->nextID('produtos');
	
	}

	/**
	 * Lista todos os Produtos
	 */
	public function listar() {

		$sql = 'SELECT produtos.id, produtos.codigo, produtos.nome, produtos.descricao,
        produtos.valor, produtos.imagem, categorias.nome as cat_nome, categorias.descricao as cat_descricao
        FROM produtos
        inner join categorias on produtos.id_categoria = categorias.id';
		return $this->database->select($sql);
	
	}

	public function listarPorId($id) {

		$sql = "SELECT produtos.id, produtos.codigo, produtos.nome, produtos.descricao,
        produtos.valor, produtos.imagem, categorias.nome as cat_nome, categorias.descricao as cat_descricao
        FROM produtos
        inner join categorias on produtos.id_categoria = categorias.id where produtos.id = {$id}";
		$result = $this->database->select($sql);
		if (count($result) == 0) {
			return "Nenhum produto encontrado com o id {$id}";
		}
		return $result;
	
	}

}