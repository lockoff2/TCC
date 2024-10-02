<?php
class Aluno{
    private $id;
    private $nome;
    private $email;
    private $cpf;
    private $curso;
    private $senha;

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