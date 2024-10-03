
<?php
	
	class Conexao{

	    private $usuario = 'root';
	    private $senha = '';

	    /**
	 	* Conecta com o MySQL usando PDO
	 	*/
		public function conexao(){
	    	return new PDO('mysql:host=localhost;dbname=bdoa; charset=utf8', $this->usuario, $this->senha);
		}

		function encerrar(){
			return null;
		}
	}   
?>