<?php 
session_start();
include_once '../Controle/controlequestionario.php';
include_once '../Controle/controlealuno.php';
include_once '../Controle/controleturma.php';

$questionarioCtrl = new controlequestionario();
$alunoCtrl = new controlealuno();
$turmaCtrl = new controleturmma();

// Verifica se o aluno está logado
if (!$alunoCtrl->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$idAluno = $_SESSION['user_id'];

// 1️⃣ Buscar os dados do aluno
$alunoDados = $alunoCtrl->buscarPorId($idAluno);

// 2️⃣ Buscar todas as turmas que ele participa
$turmas = $turmaCtrl->buscarTurmasPorAluno($alunoDados['id']);

// 3️⃣ Extrair somente os IDs das turmas
$idsTurmas = array_column($turmas, 'id');

// 4️⃣ Buscar questionários das turmas (mesmo que sejam várias)
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
    <header>
        <h1>Questionários Disponíveis</h1>
    </header>
    <nav>
        <a href="Aluno.php" class="btn btn-link">Início</a>
        <a href="../Controle/sair.php" class="btn btn-link">Sair</a>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Questionários para sua turma</h2>

        <?php if (empty($questionarios)): ?>
            <div class="alert alert-warning text-center">
                Nenhum questionário disponível para sua turma no momento.
            </div>
        <?php else: ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Participar</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questionarios as $questionario): ?>
                        <tr>
                            <td><?= htmlspecialchars($questionario['titulo']); ?></td>
                            <td><?= htmlspecialchars($questionario['descricao']); ?></td>
                            <td>
                                <a href="teste.php?questionario_id=<?= $questionario['id']; ?>&aluno_id=<?= $idAluno; ?>" 
                                   class="btn btn-success btn-sm">
                                   Participar
                                </a>
                            </td>
                            <td>
                                <a href="resultadoAluno.php?questionario_id=<?= $questionario['id']; ?>&aluno_id=<?= $idAluno; ?>" 
                                   class="btn btn-primary btn-sm">
                                   Resultado
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>

    <footer>
        <p>&copy; 2024 Sistema de Gestão de Questionários</p>
    </footer>
</body>
</html>
