<?php
class Turma{
    private $id;
    private $nome;
    private $descricao;
    private $professorid;
    private $alunoid;

    public function __construct() {
		if (func_num_args() != 0) {
			$atributos = func_get_args()[0];
			foreach ($atributos as $atributo => $valor) {
				if(isset($valor) && property_exists(get_class($this), $atributo)){
					$this->$atributo = $valor;					
				}
			}
		}
	}
    
	public function getId() {
		return $this->id;
	}
	
	
	public function getNome() {
		return $this->nome;
	}
	
	public function getDescricao() {
		return $this->descricao;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	
	public function setNome($nome) {
		$this->nome = $nome;
	}
	
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}
	
	public function setProfessorid($professorid) {
		$this->professorid = $professorid;
	}
	
	public function getProfessorid() {
		return $this->professorid;
	}
	
	public function getAlunoid() {
		return $this->alunoid;
	}
	
	public function setAlunoid($alunoid) {
		$this->alunoid = $alunoid;
	}
	
	}


?>