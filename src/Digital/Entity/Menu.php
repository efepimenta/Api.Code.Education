<?php
namespace Digital\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Digital\Entity\MenuRepository")
 * @ORM\Table(name="menu")
 */
class Menu implements PersistentInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=50)
     */
    private $nome;

    /**
     * @ORM\Column(type="string",length=1, options={"fixed" = true})
     */
    private $kind;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequencia;

    /**
     * @ORM\Column(type="integer")
     */
    private $posicao;

    /**
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    private $imagem;

    /**
     * @ORM\Column(type="string",length=1, options={"fixed" = true})
     */
    private $fim;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $id_rota;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
        return $this;
    }

    public function getSequencia()
    {
        return $this->sequencia;
    }

    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    public function getPosicao()
    {
        return $this->posicao;
    }

    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;
        return $this;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
        return $this;
    }

    public function getFim()
    {
        return $this->fim;
    }

    public function setFim($fim)
    {
        $this->fim = $fim;
        return $this;
    }

    public function getIdRota()
    {
        return $this->id_rota;
    }

    public function setIdRota($id_rota)
    {
        $this->id_rota = $id_rota;
        return $this;
    }
}