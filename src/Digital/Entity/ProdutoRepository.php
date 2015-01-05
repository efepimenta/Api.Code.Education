<?php

namespace Digital\Entity;

use Digital\Paginator;
use Doctrine\ORM\EntityRepository;

class ProdutoRepository extends EntityRepository
{

    public function buscaPersonalizada(Paginator $paginator)
    {

        $crit = '';
        switch ($paginator->getBuscaCriterio()) {
            case 'igual' :
                $crit = "= '{$paginator->getBuscaTermo()}'";
                break;
            case 'diferente' :
                $crit = "<> '{$paginator->getBuscaTermo()}'";
                break;
            case 'contem' :
                $crit = "LIKE '%{$paginator->getBuscaTermo()}%'";
                break;
            case 'comeca' :
                $crit = "LIKE '{$paginator->getBuscaTermo()}%'";
                break;
            case 'termina' :
                $crit = "LIKE '%{$paginator->getBuscaTermo()}'";
                break;
        }

        $dql = "SELECT COUNT(p.id) from Digital\Entity\Produto p WHERE p.{$paginator->getBuscaCampo()} {$crit}";
        $qtde = $this->getEntityManager()->createQuery($dql)->getResult();
        $paginator->setResultadosEncontrados($qtde[0][1]);

        $dql = "SELECT p from Digital\Entity\Produto p WHERE p.{$paginator->getBuscaCampo()} {$crit}";
        $result = $this->getEntityManager()->createQuery($dql)
            ->setMaxResults($paginator->getQuantidadePorPagina())
            ->setFirstResult($paginator->getOffset())
            ->getResult();
        return $result;

    }

    public function listaPaginada(Paginator $paginator)
    {

        $dql = "SELECT p from Digital\Entity\Produto p";
        $result = $this->getEntityManager()->createQuery($dql)
            ->setMaxResults($paginator->getQuantidadePorPagina())
            ->setFirstResult($paginator->getOffset())
            ->getResult();
        $paginator->setResultadosEncontrados($this->getRecordCount()[0][1]);
        return $result;

    }

    private function getRecordCount()
    {
        $dql = "SELECT COUNT(p.id) from Digital\Entity\Produto p";
        return $this->getEntityManager()->createQuery($dql)->getResult();
    }

}