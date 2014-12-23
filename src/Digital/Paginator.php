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
	private $botoes = BOTOES;
	private $botoesTotais;
	private $atual;
	private $proximo;
	private $campo;
	private $criterio;
	private $termo;
	private $quantidade = POR_PAGINA;
	private $resultados;
	private $ativo;

	public function getBotoes() {

		return $this->botoes;
	
	}

	public function setBotoes($botoes) {

		$this->botoes = $botoes;
		return $this;
	
	}

	public function getCampo() {

		return $this->campo;
	
	}

	public function setCampo($campo) {

		$this->campo = $campo;
		return $this;
	
	}

	public function getCriterio() {

		return $this->criterio;
	
	}

	public function setCriterio($criterio) {

		$this->criterio = $criterio;
		return $this;
	
	}

	public function getTermo() {

		return $this->termo;
	
	}

	public function setTermo($termo) {

		$this->termo = $termo;
		return $this;
	
	}

	public function getQuantidade() {

		return $this->quantidade;
	
	}

	public function setQuantidade($quantidade) {

		$this->quantidade = $quantidade;
		return $this;
	
	}

	public function getResultados() {

		return $this->resultados;
	
	}

	public function setResultados($resultados) {

		$this->resultados = $resultados;
		return $this;
	
	}

	public function getAtual() {

		return $this->atual;
	
	}

	public function setAtual($atual) {

		$this->atual = $atual;
		return $this;
	
	}

	public function getBotoesTotais() {

		return $this->botoesTotais;
	
	}

	public function setBotoesTotais($botoesTotais) {

		$this->botoesTotais = $botoesTotais;
		return $this;
	
	}

	public function getProximo() {

		return $this->proximo;
	
	}

	public function setProximo($proximo) {

		$this->proximo = $proximo;
		return $this;
	
	}

	public function getAtivo() {

		return $this->ativo;
	
	}

	public function setAtivo($ativo) {

		$this->ativo = $ativo;
		return $this;
	
	}
	
	
	
	
	

}