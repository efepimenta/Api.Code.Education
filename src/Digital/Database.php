<?php

namespace Digital;

use Doctrine\ORM\EntityManager;
use Digital\Entity\PersistentInterface;

class Database
{
	private $driver;

	public function __construct($driver) {

		if (! $driver instanceof \PDO) {
			throw new \PDOException();
		}
		$this->driver = $driver;
		$this->driver->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	
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
	 * Atualizar um objeto usando o Doctrine
	 *
	 * @param EntityManager $em
	 * @param PersistentInterface $entity
	 * @return boolean
	 */
	public function merge(EntityManager $em, PersistentInterface $entity) {

		try {
			$em->merge($entity);
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
			$rm = $em->find(get_class($entity), $entity->getId());
			$em->remove($rm);
			$em->flush();
			return true;
		}
		catch ( Exception $e ) {
			return $e->getMessage();
		}
	
	}

	public function configureDriver() {

		return $this->driver;
	
	}

	public function select($sql, $unique = false, array $valuesToBind = []) {

		$st = $this->driver->prepare($sql);
		if (count($valuesToBind) > 0) {
			foreach ( $valuesToBind as $bind => $value ) {
				foreach ( $value as $k => $v ) {
					$st->bindParam($bind, $k, $v);
				}
			}
		}
		$st->execute();
		return $unique ? $st->fetch(\PDO::FETCH_ASSOC) : $st->fetchAll(\PDO::FETCH_ASSOC);
	
	}

	function exec($sql) {

		$st = $this->driver->exec($sql);
		return $st > 0;
	
	}

	function nextID($table) {

		$st = $this->driver->query("select max(id) from $table");
		$id = $st->fetch(\PDO::FETCH_ASSOC);
		$id = $id['max(id)'] + 1;
		return $id;
	
	}

}
