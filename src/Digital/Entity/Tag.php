<?php

namespace Digital\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Digital\Entity\TagRepository")
 * @ORM\Table(name="tags")
 */
class Tag implements PersistentInterface {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	private $id;
	/**
	 * @ORM\Column(type="string",length=60)
	 */
	private $tag;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getTag() {
		return $this->tag;
	}
	public function setTag($tag) {
		$this->tag = $tag;
		return $this;
	}
}