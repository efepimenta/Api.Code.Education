<?php
use Digital\Paginator;
use Doctrine\ORM\EntityManager;

/**
 * define a quantidade de botoes a serem usados no paginator
 * @param Paginator $paginator
 */
function defineBotoes(Paginator $paginator)
{

    if ($paginator->getResultadosEncontrados() % $paginator->getQuantidadePorPagina() != 0) {
        $botoes = intval($paginator->getResultadosEncontrados() / $paginator->getQuantidadePorPagina()) + 1;
    } else {
        $botoes = intval($paginator->getResultadosEncontrados() / $paginator->getQuantidadePorPagina());
    }
    if ($botoes == 0) {
        $botoes = 1;
    }
    if ($botoes > BOTOES) {
        $botoes = BOTOES;
    }
    $paginator->setBotoes($botoes);
}


/**
 * remove todos os caracteres nao numericos
 * @param unknown $str
 * @return mixed
 */
function soNumero($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

/**
 * formata um valor para ser incluso no banco de dados
 * @param $valor
 * @return string
 */
function formatFloat($valor)
{
    if (isset($valor)) {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valor = str_replace('R$ ', '', $valor);
        $valor = number_format($valor, CASAS_DECIMAIS, '.', '');
        return $valor;
    }
}

/**
 * formata um valor inteiro colocando os pontos decimais
 * @param unknown $valor
 * @return string
 */
function formatarValor($valor)
{

    $valor = soNumero($valor);
    if (strlen($valor) < 3) {
        $valor = str_pad($valor, 4, "0", STR_PAD_LEFT);
    }
    $num = str_split($valor, strlen($valor) - CASAS_DECIMAIS);
    $valor = $num[0] . '.' . $num[1];
    $valor = number_format($valor, CASAS_DECIMAIS, ',', '.');
    return $valor;
}