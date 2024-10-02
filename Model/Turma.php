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
    
}
?>