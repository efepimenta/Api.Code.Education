<?php
namespace Digital\Service;

use Digital\DatabaseDoctrine;
use Doctrine\ORM\EntityManager;

class RotaService extends DatabaseDoctrine
{

    private $class;

    public function __construct()
    {
        
        /* classe que o doctrine vai mapear */
        $this->class = 'Digital\Entity\Rota';
        parent::setClass($this->class);
    }

    /**
     * Reotrna a uri atual, com ou sem o '.'
     *
     * @param bool $dotPHP            
     * @return string
     */
    function currentUri($dotPHP = false)
    {
        $pagina = '';
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $query_str = filter_input(INPUT_SERVER, 'QUERY_STRING');
        if (isset($uri)) {
            $pagina = $uri;
        }
        if (isset($query_str)) {
            $pagina = str_replace('?' . $query_str, '', $pagina);
        }
        if ($pagina == "/") {
            return $dotPHP ? 'index.php' : 'index';
        } else {
            $l = strlen($pagina);
            $p = strpos(strtolower($pagina), ".php");
            if ($p > 0 && $l == $p + 4) {
                $pagina = substr($pagina, 0, $p);
            }
            $pagina = substr($pagina, 1);
            return $dotPHP ? $pagina . '.php' : $pagina;
        }
    }

    /**
     * Recebe o ID da rota
     *
     * @param EntityManager $em            
     * @param unknown $uri            
     */
    public function idPorUri(EntityManager $em, $uri)
    {
        $rp = $em->getRepository($this->class);
        return $rp->idPorUri($uri);
    }

    /**
     * Recebe a uri da Rota
     * 
     * @param EntityManager $em            
     * @param unknown $id            
     */
    public function uriPorId(EntityManager $em, $id)
    {
        $rp = $em->getRepository($this->class);
        return $rp->uriPorId($id);
    }

    /**
     * Verifica se a rota passada existe
     * 
     * @param EntityManager $em            
     * @param unknown $uri            
     * @return boolean
     */
    function routeExists(EntityManager $em, $uri)
    {
        $rota = $this->idPorUri($em, $uri);
        if (\count($rota) == 0) {
            return false;
        }
        return true;
    }
}