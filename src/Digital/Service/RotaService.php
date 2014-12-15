<?php

namespace Digital\Service;

use Digital\Database;

class RotaService
{

	/**
	 * Reotrna a uri atual, com ou sem o .
	 * php
	 * 
	 * @param bool $dotPHP        	
	 * @return string
	 */
	function currentUri($dotPHP = false) {

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
		}
		else {
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
	 * Verifica se a rota passada existe
	 *
	 * @param string $uri        	
	 * @param Database $database        	
	 */
	function routeExists($uri, Database $database) {

		$sql = 'select rota from rotas where rota = "' . $uri . '"';
		$result = $database->select($sql, true, []);
		return is_array($result);
	
	}

}