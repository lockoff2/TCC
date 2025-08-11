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
                window.location.href = '../Controle/apagarturma.php?idturma=' + idTurma;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Gerenciar Turmas</h1>
    </header>
    <nav>
        <a href="professor.php" class="btn btn-link">Início</a>
        <a href="../Controle/sair.php" class="btn btn-link">Sair</a>
    </nav>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Suas Turmas</h2>
        <?php if (empty($turmas)): ?>
            <div class="alert alert-warning text-center">
                Nenhuma turma cadastrada no momento. <a href="cadastrarTurma.php" class="alert-link">Cadastre uma nova turma aqui!</a>
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
                            
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="confirmarExclusao(<?php echo $turma['id']; ?>)">
                                    <i class="fas fa-trash-alt"></i> Remover
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <div class="text-center mt-4">
            <a href="cadastrarTurma.php" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle"></i> Cadastrar Nova Turma
            </a>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 CodeQuiz</p>
    </footer>
</body>
</html>
