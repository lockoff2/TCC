<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../Banco/conexao.php';
include_once '../Controle/controlealuno.php';
include_once '../Controle/controleprofessor.php';

$aluno = new controlealuno();
$professor = new controleprofessor();


if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $conexao = new Conexao();
    $conexao = $conexao->conexao();

    $stmtAluno = $conexao->prepare("SELECT * FROM aluno WHERE email = :email AND senha = :senha");
    $stmtAluno->bindParam(':email', $email);
    $stmtAluno->bindParam(':senha', $senha);
    $stmtAluno->execute();

    $stmtProfessor = $conexao->prepare("SELECT * FROM professor WHERE email = :email AND senha = :senha");
    $stmtProfessor->bindParam(':email', $email);
    $stmtProfessor->bindParam(':senha', $senha);
    $stmtProfessor->execute();

    if ($stmtAluno->rowCount() > 0) {

        if ($aluno->login($email, $senha)) {
            header('Location:Aluno.php');
        } else {
            echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL= login.php'>
						    <script type=\"text/javascript\">
							    alert(\"Senha ou email incorretos!\");
						    </script>
						    ";
    } 

    } elseif($stmtProfessor->rowCount() > 0){
        if ($professor->login($email, $senha)) {
            header('Location:Professor.php');
        } else {
            echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL= login.php'>
						    <script type=\"text/javascript\">
							    alert(\"Senha ou email incorretos!\");
						    </script>
						    ";
        }
    }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Cadastro</title>
    <link rel="stylesheet" type="text/css" href="../CSS/login.css">
    <script type="text/javascript" src="../JS/login.js"></script>
    <script>
        function navAnuncios() {
            var anuncio = document.getElementById("anuncios");
            if (anuncio.onclick) {
                alert("Você precisa logar no sistema!");
            }

        }
    </script>
</head>

<body>
    <header>
        <h1 href="index.php">Desapego da ADS</h1>
    </header>
    <nav>
        <a href="index.php">Início</a>
        <a id="anuncios" href="#">Anúncios</a>
    </nav>
    <div class="container">
        <div class="form-container">
            <div class="login-form">
                <h2>Login</h2>
                <form action="#" method="post">
                    <label>Email:</label><br>
                    <input type="email" id="email" name="email" required><br>
                    <label>Senha:</label><br>
                    <input type="password" id="senha" name="senha" required><br>
                    <input type="submit" value="entrar" name="entrar" id="entrar">
                </form>
                <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Site de Venda de Usados</p>
    </footer>

</body>

</html>