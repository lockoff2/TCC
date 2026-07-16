<?php
class Opcoes
{
	private $id;
	private $conteudo;
	private $resposta;
	private $questaoid;



	public function __construct()
	{
		if (func_num_args() != 0) {
			$atributos = func_get_args()[0];
			foreach ($atributos as $atributo => $valor) {
				if (isset($valor) && property_exists(get_class($this), $atributo)) {
					$this->$atributo = $valor;
				}
			}
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function getConteudo()
	{
		return $this->conteudo;
	}

	public function getResposta()
	{
		return $this->resposta;
	}

	public function setId($id)
	{
		$this->id = $id;
	}


	public function setConteudo($conteudo)
	{
		$this->conteudo = $conteudo;
	}

	public function setResposta($resposta)
	{
		$this->resposta = $resposta;
	}

	public function setQuestaoid($questaoid)
	{
		$this->questaoid = $questaoid;
	}

	public function getQuestaoid()
	{
		return $this->questaoid;
	}


}
?>