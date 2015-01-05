<?php

/*
 * esse é o Model Produto
 */

namespace Digital\Service;

use Digital\DatabaseDoctrine;
use Digital\Entity\PersistentInterface;
use Digital\Paginator;
use Doctrine\ORM\EntityManager;

/*
 * as funcoes da classe Database serao removidas....
 */

class ProdutoService extends DatabaseDoctrine
{
    private $class;

    public function __construct()
    {

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
    public function update(EntityManager $em, PersistentInterface $entity)
    {

        try {
            $up = $em->getReference($this->class, $entity->getId());
            $up->setNome($entity->getNome());
            $up->setId_categoria($entity->getId_categoria());
            $up->setDescricao($entity->getDescricao());
            $up->setValor($entity->getValor());
            $em->persist($up);
            $em->flush();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Faz uma busca personalizada baseada em critérios pré-definidos
     *
     * @param EntityManager $em
     * @param array $criterio
     */
    public function buscaPersonalizada(EntityManager $em, Paginator $paginator)
    {

        $rp = $em->getRepository($this->class);
        return $rp->buscaPersonalizada($paginator);

    }

    public function listaPaginada(EntityManager $em, Paginator $paginator)
    {
        $rp = $em->getRepository($this->class);
        return $rp->listaPaginada($paginator);
    }

}