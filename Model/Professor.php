<?php

class Professor{
 private $id;
 private $nome;
private $cpf; 
private $email;
 

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

function atualizar($atributos) {
    foreach ($atributos as $atributo => $valor) {
        if(isset($valor) && property_exists(get_class($this), $atributo)){			
            $this->$atributo = $valor;				
        }
    }
}

public function getId() {
    return $this->id;
}



public function getEmail() {
    return $this->email;
}

public function getSenha() {
    return $this->senha;
}

public function setId($id) {
    $this->id = $id;
}


public function setEmail($email) {
    $this->email = $email;
}

public function setSenha($senha) {
    $this->senha = $senha;
}

public function setCpf($cpf) {
    $this->cpf = $cpf;
}

public function getcpf() {
    return $this->cpf;
}

public function getNome() {
    return $this->nome;
}

public function setNome($nome) {
    $this->nome = $nome;
}

}


?>