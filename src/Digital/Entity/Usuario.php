<?php
namespace Digital\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Digital\Entity\UsuarioRepository")
 * @ORM\Table(name="usuarios")
 */
class Usuario implements PersistentInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	private $id;
	/**
	 * @ORM\Column(type="string",length=32)
	 */
	private $login;
	/**
	 * @ORM\Column(type="string",length=60)
	 */
	private $senha;
	/**
	 * @ORM\Column(type="string",length=120)
	 */
	private $email;
	/**
	 * @ORM\Column(type="string",length=45,nullable=true)
	 */
	private $sessao;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getSessao()
    {
        return $this->sessao;
    }

    public function setSessao($sessao)
    {
        $this->sessao = $sessao;
        return $this;
    }
 
}