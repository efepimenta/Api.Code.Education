<?php
namespace Digital\Service;

use Digital\DatabaseDoctrine;
use Digital\Entity\PersistentInterface;
use Doctrine\ORM\EntityManager;

class TagService extends DatabaseDoctrine
{

    private $class;

    public function __construct()
    {
        
        /* classe que o doctrine vai mapear */
        $this->class = 'Digital\Entity\Tag';
        parent::setClass($this->class);
    }

    public function idPorTag(EntityManager $em, $tag)
    {
        $rp = $em->getRepository($this->class);
        return $rp->idPorTag($tag);
    }
    
    public function produtoPorTag(EntityManager $em, $tag){
        $rp = $em->getRepository($this->class);
        return $rp->produtoPorTag($tag);
    }

    public function update(EntityManager $em, PersistentInterface $entity)
    {
        try {
            $up = $em->getReference($this->class, $entity->getId());
            $up->setTag($entity->getTag());
            $em->persist($up);
            $em->flush();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}