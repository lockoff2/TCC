<?php
session_start();

include_once '../Controle/controlequestionario.php';
include_once '../Controle/controlequestao.php';
include_once '../Controle/controleturma.php';
include_once '../Model/Questionario.php';
include_once '../Model/Questao.php';
include_once '../Model/Opcoes.php';

$questaoCtrl = new controlequestao();
$questionarioCtrl = new controlequestionario();
$turmaCtrl = new controleturmma();

$professorId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $questionario = new Questionario();
    $questionario->setTitulo($_POST['titulo']);
    $questionario->setDescricao($_POST['descricao']);
    $questionario->setTurmaid($_POST['turmas']);
    $questionario->setProfessorId($professorId);

    $questionarioCtrl->cadastrarQuestionario($questionario);
    $questionarioId = $questionarioCtrl->getUltimoQuestionarioInserido();



    if (isset($_POST['questoes'])) {
        foreach ($_POST['questoes'] as $questaoData) {

            if (empty($questaoData['titulo']))
                continue;

            $questao = new Questao();
            $questao->setTitulo($questaoData['titulo']);
            $questao->setDescricao($questaoData['descricao']);
            $questao->setTipo($questaoData['tipo']);
            $questao->setProfessorid($professorId);
            $questao->setQuestionarioid($questionarioId);

            $questaoId = $questaoCtrl->cadastrarQuestao($questao);



            if ($questaoData['tipo'] == "1" && isset($questaoData['alternativas'])) {

                foreach ($questaoData['alternativas'] as $i => $alt) {

                    if (empty($alt['conteudo']))
                        continue;

                    $opcao = new Opcoes();
                    $opcao->setConteudo($alt['conteudo']);

                    // Marca como correta
                    $opcao->setResposta($questaoData['correta'] == $i);

                    $opcao->setQuestaoid($questaoId);

                    $questaoCtrl->cadastrarOpcoes($opcao);
                }
            }



            if ($questaoData['tipo'] == "2") {

                // Alternativa: Verdadeiro
                $opcaoV = new Opcoes();
                $opcaoV->setConteudo("Verdadeiro");
                $opcaoV->setResposta($questaoData['correta'] === "true");
                $opcaoV->setQuestaoid($questaoId);
                $questaoCtrl->cadastrarOpcoes($opcaoV);

                // Alternativa: Falso
                $opcaoF = new Opcoes();
                $opcaoF->setConteudo("Falso");
                $opcaoF->setResposta($questaoData['correta'] === "false");
                $opcaoF->setQuestaoid($questaoId);
                $questaoCtrl->cadastrarOpcoes($opcaoF);
            }
        }
    }

    header("Location: Questionarios.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Questionário</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../CSS/cadastroquestionario.css">

    <script src="../JS/cadastrarQuestionario.js"></script>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

        <div class="container">

            <a class="navbar-brand fw-bold" href="Professor.php">
                CodeQuiz
            </a>

            <div class="ms-auto">

                <a href="Professor.php" class="btn btn-outline-light me-2">
                    Início
                </a>

                <a href="Questionarios.php" class="btn btn-outline-light me-2">
                    Questionários
                </a>

                <a href="../Controle/sair.php" class="btn btn-light">
                    Sair
                </a>

            </div>

        </div>

    </nav>

    <div class="page-container">

        <div class="row justify-content-center">

            <div class="col-lg-9 col-xl-8">

                <div class="card border-0 shadow-lg">

                    <div class="card-header bg-primary text-white">

                        <h3 class="mb-0">
                            Cadastrar Questionário
                        </h3>

                    </div>

                    <div class="card-body p-4">

                        <form method="POST">

                            <div class="mb-3">

                                <label class="form-label">
                                    Título do Questionário
                                </label>

                                <input type="text" name="titulo" id="titulo" class="form-control" required>

                            </div>

                            <div class="mb-4">

                                <label class="form-label">
                                    Descrição
                                </label>

                                <textarea name="descricao" id="descricao" rows="4" class="form-control"
                                    required></textarea>

                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <h4 class="mb-0">
                                    Questões
                                </h4>

                                <button type="button" class="btn btn-secondary" onclick="adicionarQuestao()">

                                    Adicionar Questão

                                </button>

                            </div>

                            <div id="questoes-container"></div>

                            <hr>

                            <div class="mb-4">

                                <label class="form-label">
                                    Selecione a Turma
                                </label>

                                <select id="turmas" name="turmas" class="form-select" required>

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

                            <div class="d-grid mt-4">

                                <button type="submit" class="btn btn-primary btn-lg">

                                    Cadastrar Questionário

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <footer class="bg-primary text-white text-center py-3 mt-5">

        © 2024 CodeQuiz

    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#turmas').select2({
                placeholder: "Selecione uma turma",
                width: '100%',
                allowClear: true
            });

        });
    </script>

</body>

</html>