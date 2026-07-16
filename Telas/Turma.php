<?php
session_start();
include_once '../Controle/controleturma.php';
include_once '../Controle/controleprofessor.php';

$turmaCtrl = new controleturmma();
$professorCtrl = new controleprofessor();

if (!$professorCtrl->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$professorId = $_SESSION['user_id'];
$turmas = $turmaCtrl->listarTurmasProfessor($professorId);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Turmas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../CSS/cadastro.css">

    <script>
        function confirmarExclusao(idTurma) {
            if (confirm('Você realmente deseja apagar esta turma?')) {
                window.location.href = '../Controle/apagarturma.php?idturma=' + idTurma;
            }
        }
    </script>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">

        <div class="container">

            <a class="navbar-brand fw-bold" href="Professor.php">
                CodeQuiz
            </a>

            <div class="ms-auto">

                <a href="Professor.php" class="btn btn-outline-light me-2">
                    Início
                </a>

                <a href="../Controle/sair.php" class="btn btn-light">
                    Sair
                </a>

            </div>

        </div>

    </nav>

    <div class="container mt-5">

        <h2 class="text-center mb-4">
            Gerenciar Turmas
        </h2>

        <div class="card shadow-lg">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    Suas Turmas
                </h4>

                <a href="cadastrarTurma.php" class="btn btn-light">
                    Nova Turma
                </a>

            </div>

            <div class="card-body">

                <?php if (empty($turmas)): ?>

                    <div class="alert alert-warning text-center">

                        <h5>Nenhuma turma cadastrada.</h5>

                        <p>Cadastre sua primeira turma para começar.</p>

                        <a href="cadastrarTurma.php" class="btn btn-primary">
                            Cadastrar Turma
                        </a>

                    </div>

                <?php else: ?>

                    <table class="table table-hover table-bordered align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>Nome</th>

                                <th>Descrição</th>

                                <th class="text-center">Gerenciar Alunos</th>

                                <th class="text-center">Excluir</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($turmas as $turma): ?>

                                <tr>

                                    <td><?= htmlspecialchars($turma['nome']) ?></td>

                                    <td><?= htmlspecialchars($turma['descricao']) ?></td>

                                    <td class="text-center">

                                        <a href="Gerenciaralunos.php?idTurma=<?= $turma['id']; ?>" class="btn btn-success">
                                            Gerenciar
                                        </a>

                                    </td>

                                    <td class="text-center">

                                        <button class="btn btn-danger" onclick="confirmarExclusao(<?= $turma['id']; ?>)">
                                            Excluir
                                        </button>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <footer class="bg-primary text-white text-center py-3 mt-5">
        &copy; 2024 CodeQuiz
    </footer>

</body>

</html>