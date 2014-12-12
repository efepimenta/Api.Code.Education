<?php

namespace Digital\Service;

use Digital\Database;

class LoginService
{

	public function criarSessoes(array $data) {

		foreach ( $data as $key => $value ) {
			$_SESSION[$key] = $value;
			setcookie($key, $value, time() + 3600, '/');
		}
	
	}

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

	public function logout() {

		setcookie('user', '', time() - 3600, '/');
		unset($_SESSION['user']);
		session_destroy();
		return true;
	
	}

	public function logado() {

		if ((isset($_POST['user'])) || (isset($_COOKIE['user']))) {
			return true;
		}
		return false;
	
	}

}