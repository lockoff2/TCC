<?php 
session_start();
include_once '../Controle/controlequestionario.php';

$questionarioCtrl = new controlequestionario();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $professorId = $_SESSION['user_id'];

    $questionarioId = $questionarioCtrl->cadastrarQuestionario($titulo, $descricao, $professorId);

    if ($questionarioId) {

        foreach ($_POST['questoes'] as $questao) {
            $tituloQuestao = $questao['titulo'];
            $descricaoQuestao = $questao['descricao'];
            $tipoQuestao = $questao['tipo'];

            $questaoId = $questionarioCtrl->cadastrarQuestao($tituloQuestao, $descricaoQuestao, $tipoQuestao, $questionarioId);

            if ($tipoQuestao == 1 && isset($questao['alternativas'])) {
                foreach ($questao['alternativas'] as $index => $alternativa) {
                    $conteudo = $alternativa['conteudo'];
                    $correta = isset($questao['correta']) && $questao['correta'] == $index;
                    $questionarioCtrl->cadastrarAlternativa($conteudo, $correta, $questaoId);
                }
            }

            if ($tipoQuestao == 2) {
                $questionarioCtrl->cadastrarAlternativa("Verdadeiro", true, $questaoId);
                $questionarioCtrl->cadastrarAlternativa("Falso", false, $questaoId);
            }
        }

        echo "<script>alert('Questionário cadastrado com sucesso!'); window.location.href = 'Questionario.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar questionário!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Questionário</title>
    <link rel="stylesheet" href="../CSS/cadastroquestionario.css">
    <script src="../JS/cadastrarQuestionario.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
        <h2 class="text-center mb-4">Cadastrar Questionário</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título do Questionário</label>
                <input type="text" name="titulo" id="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="3" required></textarea>
            </div>
            <h3>Questões</h3>
            <div id="questoes-container"></div>
            <button type="button" class="btn btn-secondary mb-3" onclick="adicionarQuestao()">Adicionar Questão</button>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Sistema de Gestão de Turmas</p>
    </footer>
</body>
</html>
