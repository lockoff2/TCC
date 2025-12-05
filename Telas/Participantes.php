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
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Alunos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/cadastro.css">
</head>

<body>
<header>
    <h1>Gerenciar Alunos - Turma <?php echo htmlspecialchars($turmaInfo['nome']); ?></h1>
</header>

<nav>
    <a href="index.php" class="btn btn-link">Início</a>
    <a href="Turmaaluno.php" class="btn btn-link">Voltar às Turmas</a>
    <a href="../Controle/sair.php" class="btn btn-link">Sair</a>
</nav>

<div class="container mt-4">

    <!-- BLOCO DO PROFESSOR -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title">Professor da Turma</h4>
            <?php if (!empty($professorTurma)): ?>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($professorTurma['nome']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($professorTurma['email']); ?></p>
            <?php else: ?>
                <p class="text-danger">Professor não encontrado!</p>
            <?php endif; ?>
        </div>
    </div>

    <h2 class="text-center mb-4">Alunos na Turma</h2>

    <?php if (empty($alunos)): ?>
        <div class="alert alert-warning text-center">Nenhum aluno está associado a esta turma.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<footer>
    <p>&copy; 2024 Sistema de Gestão de Turmas</p>
</footer>

</body>
</html>
