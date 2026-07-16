<?php
session_start();
include_once '../Controle/controlequestionario.php';
include_once '../Controle/controleprofessor.php';

$questionarioCtrl = new controlequestionario();
$professorCtrl = new controleprofessor();

if (!$professorCtrl->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$professorId = $_SESSION['user_id'];
$questionarios = $questionarioCtrl->listarQuestionariosProfessor($professorId);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Questionários</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../CSS/cadastro.css">

    <script>
        function confirmarExclusao(idQuestionario) {
            if (confirm('Você realmente deseja apagar este questionário?')) {
                window.location.href = '../Controle/apagarquestionario.php?idquestionario=' + idQuestionario;
            }
        }
    </script>

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

                <a href="../Controle/sair.php" class="btn btn-light">
                    Sair
                </a>

            </div>

        </div>

    </nav>

    <div class="container mt-5">

        <h2 class="text-center mb-4">
            Gerenciar Questionários
        </h2>

        <div class="card shadow">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    Seus Questionários
                </h4>

                <a href="CadastroQuestionario.php" class="btn btn-light">
                    Novo Questionário
                </a>

            </div>

            <div class="card-body">

                <?php if (empty($questionarios)): ?>

                    <div class="alert alert-warning text-center">

                        <h5>Nenhum questionário cadastrado.</h5>

                        <p>Cadastre seu primeiro questionário.</p>

                        <a href="CadastroQuestionario.php" class="btn btn-primary">
                            Cadastrar Questionário
                        </a>

                    </div>

                <?php else: ?>

                    <table class="table table-hover table-bordered align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>Título</th>

                                <th>Descrição</th>

                                <th class="text-center">Questões</th>

                                <th class="text-center">Excluir</th>

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

                                        <a href="alterarQuestionario.php?idQuestionario=<?= $questionario['id']; ?>"
                                            class="btn btn-success">
                                            Alterar
                                        </a>

                                    </td>

                                    <td class="text-center">

                                        <button class="btn btn-danger" onclick="confirmarExclusao(<?= $questionario['id']; ?>)">
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