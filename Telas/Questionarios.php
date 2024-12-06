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
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Questionários</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/cadastro.css">
    <script>
        function confirmarExclusao(idQuestionario) {
            if (confirm('Você realmente deseja apagar este questionário?')) {
                window.location.href = '../Controle/apagarQuestionario.php?idQuestionario=' + idQuestionario;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Gerenciar Questionários</h1>
    </header>
    <nav>
        <a href="Professor.php" class="btn btn-link">Início</a>
        <a href="../Controle/sair.php" class="btn btn-link">Sair</a>
    </nav>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Seus Questionários</h2>
        <?php if (empty($questionarios)): ?>
            <div class="alert alert-warning text-center">
                Nenhum questionário cadastrado no momento. <a href="CadastroQuestionario.php" class="alert-link">Cadastre um novo questionário aqui!</a>
            </div>
        <?php else: ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Título do Questionário</th>
                        <th>Descrição</th>
                        <th>Gerenciar Questões</th>
                        <th>Alterar</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questionarios as $questionario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($questionario['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($questionario['descricao']); ?></td>
                            <td>
                                <a href="gerenciarQuestoes.php?idQuestionario=<?php echo $questionario['id']; ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-tasks"></i> Gerenciar
                                </a>
                            </td>
                            <td>
                                <a href="alterarQuestionario.php?idQuestionario=<?php echo $questionario['id']; ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Alterar
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="confirmarExclusao(<?php echo $questionario['id']; ?>)">
                                    <i class="fas fa-trash-alt"></i> Remover
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <div class="text-center mt-4">
            <a href="CadastroQuestionario.php" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle"></i> Cadastrar Novo Questionário
            </a>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Sistema de Gestão de Questionários</p>
    </footer>
</body>
</html>
