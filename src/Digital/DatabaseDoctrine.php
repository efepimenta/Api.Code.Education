<?php

namespace Digital;

use Doctrine\ORM\EntityManager;
use Digital\Entity\PersistentInterface;

/*
 * classe substituta de Database, somente com métodos via doctrine
 * as classes Service nao irao mais conter metodos, ja que estao herdando de DatabaseDoctrine (nome sera alterado para Database)
 */
abstract class DatabaseDoctrine
{
	private $class;

	protected function setClass($classname) {

		$this->class = $classname;
	
	}

	/**
	 * Persistir um objeto usando o Doctrine
	 *
	 * @param EntityManager $em        	
	 * @param PersistentInterface $entity        	
	 * @return boolean
	 */
	public function persist(EntityManager $em, PersistentInterface $entity) {

		try {
			$em->persist($entity);
			$em->flush();
			return true;
		}
		catch ( Exception $e ) {
			return $e->getMessage();
		}
	
	}

	/**
	 * Remover um objeto usando o Doctrine
	 *
	 * @param EntityManager $em        	
	 * @param PersistentInterface $entity        	
	 * @return boolean
	 */
	public function remove(EntityManager $em, PersistentInterface $entity) {

		try {
			$rp = $em->getReference($this->class, $entity->getId());
			$em->remove($rp);
			$em->flush();
			return true;
		}
		catch ( Exception $e ) {
			return $e->getMessage();
		}
	
	}

	/**
	 * Retorna a quantidade de registros encontrados na tabela
	 * 
	 * @param EntityManager $em        	
	 */
	public function getRecordCount(EntityManager $em) {

		$rp = $em->getRepository($this->class);
		return $rp->getRecordCount();
	
	}

	/**
	 * Reorna todos os registros da tabela Produtos
	 *
	 * @param EntityManager $em        	
	 * @return multitype:
	 */
	public function findAll(EntityManager $em) {

		$rp = $em->getRepository($this->class);
		return $rp->findAll();
	
	}

	/**
	 * Retorna um registro da tabela Produtos cujo id seja informado
	 *
	 * @param EntityManager $em        	
	 * @param unknown $id        	
	 * @return Ambigous <object, NULL>
	 */
	public function find(EntityManager $em, $id) {

		$rp = $em->getRepository($this->class);
		return $rp->find($id);
	
	}

}
