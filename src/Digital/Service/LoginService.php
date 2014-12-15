<?php

namespace Digital\Service;

use Digital\Database;

class LoginService
{

	/**
	 * Cria as sessões e os Cookies (se criarCookies for true)
	 *
	 * @param array $data        	
	 * @param string $criarCookies        	
	 */
	public function criarSessoes(array $data, $criarCookies=FALSE) {

		foreach ( $data as $key => $value ) {
			$_SESSION[$key] = $value;
			if ($criarCookies) {
				setcookie($key, $value, time() + 3600, '/');
			}
		}
	
	}

	/**
	 * Faz o login no sistema
	 *
	 * @param Database $database        	
	 * @param unknown $login        	
	 * @param unknown $senha        	
	 * @return boolean
	 */
	public function login(Database $database, $login, $senha) {

		$sql = 'SELECT login,senha FROM usuarios WHERE login = :login';
		$values = ['login' => [$login => \PDO::PARAM_STR]];
		$result = $database->select($sql, true, $values);
		if (isset($result['login'])) {
			if (password_verify($senha, $result['senha'])) {
				$this->criarSessoes(['user' => $_POST['login']]);
				return true;
			}
			return false;
		}
		return false;
	
	}

	/**
	 * Faz o logout no sistema
	 *
	 * @return boolean
	 */
	public function logout() {

		try {
			if (isset($_COOKIE['user'])) {
				setcookie('user', '', time() - 3600, '/');
			}
			unset($_SESSION['user']);
			session_destroy();
			return true;
		}
		catch ( Exception $e ) {
			return false;
		}
	
	}

	/**
	 * Verifica se o usuário se encontra logado no sistema
	 *
	 * @return boolean
	 */
	public function logado() {

		if ((isset($_SESSION['user'])) || (isset($_COOKIE['user']))) {
			return true;
		}
		return false;
	
	}

}