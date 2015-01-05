<?php

namespace Digital\Service;

use Digital\DatabaseDoctrine;
use Digital\Entity\PersistentInterface;
use Doctrine\ORM\EntityManager;

class CategoriaService extends DatabaseDoctrine
{
    private $class;

    public function __construct()
    {

        /* classe que o doctrine vai mapear */
        $this->class = 'Digital\Entity\Categoria';
        parent::setClass($this->class);

    }

    public function idPorDescricao(EntityManager $em, $descricao)
    {

        $rp = $em->getRepository($this->class);
        return $rp->idPorDescricao($descricao);

    }

    public function update(EntityManager $em, PersistentInterface $entity)
    {

        try {
            $up = $em->getReference($this->class, $entity->getId());
            $up->setNome($entity->getNome());
            $up->setDescricao($entity->getDescricao());
            $em->persist($up);
            $em->flush();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

}