<?php

namespace Digital\Service;

use Digital\Database;
class MenuService
{
	private $database;
	
	public function __construct(Database $database){
		$this->database = $database;
	}
	
	/**
	 * Monta um menu estilo bootstrap com os dados da tabela
	 * @param Database $database
	 * @return array
	 */
	function montaMenu(){
		$result = $this->database->select('SELECT nome,kind,sequencia,posicao,imagem,(select rota from rotas where id = menu.id_rota) as rota,fim  FROM menu
 		ORDER BY sequencia,posicao');
		$menu = null;
		foreach ($result as $res) {
			$menu[$res['sequencia']][] = $res;
			//        sort($menu[$res['sequencia']],SORT_ASC);
		}
		return $menu;
	}
}