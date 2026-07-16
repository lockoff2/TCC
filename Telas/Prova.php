<?php
session_start();
include_once '../Banco/conexao.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Telas/login.php");
    exit;
}

$alunoId = $_SESSION['user_id'];

$con = new Conexao();
$conexao = $con->conexao();


$questionarioId = isset($_GET['questionario_id']) ? (int) $_GET['questionario_id'] : 0;


$stmtQuestionario = $conexao->prepare("
    SELECT * FROM questionario WHERE id = :id
");
$stmtQuestionario->bindValue(':id', $questionarioId);
$stmtQuestionario->execute();
$questionario = $stmtQuestionario->fetch(PDO::FETCH_ASSOC);

if (!$questionario) {
    echo "<h3>Questionário não encontrado!</h3>";
    exit;
}


$stmtQuestoes = $conexao->prepare("
    SELECT * FROM questoes
    WHERE questionarioid = :qid
");
$stmtQuestoes->bindValue(':qid', $questionarioId);
$stmtQuestoes->execute();
$questoes = $stmtQuestoes->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $respostas = $_POST['respostas'] ?? [];
    $acertos = 0;

    foreach ($respostas as $questaoId => $respostaConteudo) {

        // Verifica se a alternativa escolhida é correta
        $stmtVerifica = $conexao->prepare("
            SELECT resposta
            FROM opcoes
            WHERE questaoid = :qid
              AND conteudo = :conteudo
            LIMIT 1
        ");

        $stmtVerifica->bindValue(':qid', $questaoId, PDO::PARAM_INT);
        $stmtVerifica->bindValue(':conteudo', $respostaConteudo);
        $stmtVerifica->execute();

        $resultado = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

        if ($resultado && (int) $resultado['resposta'] === 1) {
            $acertos++;
        }

        $stmtDelete = $conexao->prepare("
            DELETE FROM respostaalunos
            WHERE alunoid = :aluno
              AND questaoid = :questao
              AND questionarioid = :questionario
        ");

        $stmtDelete->bindValue(':aluno', $alunoId, PDO::PARAM_INT);
        $stmtDelete->bindValue(':questao', $questaoId, PDO::PARAM_INT);
        $stmtDelete->bindValue(':questionario', $questionarioId, PDO::PARAM_INT);
        $stmtDelete->execute();

        $stmtResposta = $conexao->prepare("
            INSERT INTO respostaalunos (
                alunoid,
                questaoid,
                resposta,
                questionarioid
            )
            VALUES (
                :aluno,
                :questao,
                :resposta,
                :questionario
            )
        ");

        $stmtResposta->bindValue(':aluno', $alunoId, PDO::PARAM_INT);
        $stmtResposta->bindValue(':questao', $questaoId, PDO::PARAM_INT);
        $stmtResposta->bindValue(':resposta', $respostaConteudo);
        $stmtResposta->bindValue(':questionario', $questionarioId, PDO::PARAM_INT);
        $stmtResposta->execute();
    }

    $total = count($respostas);
    $percentual = 0;

    if ($total > 0) {
        $percentual = ($acertos * 100) / $total;
    }


    $stmtDeleteDesempenho = $conexao->prepare("
        DELETE FROM desempenho
        WHERE alunoid = :aluno
          AND questionarioid = :questionario
    ");

    $stmtDeleteDesempenho->bindValue(':aluno', $alunoId, PDO::PARAM_INT);
    $stmtDeleteDesempenho->bindValue(':questionario', $questionarioId, PDO::PARAM_INT);
    $stmtDeleteDesempenho->execute();

    // Salva o desempenho
    $stmtDesempenho = $conexao->prepare("
        INSERT INTO desempenho (
            alunoid,
            questionarioid,
            acertos,
            total,
            percentual,
            datarealizacao
        )
        VALUES (
            :aluno,
            :questionario,
            :acertos,
            :total,
            :percentual,
            NOW()
        )
    ");

    $stmtDesempenho->bindValue(':aluno', $alunoId, PDO::PARAM_INT);
    $stmtDesempenho->bindValue(':questionario', $questionarioId, PDO::PARAM_INT);
    $stmtDesempenho->bindValue(':acertos', $acertos, PDO::PARAM_INT);
    $stmtDesempenho->bindValue(':total', $total, PDO::PARAM_INT);
    $stmtDesempenho->bindValue(':percentual', $percentual);
    $stmtDesempenho->execute();


    $_SESSION['resultado_qtd'] = $acertos;
    $_SESSION['resultado_total'] = $total;
    $_SESSION['resultado_titulo'] = $questionario['titulo'];

    header("Location: resultadoAluno.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Responder Questionário</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../CSS/cadastro.css">
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

                        <h3 class="mb-0">
                            <?= htmlspecialchars($questionario['titulo']) ?>
                        </h3>

                    </div>

                    <div class="card-body">

                        <p class="text-muted mb-4">
                            <?= htmlspecialchars($questionario['descricao']) ?>
                        </p>

                        <form method="POST">

                            <?php foreach ($questoes as $q): ?>

                                <div class="card mb-4 border">

                                    <div class="card-body">

                                        <h5 class="fw-bold mb-2">
                                            <?= htmlspecialchars($q['titulo']) ?>
                                        </h5>

                                        <p class="text-muted">
                                            <?= htmlspecialchars($q['descricao']) ?>
                                        </p>

                                        <?php
                                        $stmtOp = $conexao->prepare("
                                        SELECT * FROM opcoes
                                        WHERE questaoid = :qid
                                    ");
                                        $stmtOp->bindValue(':qid', $q['id']);
                                        $stmtOp->execute();
                                        $opcoes = $stmtOp->fetchAll(PDO::FETCH_ASSOC);
                                        ?>

                                        <?php foreach ($opcoes as $opcao): ?>

                                            <div class="form-check mb-2">

                                                <input class="form-check-input" type="radio" name="respostas[<?= $q['id'] ?>]"
                                                    value="<?= htmlspecialchars($opcao['conteudo']) ?>" required>

                                                <label class="form-check-label">
                                                    <?= htmlspecialchars($opcao['conteudo']) ?>
                                                </label>

                                            </div>

                                        <?php endforeach; ?>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                            <div class="text-center mt-4">

                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    Enviar Respostas
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">

        <p class="mb-0">
            &copy; 2024 CodeQuiz
        </p>

    </footer>

</body>

</html>