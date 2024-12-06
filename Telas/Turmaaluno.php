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
    <script>
        function confirmarExclusao(idTurma) {
            if (confirm('Você realmente deseja apagar esta turma?')) {
                window.location.href = '../Controle/apagarTurma.php?idTurma=' + idTurma;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Gerenciar Turmas</h1>
    </header>
    <nav>
        <a href="Aluno.php" class="btn btn-link">Início</a>
        <a href="../Controle/sair.php" class="btn btn-link">Sair</a>
    </nav>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Suas Turmas</h2>
        <?php if (empty($turmas)): ?>
            <div class="alert alert-warning text-center">
                Não faz parte de nenhuma turma. 
            </div>
        <?php else: ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome da Turma</th>
                        <th>Descrição</th>
                        <th>Gerenciar Alunos</th>

                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($turmas as $turma): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($turma['nome']); ?></td>
                            <td><?php echo htmlspecialchars($turma['descricao']); ?></td>
                            <td>
                                <a href="Gerenciaralunos.php?idTurma=<?php echo $turma['id']; ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-users"></i> Gerenciar
                                </a>
                            </td>
                            
                            
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
 