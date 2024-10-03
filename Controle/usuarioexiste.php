
<?php


	include_once  __DIR__ . '/../Model/Usuario.php';
	include_once 'addusuario.php';

	if(isset($_POST['email']) and isset($_POST['cpf']) and isset($_POST['nome']) and isset($_POST['senha'])and isset($_POST['cidade'])){ 
		
		$usuario = new Usuario();
	    $email = $_POST['email'];
	 	$cpf = $_POST['cpf'];
        $usuario->setNome($_POST['nome']);
		$usuario->setSenha($_POST['senha']);
		$usuario->setCidade($_POST['cidade']);
	 	$usuario->setEmail($email);
		$usuario->setCpf($cpf);
	 	
	 	$conexao = new Conexao();
        $conexao = $conexao->conexao();
        $stmt = $conexao->prepare('SELECT * FROM usuario WHERE email = "'.$email.'"');
        $stmt->execute();
		
		$stmt2 = $conexao->prepare('SELECT * FROM usuario WHERE cpf = "'.$cpf.'"');
        $stmt2->execute();
       
        $count2 = $stmt2->rowCount();
		$count = $stmt->rowCount();
		
	    if($count > 0){
	        echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../../vendinha/cadastro.php'>
				<script type=\"text/javascript\">
					alert(\"Email já existente, por favor digite outro!\");
				</script>
				";
	    }else if( $count2 > 0){
	        echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../../vendinha/cadastro.php'>
				<script type=\"text/javascript\">
					alert(\"Cpf já existente, por favor digite outro!\");
				</script>
				";
		}else{
	    	addCliente($usuario);
	    }
	}
?>