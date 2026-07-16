<?php
session_start();
include_once '../Controle/controlequestionario.php';
include_once '../Controle/controlealuno.php';
include_once '../Controle/controleturma.php';

$questionarioCtrl = new controlequestionario();
$alunoCtrl = new controlealuno();
$turmaCtrl = new controleturmma();


if (!$alunoCtrl->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$idAluno = $_SESSION['user_id'];


$alunoDados = $alunoCtrl->buscarPorId($idAluno);

$turmas = $turmaCtrl->buscarTurmasPorAluno($alunoDados['id']);

$idsTurmas = array_column($turmas, 'id');

$questionarios = $questionarioCtrl->listarQuestionariosPorVariasTurmas($idsTurmas);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionários Disponíveis</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/cadastro.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

        <div class="container">

            <a class="navbar-brand" href="Aluno.php">
                CodeQuiz
            </a>

            <div class="ms-auto">

                <a href="Aluno.php" class="btn btn-outline-light me-2">
                    Início
                </a>

                <a href="../Controle/sair.php" class="btn btn-light">
                    Sair
                </a>

            </div>

        </div>

    </nav>

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-10">

                <div class="card shadow border-0">

                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            Questionários Disponíveis
                        </h3>
                    </div>

                    <div class="card-body">

                        <p class="text-muted mb-4">
                            Questionários disponíveis para as turmas em que você está matriculado.
                        </p>

                        <?php if (empty($questionarios)): ?>

                            <div class="alert alert-warning text-center">
                                Nenhum questionário disponível para sua turma no momento.
                            </div>

                        <?php else: ?>

                            <div class="table-responsive">

                                <table class="table table-hover align-middle">

                                    <thead class="table-dark">

                                        <tr>
                                            <th>Título</th>
                                            <th>Descrição</th>
                                            <th class="text-center" width="170">
                                                Participar
                                            </th>
                                            <th class="text-center" width="170">
                                                Resultado
                                            </th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($questionarios as $questionario): ?>

                                            <tr>

                                                <td>
                                                    <?= htmlspecialchars($questionario['titulo']); ?>
                                                </td>

                                                <td>
                                                    <?= htmlspecialchars($questionario['descricao']); ?>
                                                </td>

                                                <td class="text-center">

                                                    <a href="teste.php?questionario_id=<?= $questionario['id']; ?>&aluno_id=<?= $idAluno; ?>"
                                                        class="btn btn-success">
                                                        Participar
                                                    </a>

                                                </td>

                                                <td class="text-center">

                                                    <a href="resultadoAluno.php?questionario_id=<?= $questionario['id']; ?>&aluno_id=<?= $idAluno; ?>"
                                                        class="btn btn-primary">
                                                        Resultado
                                                    </a>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p class="mb-0">&copy; 2024 CodeQuiz</p>
    </footer>

</body>

</html>