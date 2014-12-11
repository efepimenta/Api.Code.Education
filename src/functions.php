<?php

use Digital\Database;

/**
 * Retorna a uri atual, com ou sem o .php
 * @param boolean $dotPHP
 * @return string
 */
function currentUri($dotPHP = false)
{
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
 * Verifica se a rota passada existe
 * @param string $uri
 * @param Database $db
 */
function routeExists($uri, Database $db)
{
	$sql = 'select rota from rotas where rota = "' . $uri . '"';
	$result = $db->select($sql, true, []);
	return is_array($result);
}

/**
 * Monta um menu estilo bootstrap com os dados da tabela
 * @param Database $database
 * @return array
 */
function montaMenu(Database $database){
	$result = $database->select('SELECT nome,kind,sequencia,posicao,imagem,(select rota from rotas where id = menu.id_rota) as rota,fim  FROM menu
 		ORDER BY sequencia,posicao');
	$menu = null;
	foreach ($result as $res) {
		$menu[$res['sequencia']][] = $res;
		//        sort($menu[$res['sequencia']],SORT_ASC);
	}
	return $menu;
}