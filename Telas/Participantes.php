<?php
session_start();

include_once '../Controle/controlealuno.php';
include_once '../Controle/controleturma.php';
include_once '../Controle/controleprofessor.php';

$alunoCtrl = new controlealuno();
$turmaCtrl = new controleturmma();
$professorCtrl = new controleprofessor();

if (!$professorCtrl->isLoggedIn()) {
    header('Location: ../Telas/login.php');
    exit;
}

$idTurma = $_GET['idTurma'] ?? null;

if (!$idTurma) {
    echo "Turma inválida!";
    exit;
}

// LISTA ALUNOS
$alunos = $alunoCtrl->listarAlunosPorTurma($idTurma);
$todosAlunos = $alunoCtrl->todosalunos();

// BUSCA O PROFESSOR DA TURMA
$turmaInfo = $turmaCtrl->buscarTurmaPorId($idTurma);
$professorTurma = $professorCtrl->buscarPorId($turmaInfo['professorid']);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participantes da Turma</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/cadastro.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">

        <div class="container">

            <a class="navbar-brand fw-bold" href="Aluno.php">
                CodeQuiz
            </a>

            <div class="ms-auto">

                <a href="Aluno.php" class="btn btn-outline-light me-2">
                    Início
                </a>

                <a href="Turmaaluno.php" class="btn btn-outline-light me-2">
                    Turmas
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

                <!-- Professor -->

                <div class="card shadow mb-4">

                    <div class="card-header bg-primary text-white">

                        <h4 class="mb-0">
                            Professor Responsável
                        </h4>

                    </div>

                    <div class="card-body">

                        <?php if (!empty($professorTurma)): ?>

                            <p class="mb-2">
                                <strong>Nome:</strong>
                                <?php echo htmlspecialchars($professorTurma['nome']); ?>
                            </p>

                            <p class="mb-0">
                                <strong>Email:</strong>
                                <?php echo htmlspecialchars($professorTurma['email']); ?>
                            </p>

                        <?php else: ?>

                            <div class="alert alert-danger mb-0">
                                Professor não encontrado.
                            </div>

                        <?php endif; ?>

                    </div>

                </div>

                <!-- Alunos -->

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">

                        <h4 class="mb-0">

                            Alunos da Turma:
                            <?php echo htmlspecialchars($turmaInfo['nome']); ?>

                        </h4>

                    </div>

                    <div class="card-body">

                        <?php if (empty($alunos)): ?>

                            <div class="alert alert-warning text-center mb-0">

                                Nenhum aluno está matriculado nesta turma.

                            </div>

                        <?php else: ?>

                            <div class="table-responsive">

                                <table class="table table-hover align-middle">

                                    <thead class="table-dark">

                                        <tr>

                                            <th>Nome</th>

                                            <th>Email</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($alunos as $aluno): ?>

                                            <tr>

                                                <td>

                                                    <?php echo htmlspecialchars($aluno['nome']); ?>

                                                </td>

                                                <td>

                                                    <?php echo htmlspecialchars($aluno['email']); ?>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

                <div class="text-center mt-4">

                    <a href="Turmaaluno.php" class="btn btn-primary">

                        Voltar para Turmas

                    </a>

                </div>

            </div>

        </div>

    </div>

    <footer class="bg-dark text-white text-center py-3">

        © 2024 CodeQuiz

    </footer>

</body>

</html>