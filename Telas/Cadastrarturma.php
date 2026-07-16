<?php
session_start();
include_once '../Controle/controleprofessor.php';
$user = new controleprofessor();

if (!$user->isLoggedIn()) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Turma</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../CSS/cadastro.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">

        <div class="container">

            <a class="navbar-brand" href="Professor.php">
                CodeQuiz
            </a>

            <div class="ms-auto">

                <a href="Professor.php" class="btn btn-outline-light me-2">
                    Início
                </a>

                <a href="Turma.php" class="btn btn-outline-light me-2">
                    Suas Turmas
                </a>

                <a href="../Controle/sair.php" class="btn btn-light">
                    Sair
                </a>

            </div>

        </div>

    </nav>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">

                        <h4 class="mb-0">
                            Cadastrar Nova Turma
                        </h4>

                    </div>

                    <div class="card-body">

                        <form action="../Controle/cadastroturma.php" method="post" enctype="multipart/form-data">

                            <div class="mb-3">

                                <label class="form-label">
                                    Nome da Turma
                                </label>

                                <input type="text" name="nomeTurma" class="form-control" required>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Descrição
                                </label>

                                <textarea name="descricao" rows="4" class="form-control" required></textarea>

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    Selecione os Alunos
                                </label>

                                <select id="alunos" name="alunos[]" class="form-control" multiple>

                                    <?php
                                    include_once '../Controle/controlealuno.php';

                                    $aluno = new controlealuno();

                                    $alunos = $aluno->todosalunos();

                                    foreach ($alunos as $aluno) {
                                        echo "<option value='{$aluno['id']}'>{$aluno['nome']}</option>";
                                    }
                                    ?>

                                </select>

                            </div>

                            <div class="text-center">

                                <input type="submit" name="enviar" value="Cadastrar Turma" class="btn btn-primary px-5">

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#alunos').select2({

                placeholder: "Selecione os alunos",

                width: '100%',

                allowClear: true

            });

        });
    </script>

    <footer class="bg-primary text-white text-center py-3 mt-5">

        &copy; 2024 CodeQuiz

    </footer>

</body>

</html>