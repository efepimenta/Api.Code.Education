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
use Digital\Paginator;

/*
 * as funcoes da classe Database serao removidas....
 */
class ProdutoService extends DatabaseDoctrine
{
	private $database;
	private $class;

	public function __construct(Database $database) {

		$this->database = $database;
		/* classe que o doctrine vai mapear */
		$this->class = 'Digital\Entity\Produto';
		parent::setClass($this->class);
	
	}
	
	/**
	 * Atualizar um objeto usando o Doctrine
	 *
	 * @param EntityManager $em
	 * @param PersistentInterface $entity
	 * @return boolean
	 */
	public function update(EntityManager $em, PersistentInterface $entity) {
	
		try {
			$up = $em->getReference($this->class, $entity->getId());
			$up->setNome($entity->getNome());
			$up->setId_categoria($entity->getId_categoria());
			$up->setDescricao($entity->getDescricao());
			$up->setValor($entity->getValor());
			$em->persist($up);
			$em->flush();
			return true;
		}
		catch ( Exception $e ) {
			return $e->getMessage();
		}
	
	}
	
	/**
	 * Faz uma busca personalizada baseada em critérios pré-definidos
	 *
	 * @param EntityManager $em
	 * @param array $criterio
	 */
	public function buscaPersonalizada(EntityManager $em, Paginator $paginator) {
	
		$rp = $em->getRepository($this->class);
		return $rp->buscaPersonalizada($em, $paginator);
	
	}
	
// 	public function nextID() {

// 		return $this->database->nextID('produtos');
	
// 	}

// 	/**
// 	 * Lista todos os Produtos
// 	 */
// 	public function listar() {

// 		$sql = 'SELECT produtos.id, produtos.codigo, produtos.nome, produtos.descricao,
//         produtos.valor, produtos.imagem, categorias.nome as cat_nome, categorias.descricao as cat_descricao
//         FROM produtos
//         inner join categorias on produtos.id_categoria = categorias.id';
// 		return $this->database->select($sql);
	
// 	}

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