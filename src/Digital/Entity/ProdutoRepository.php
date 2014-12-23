<?php

namespace Digital\Entity;

use Doctrine\ORM\EntityRepository;
use Digital\Paginator;

class ProdutoRepository extends EntityRepository
{

	public function buscaPersonalizada($nome, Paginator $paginator) {

		$crit = '';
		switch ($paginator->getCriterio()) {
			case 'igual' :
				$crit = "= '{$paginator->getTermo()}'";
				break;
			case 'diferente' :
				$crit = "<> '{$paginator->getTermo()}'";
				break;
			case 'contem' :
				$crit = "LIKE '%{$paginator->getTermo()}%'";
				break;
			case 'comeca' :
				$crit = "LIKE '{$paginator->getTermo()}%'";
				break;
			case 'termina' :
				$crit = "LIKE '%{$paginator->getTermo()}'";
				break;
		}
		
		$dql = "SELECT COUNT(p.id) from Digital\Entity\Produto p WHERE p.{$paginator->getCampo()} {$crit}";
		$qtde = $this->getEntityManager()->createQuery($dql)->getResult();
		$paginator->setResultados($qtde[0][1]);
		
		$dql = "SELECT p from Digital\Entity\Produto p WHERE p.{$paginator->getCampo()} {$crit}";
		return $this->getEntityManager()->createQuery($dql)
			->setMaxResults($paginator->getQuantidade())
			->setFirstResult($paginator->getProximo())
			->getResult();
	
	}
	
	public function getRecordCount(){
		$dql = "SELECT COUNT(p.id) from Digital\Entity\Produto p";
		return $this->getEntityManager()->createQuery($dql)->getResult();
	}

}