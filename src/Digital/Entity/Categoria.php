<?php

namespace Digital\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Digital\Entity\CategoriaRepository")
 * @ORM\Table(name="categorias")
 */
class Categoria implements PersistentInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	private $id;
	/**
	 * @ORM\Column(type="string",length=60)
	 */
	private $nome;
	/**
	 * @ORM\Column(type="string",length=250)
	 */
	private $descricao;

	public function getId() {

		return $this->id;
	
	}

	public function setId($id) {

		$this->id = $id;
		return $this;
	
	}

	public function getNome() {

		return $this->nome;
	
	}

	public function setNome($nome) {

		$this->nome = $nome;
		return $this;
	
	}

	public function getDescricao() {

		return $this->descricao;
	
	}

	public function setDescricao($descricao) {

		$this->descricao = $descricao;
		return $this;
	
	}

}