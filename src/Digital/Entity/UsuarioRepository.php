<?php
namespace Digital\Entity;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
	public function login($login,$senha)
	{
	    $dql = "SELECT u from Digital\Entity\Usuario u WHERE u.login = '{$login}'";
	    $result = $this->getEntityManager()->createQuery($dql)->getResult();
	    if (\count($result)){
	        if (\password_verify($senha, $result[0]->getSenha())){
	            return true;
	        }
	    } else {
	        return false;
	    }
	    return false;
	}
}