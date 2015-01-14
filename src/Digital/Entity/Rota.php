<?php
namespace Digital\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Digital\Entity\RotaRepository")
 * @ORM\Table(name="rotas")
 */
class Rota implements PersistentInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	private $id;
	/**
	 * @ORM\Column(type="string",length=255)
	 */
	private $rota;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getRota()
    {
        return $this->rota;
    }

    public function setRota($rota)
    {
        $this->rota = $rota;
        return $this;
    }
 
}