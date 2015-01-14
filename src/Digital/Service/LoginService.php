<?php
namespace Digital\Service;

use Doctrine\ORM\EntityManager;
use Digital\DatabaseDoctrine;

class LoginService extends DatabaseDoctrine
{

    private $class;

    public function __construct()
    {
        
        /* classe que o doctrine vai mapear */
        $this->class = 'Digital\Entity\Usuario';
        parent::setClass($this->class);
    }

    /**
     * Cria as sessões e os Cookies (se criarCookies for true)
     *
     * @param array $data            
     * @param string $criarCookies            
     */
    public function criarSessoes(array $data, $criarCookies = FALSE)
    {
        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
            if ($criarCookies) {
                setcookie($key, $value, time() + 3600, '/');
            }
        }
    }

    /**
     * Faz o Login no Sistema
     * 
     * @param EntityManager $em            
     * @param unknown $login            
     * @param unknown $senha            
     * @return boolean
     */
    public function login(EntityManager $em, $login, $senha)
    {
        $rp = $em->getRepository($this->class);
        $result = $rp->login($login, $senha);
        if ($result) {
            $this->criarSessoes([
                'user' => $_POST['login']
            ]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Faz o logout no sistema
     *
     * @return boolean
     */
    public function logout()
    {
        try {
            if (isset($_COOKIE['user'])) {
                setcookie('user', '', time() - 3600, '/');
            }
            unset($_SESSION['user']);
            session_destroy();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Verifica se o usuário se encontra logado no sistema
     *
     * @return boolean
     */
    public function logado()
    {
        if ((isset($_SESSION['user'])) || (isset($_COOKIE['user']))) {
            return true;
        }
        return false;
    }
}