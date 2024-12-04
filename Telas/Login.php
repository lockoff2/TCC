<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'Banco/conexao.php';
include_once 'Controle/controleusuario.php';

$user = new controleusuario();

if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($user->login($email, $senha)) {
        header('Location:Index.php');
    } else {
        echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL= login.php'>
						<script type=\"text/javascript\">
							alert(\"Senha ou email incorretos!\");
						</script>
						";
    }
}

$result = $user->isLoggedIn();
if ($result) {
    header('Location:index.php');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Cadastro</title>
    <link rel="stylesheet" type="text/css" href="CSS/login.css">
    <script type="text/javascript" src="JS/login.js"></script>
    <script>function navAnuncios() {
            var anuncio = document.getElementById("anuncios");
            if (anuncio.onclick) {
                alert("Você precisa logar no sistema!");
            }

        }</script>
</head>

<body>
    <header>
        <h1 href="index.php">Loja Virtual de Ingressos</h1>
    </header>
    <nav>
        <a href="index.php">Início</a>
      
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
                    <input type="submit" value="Entrar" name="entrar" id="entrar">
                </form>
                <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Site de Venda de Ingressos</p>
    </footer>

</body>

</html>