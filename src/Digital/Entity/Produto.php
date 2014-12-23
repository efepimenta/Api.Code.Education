<?php

namespace Digital\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Digital\Entity\ProdutoRepository")
 * @ORM\Table(name="produtos")
 */
class Produto implements PersistentInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	private $id;
	/**
	 * @ORM\Column(type="string",length=20)
	 */
	private $codigo;
	/**
	 * @ORM\Column(type="string",length=100)
	 */
	private $nome;
	/**
	 * @ORM\Column(type="text")
	 */
	private $descricao;
	/**
	 * @ORM\Column(type="integer")
	 */
	private $id_categoria;
	/**
	 * @ORM\Column(type="decimal",precision=10, scale=2)
	 */
	private $valor;
	/**
	 * @ORM\Column(type="string",length=100)
	 */
	private $imagem;

	public function getId_categoria() {

		return $this->id_categoria;
	
	}

	public function setId_categoria($id_categoria) {

		$this->id_categoria = $id_categoria;
	
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

	public function getImagem() {

		return $this->imagem;
	
	}

	public function setImagem($imagem) {

		$this->imagem = $imagem;
		return $this;
	
	}
	

} 