<?php

namespace Digital\Entity;

use Doctrine\ORM\EntityRepository;

class CategoriaRepository extends EntityRepository
{

    public function idPorDescricao($descricao)
    {
        $dql = "SELECT c from Digital\Entity\Categoria c WHERE c.descricao = '{$descricao}'";
        $result = $this->getEntityManager()->createQuery($dql)->getResult();
        return $result;
    }

    public function getRecordCount()
    {

        $dql = "SELECT COUNT(c.id) from Digital\Entity\Categoria c";
        return $this->getEntityManager()->createQuery($dql)->getResult();

    }

}