<?php

namespace Digital;

class Paginator
{
    /*
     * escolha de 5 botoes (nao temos um botao ...
     * o botao anterior so aparece quando nao for a primeira pagina
     * 1 2 3 4 5 >
     * < 2 3 4 5 6 >
     * < 3 4 5 6 7 >
     * < 5 6 7 8 9
     * e some quando chega no ultimo (ou nao precise ser exibido) e mantem os mesmos botoes
     *
     * 1 2 3 4 5 >
     * cliquei no 3...
     * < 3 4 5 6 7 >
     */
    private $botoes = BOTOES; // quantidade de botoes a serem exibidos
    private $registroAtual; // registro atual
    private $proximoRegistro; // proximo registro
    private $buscaCampo; //campo a ser usado na busca
    private $buscaCriterio;    //criterio usado (igual, diferente, etc)
    private $buscaTermo;    //termo a ser buscado
    private $quantidadePorPagina = POR_PAGINA;    //quantidade de registro mostrados por pagina (LIMIT)
    private $offset;    //proxima sequencia
    private $resultadosEncontrados;    //quantidade de resultados encontrados
    private $paginadorAtivo;    //indica se o paginador vai ser mostrado
    private $alvo;
    
	public function getBotoes() {
		return $this->botoes;
	}
	public function setBotoes($botoes) {
		$this->botoes = $botoes;
	}
	public function getRegistroAtual() {
		return $this->registroAtual;
	}
	public function setRegistroAtual($registroAtual) {
		$this->registroAtual = $registroAtual;
	}
	public function getProximoRegistro() {
		return $this->proximoRegistro;
	}
	public function setProximoRegistro($proximoRegistro) {
		$this->proximoRegistro = $proximoRegistro;
	}
	public function getBuscaCampo() {
		return $this->buscaCampo;
	}
	public function setBuscaCampo($buscaCampo) {
		$this->buscaCampo = $buscaCampo;
	}
	public function getBuscaCriterio() {
		return $this->buscaCriterio;
	}
	public function setBuscaCriterio($buscaCriterio) {
		$this->buscaCriterio = $buscaCriterio;
	}
	public function getBuscaTermo() {
		return $this->buscaTermo;
	}
	public function setBuscaTermo($buscaTermo) {
		$this->buscaTermo = $buscaTermo;
	}
	public function getQuantidadePorPagina() {
		return $this->quantidadePorPagina;
	}
	public function setQuantidadePorPagina($quantidadePorPagina) {
		$this->quantidadePorPagina = $quantidadePorPagina;
	}
	public function getOffset() {
		return $this->offset;
	}
	public function setOffset($offset) {
		$this->offset = $offset;
	}
	public function getResultadosEncontrados() {
		return $this->resultadosEncontrados;
	}
	public function setResultadosEncontrados($resultadosEncontrados) {
		$this->resultadosEncontrados = $resultadosEncontrados;
	}
	public function getPaginadorAtivo() {
		return $this->paginadorAtivo;
	}
	public function setPaginadorAtivo($paginadorAtivo) {
		$this->paginadorAtivo = $paginadorAtivo;
	}
	public function getAlvo() {
		return $this->alvo;
	}
	public function setAlvo($alvo) {
		$this->alvo = $alvo;
	}
	
	    //indica o alvo do get

   


}