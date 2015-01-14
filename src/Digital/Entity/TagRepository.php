<?php

namespace Digital\Entity;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
{

    public function idPorTag($tag)
    {
        $dql = "SELECT t from Digital\Entity\Tag t WHERE t.tag = '{$tag}'";
        $result = $this->getEntityManager()->createQuery($dql)->getResult();
        return $result;
    }
    
    public function produtoPorTag($tag){
        $dql = "select p from Digital\Entity\Produto p join p.tags t where t.tag = '{$tag}'";
        $result = $this->getEntityManager()->createQuery($dql)->getResult();
        return $result;
    }
    
    public function getRecordCount()
    {

        $dql = "SELECT COUNT(c.id) from Digital\Entity\Categoria c";
        return $this->getEntityManager()->createQuery($dql)->getResult();

    }

}