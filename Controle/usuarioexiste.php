<?php


	include_once  __DIR__ . '/../Model/Aluno.php';
	include_once  __DIR__ . '/../Model/Professor.php';
	include_once 'addAluno.php';
	include_once 'addProfessor.php';

	if (isset($_POST['email'], $_POST['cpf'], $_POST['nome'], $_POST['senha'], $_POST['cidade'], $_POST['tipoUsuario'])) { 
		$aluno = new Aluno();
		$professor = new Professor();
		$email = $_POST['email'];
		$cpf = $_POST['cpf'];
	

		$tipo = $_POST['tipoUsuario'];
	
		if (!$tipo) {
			echo "
				<script type=\"text/javascript\">
					alert(\"Por favor, selecione se você é Aluno ou Professor.\");
				</script>
			";
			exit;
		}
	
	 	$conexao = new Conexao();
        $conexao = $conexao->conexao();
        $stmtEmail = $conexao->prepare('SELECT * FROM aluno WHERE email = :email UNION SELECT * FROM professor WHERE email = :email');
    	$stmtEmail->bindParam(':email', $email);
    	$stmtEmail->execute();

    	$stmtCpf = $conexao->prepare('SELECT * FROM aluno WHERE cpf = :cpf UNION SELECT * FROM professor WHERE cpf = :cpf');
    	$stmtCpf->bindParam(':cpf', $cpf);
    	$stmtCpf->execute();

    	$countEmail = $stmtEmail->rowCount();
   	 	$countCpf = $stmtCpf->rowCount();
		
	    if($countEmail > 0){
	        echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../../vendinha/cadastro.php'>
				<script type=\"text/javascript\">
					alert(\"Email já existente, por favor digite outro!\");
				</script>
				";
	    }else if( $countCpf > 0){
	        echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../../vendinha/cadastro.php'>
				<script type=\"text/javascript\">
					alert(\"Cpf já existente, por favor digite outro!\");
				</script>
				";
		}else{
	    	if ($tipo === "Aluno") {
				$aluno->setNome($_POST['nome']);
				$aluno->setSenha($_POST['senha']);
				$aluno->setEmail($email);
				$aluno->setCpf($cpf);
				addAluno($aluno);
			} elseif ($tipo === "Professor") {
				$professor->setNome($_POST['nome']);
				$professor->setSenha($_POST['senha']);
				$professor->setEmail($email);
				$professor->setCpf($cpf);
				addProfessor($professor); 
			}
	    }
	}
?>