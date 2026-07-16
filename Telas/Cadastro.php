<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro - CodeQuiz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .card-header {
            background: #0d6efd;
            color: white;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            border-radius: 15px 15px 0 0 !important;
        }

        .btn-primary {
            width: 100%;
            height: 45px;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-6">

                <div class="card shadow">

                    <div class="card-header">

                        CodeQuiz

                    </div>

                    <div class="card-body p-4">

                        <h3 class="text-center mb-4">
                            Cadastro de Usuário
                        </h3>

                        <form action="../Controle/usuarioexiste.php" method="post">

                            <label class="form-label">
                                Tipo de Usuário
                            </label>

                            <div class="mb-3">

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="radio" name="tipoUsuario" value="Aluno">

                                    <label class="form-check-label">
                                        Aluno
                                    </label>

                                </div>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="radio" name="tipoUsuario" value="Professor"
                                        checked>

                                    <label class="form-check-label">
                                        Professor
                                    </label>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Nome
                                </label>

                                <input type="text" class="form-control" name="nome" required>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email" class="form-control" name="email" required>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Senha
                                </label>

                                <input type="password" class="form-control" name="senha" required>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Curso
                                </label>

                                <input type="text" class="form-control" name="cidade">

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    CPF
                                </label>

                                <input type="text" class="form-control" name="cpf">

                            </div>

                            <button type="submit" class="btn btn-primary">

                                Cadastrar

                            </button>

                        </form>

                        <hr>

                        <div class="text-center">

                            Já possui uma conta?

                            <br>

                            <a href="login.php">
                                Fazer Login
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>