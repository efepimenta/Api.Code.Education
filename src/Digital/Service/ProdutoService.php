<?php

namespace Digital\Service;

use Digital\Entity\Produto;
use Digital\Database;
use Doctrine\ORM\EntityManager;
use Digital\Entity\PersistentInterface;

class ProdutoService
{
	private $database;

	public function __construct(Database $database) {

		$this->database = $database;
	
	}

	/**
	 * Persiste um objeto PersistentInterface
	 * 
	 * @param EntityManager $em        	
	 * @param PersistentInterface $entity        	
	 * @return boolean
	 */
	public function persist(EntityManager $em, PersistentInterface $entity) {

		return $this->database->persist($em, $entity);
	
	}
	
	/**
	 * Atualiza um objeto PersistentInterface
	 *
	 * @param EntityManager $em
	 * @param PersistentInterface $entity
	 * @return boolean
	 */
	public function update(EntityManager $em, PersistentInterface $entity) {
	
		return $this->database->update($em, $entity);
	
	}
	
	/**
	 * Remove um objeto PersistentInterface
	 *
	 * @param EntityManager $em
	 * @param PersistentInterface $entity
	 * @return boolean
	 */
	public function remove(EntityManager $em, PersistentInterface $entity) {
	
		return $this->database->remove($em, $entity);
	
	}

	public function nextID() {

		return $this->database->nextID('produtos');
	
	}

	/**
	 * Atualiza um Produto
	 *
	 * @param Produto $produto        	
	 * @return boolean
	 */
// 	public function atualizar(Produto $produto) {

// 		$sql = "UPDATE produtos SET nome='{$produto->getNome()}',descricao='{$produto->getDescricao()}',codigo='0001',
// 		id_categoria='{$produto->getId_categoria()}',valor='{$produto->getValor()}' where id='{$produto->getId()}'";
// 		return $this->database->exec($sql);
	
// 	}

	/**
	 * Insere um Produto
	 *
	 * @param Produto $produto        	
	 * @return boolean
	 */
// 	public function inserir(Produto $produto) {

// 		$id = $this->database->nextID('produtos');
		
// 		$sql = "insert into produtos (id,codigo,nome,valor,descricao,id_categoria) values ({$id},'0001','{$produto->getNome()}',
// 		'{$produto->getValor()}','{$produto->getDescricao()}','{$produto->getId_categoria()}')";
// 		return $this->database->exec($sql);
	
// 	}

	/**
	 * Remove um Produto
	 *
	 * @param integer $id        	
	 * @return boolean
	 */
// 	public function deletar($id) {

// 		$sql = "DELETE FROM produtos WHERE id={$id}";
// 		$result = $this->database->exec($sql);
// 		if (! $result) {
// 			return false;
// 		}
// 		return $result;
	
// 	}

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