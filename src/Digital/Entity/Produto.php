<?php
namespace Digital\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Digital\Service\CategoriaService;

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
     * @ORM\Column(type="string",length=20,nullable=true)
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
     * @ORM\ManyToOne(targetEntity="Digital\Entity\Categoria")
     * @ORM\JoinColumn(name="id_categoria", referencedColumnName="id")
     */
    private $id_categoria;

    /**
     * @ORM\Column(type="decimal",precision=10, scale=2)
     */
    private $valor;

    /**
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    private $imagem;

    /**
     * @ORM\ManyToMany(targetEntity="Digital\Entity\Tag")
     * @ORM\JoinTable(name="tags_produto",
     * joinColumns={@ORM\JoinColumn(name="produto_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

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

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getIdCategoria()
    {
        return $this->id_categoria;
    }

    public function setIdCategoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;
        return $this;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
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

    public function getTags()
    {
        return $this->tags;
    }
    
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    public function addTags($tags)
    {
        $this->tags->add($tags);
        return $this;
    }

    public function getTagsAsJson()
    {
        if (isset($this->tags)) {
            $tags = $this->tags;
            $t = [];
            foreach ($tags as $tag) {
                $t[] = $tag->getTag();
            }
            return \json_encode($t);
        }
        return '';
    }

    public function getCategoriaAsJson()
    {
        $result['id'] = $this->id_categoria->getId();
        $result['descricao'] = $this->id_categoria->getDescricao();
        return \json_encode($result);
    }
} 