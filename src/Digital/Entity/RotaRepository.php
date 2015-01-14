<?php

namespace Digital\Entity;

use Doctrine\ORM\EntityRepository;

class RotaRepository extends EntityRepository
{

	public function idPorUri($uri)
	{
	    $dql = "SELECT r from Digital\Entity\Rota r WHERE r.rota = '{$uri}'";
	    $result = $this->getEntityManager()->createQuery($dql)->getResult();
	    return $result;
	}
	
	public function uriPorId($id)
	{
	    $dql = "SELECT r from Digital\Entity\Rota r WHERE r.id = '{$id}'";
	    $result = $this->getEntityManager()->createQuery($dql)->getResult();
	    return $result;
	}

}