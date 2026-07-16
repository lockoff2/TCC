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


$alunos = $alunoCtrl->listarAlunosPorTurma($idTurma);
$todosAlunos = $alunoCtrl->todosalunos();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Alunos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/cadastro.css">
    <script>
        function confirmarRemocao(idAluno) {
            if (confirm('Você realmente deseja remover este aluno da turma?')) {
                window.location.href = '../Controle/removerAlunoTurma.php?idTurma=<?php echo $idTurma; ?>&idAluno=' + idAluno;
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>Gerenciar Alunos - Turma <?php echo htmlspecialchars($turmaCtrl->NomeTurma($idTurma)); ?></h1>
    </header>
    <nav>
        <a href="index.php" class="btn btn-link">Início</a>
        <a href="Turma.php" class="btn btn-link">Voltar às Turmas</a>
        <a href="../Controle/sair.php" class="btn btn-link">Sair</a>
    </nav>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Alunos na Turma</h2>
        <?php if (empty($alunos)): ?>
            <div class="alert alert-warning text-center">Nenhum aluno está associado a esta turma.</div>
        <?php else: ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="confirmarRemocao(<?php echo $aluno['id']; ?>)">
                                    <i class="fas fa-trash-alt"></i> Remover
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <h2 class="text-center mt-4">Adicionar Alunos à Turma</h2>
        <form action="../Controle/adicionarAlunoTurma.php" method="POST" class="mt-3">
            <input type="hidden" name="idTurma" value="<?php echo $idTurma; ?>">
            <div class="mb-3">
                <label for="idAluno" class="form-label">Selecione um aluno:</label>
                <select name="idAluno" id="idAluno" class="form-select" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($todosAlunos as $aluno): ?>
                        <option value="<?php echo $aluno['id']; ?>"><?php echo htmlspecialchars($aluno['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Aluno</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Sistema de Gestão de Turmas</p>
    </footer>
</body>

</html>