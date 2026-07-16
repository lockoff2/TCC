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

    } elseif ($stmtProfessor->rowCount() > 0) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../CSS/login.css">
    <script type="text/javascript" src="../JS/login.js"></script>
</head>

<body class="bg-light">

    <div class="container vh-100 d-flex justify-content-center align-items-center">

        <div class="card shadow-lg" style="width:420px; border-radius:15px;">

            <div class="card-body p-5">

                <h2 class="text-center text-primary mb-2">
                    CodeQuiz
                </h2>

                <p class="text-center text-muted mb-4">
                    Ambiente Interativo para Programação
                </p>

                <form method="post">

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email" class="form-control" name="email" placeholder="Digite seu email" required>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">
                            Senha
                        </label>

                        <input type="password" class="form-control" name="senha" placeholder="Digite sua senha"
                            required>

                    </div>

                    <div class="d-grid">

                        <button class="btn btn-primary btn-lg" name="entrar">

                            Entrar

                        </button>

                    </div>

                </form>

                <hr>

                <div class="text-center">

                    Não possui uma conta?

                    <br>

                    <a href="cadastro.php">
                        Cadastre-se
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>