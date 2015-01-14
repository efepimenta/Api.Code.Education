<?php
namespace Digital\Entity;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{

    public function montaMenu()
    {
        $dql = "SELECT m from Digital\Entity\Menu m order by m.sequencia, m.posicao";
        $result = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();
        return $result;
    }
}