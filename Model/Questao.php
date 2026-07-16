<?php
class Questao
{
	private $id;
	private $titulo;
	private $descricao;
	private $tipo;
	private $professorid;

	private $questionarioid;


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

	public function getTitulo()
	{
		return $this->titulo;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getQuestionarioid()
	{
		return $this->questionarioid;
	}

	public function setQuestionarioId($questionarioid)
	{
		$this->questionarioid = $questionarioid;
	}
	public function setId($id)
	{
		$this->id = $id;
	}


	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	public function setProfessorid($professorid)
	{
		$this->professorid = $professorid;
	}

	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}

	public function getProfessorid()
	{
		return $this->professorid;
	}

	public function getTipo()
	{
		return $this->tipo;
	}

	public function setTipo($tipo)
	{
		$this->tipo = $tipo;
	}


}
?>