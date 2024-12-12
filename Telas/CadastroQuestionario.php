<?php
session_start();
include_once '../Controle/controlequestionario.php';
include_once '../Controle/controlequestao.php';
include_once '../Controle/controleTurma.php';
include_once '../Model/Questionario.php';
include_once '../Model/Questao.php';
include_once '../Model/Opcoes.php';

$questaoCrtl = new controlequestao();
$questionarioCtrl = new controlequestionario();
$turmaCtrl = new controleTurmma();
$questionario = new Questionario();

$professorId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   

    $titulo = $_POST['titulo'] ?? null;
    $descricao = $_POST['descricao'] ?? null;
    $turmaId = $_POST['turmas'] ?? null;

    if ($titulo && $descricao && $turmaId) {
        $questionario->setTitulo($titulo);
        $questionario->setDescricao($descricao);
        $questionario->setTurmaid($turmaId);
        $questionario->setProfessorId($professorId);

        $questionarioCtrl->cadastrarQuestionario($questionario);
        $questionarioId = $questionarioCtrl->getUltimaTurmaInserida();

        if ($questionarioId && isset($_POST['questoes'])) {
            foreach ($_POST['questoes'] as $questaoData) {
                

                $questao = new Questao();
                $questao->setTitulo($questaoData['titulo']);
                $questao->setDescricao($questaoData['descricao']);
                $questao->setTipo($questaoData['tipo']);
                $questao->setProfessorid($professorId);
                $questao->setQuestionarioid($questionarioId);

                $questaoId = $questaoCrtl->cadastrarQuestao($questao);

                if ($questaoData['tipo'] == "1" && isset($questaoData['alternativas'])) {
                    foreach ($questaoData['alternativas'] as $index => $alternativa) {
                        $opcao = new Opcoes();
                        $opcao->setConteudo($alternativa['conteudo']);
                        $opcao->setResposta($questaoData['correta'] == $index);
                        $opcao->setQuestaoid($questaoId);
                        $questaoCrtl->cadastrarOpcoes($opcao);
                    }
                }
            }
        }

        header("Location: Questionarios.php");
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar questionário: Preencha todos os campos!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Questionário</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

            <div class="mb-3">
                <label for="turmas" class="form-label">Selecione a turma</label>
                <select id="turmas" name="turmas" class="form-control" required>
                    <?php
                    $turmas = $turmaCtrl->listarTurmasProfessor($professorId);

                    if (!empty($turmas)) {
                        foreach ($turmas as $turma) {
                            echo "<option value='{$turma['id']}'>{$turma['nome']}</option>";
                        }
                    } else {
                        echo "<option disabled>Nenhuma turma encontrada</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Sistema de Gestão de Turmas</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#turmas').select2({
                placeholder: "Selecione uma turma",
                allowClear: true
            });
        });
    </script>
</body>

</html>
