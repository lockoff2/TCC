<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../CSS/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <header>
        <h1>Nome Ver</h1>
    </header>
    <nav>
        <a href="index.php">Início</a>
        <a href="#">Sobre</a>
    </nav>
    <div class="container">
        <div class="form-container">
            <h2>Cadastro</h2>
            <form action="../Controle/usuarioexiste.php" method="post">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipoUsuario" id="aluno" value="Aluno">
                    <label class="form-check-label" for="aluno">Aluno</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipoUsuario" id="professor" value="Professor"
                        checked>
                    <label class="form-check-label" for="professor">Professor</label>
                </div>
                <label class="form-label">Nome:</label><br>
                <input type="text" id="nome" name="nome" required><br>
                <label class="form-label">Email:</label><br>
                <input type="email" id="email" name="email" required><br>
                <label class="form-label">Senha:</label><br>
                <input type="password" id="senha" name="senha" required><br>
                <label class="form-label">Endereço:</label><br>
                <input type="text" id="cidade" name="cidade"><br>
                <label class="form-label">CPF:</label><br>
                <input type="text" id="cpf" name="cpf"><br>
                <input type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Site de Venda de Usados</p>
    </footer>
</body>

</html>