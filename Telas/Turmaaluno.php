<?php
session_start();
include_once '../Controle/controleturma.php';
include_once '../Controle/controlealuno.php';

$turmaCtrl = new controleturmma();
$alunoCtrl = new controlealuno();

if (!$alunoCtrl->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$alunoId = $_SESSION['user_id'];
$turmas = $alunoCtrl->listarTurmasAluno($alunoId);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Turmas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                        <h3 class="mb-0">Minhas Turmas</h3>
                    </div>

                    <div class="card-body">

                        <p class="text-muted mb-4">
                            Turmas em que você está matriculado.
                        </p>

                        <?php if (empty($turmas)): ?>

                            <div class="alert alert-warning text-center">
                                Você não faz parte de nenhuma turma.
                            </div>

                        <?php else: ?>

                            <div class="table-responsive">

                                <table class="table table-hover align-middle">

                                    <thead class="table-dark">

                                        <tr>
                                            <th>Nome da Turma</th>
                                            <th>Descrição</th>
                                            <th class="text-center" width="180">
                                                Participantes
                                            </th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php foreach ($turmas as $turma): ?>

                                            <tr>

                                                <td><?php echo htmlspecialchars($turma['nome']); ?></td>

                                                <td><?php echo htmlspecialchars($turma['descricao']); ?></td>

                                                <td class="text-center">

                                                    <a href="Participantes.php?idTurma=<?php echo $turma['id']; ?>"
                                                        class="btn btn-success">
                                                        Participantes
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