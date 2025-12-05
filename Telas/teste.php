<?php
session_start();
include_once '../Banco/conexao.php';

// GARANTE QUE O ALUNO ESTÁ LOGADO
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Telas/login.php");
    exit;
}

$alunoId = $_SESSION['user_id'];

// Conexão ao Banco
$con = new Conexao();
$conexao = $con->conexao();

// ID do questionário vindo pela URL
$questionarioId = isset($_GET['questionario_id']) ? (int) $_GET['questionario_id'] : 0;

// ===========================
//      BUSCAR QUESTIONÁRIO
// ===========================
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

// ===========================
//      BUSCAR QUESTÕES
// ===========================
$stmtQuestoes = $conexao->prepare("
    SELECT * FROM questoes
    WHERE questionarioid = :qid
");
$stmtQuestoes->bindValue(':qid', $questionarioId);
$stmtQuestoes->execute();
$questoes = $stmtQuestoes->fetchAll(PDO::FETCH_ASSOC);

// ===========================
//      PROCESSAR RESPOSTAS
// ===========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respostas = $_POST['respostas'];
    $acertos = 0;

    foreach ($respostas as $questaoId => $respostaConteudo) {

        // Verifica se a alternativa escolhida é correta
        $stmtVerifica = $conexao->prepare("
            SELECT resposta FROM opcoes 
            WHERE questaoid = :qid AND conteudo = :conteudo
            LIMIT 1
        ");
        $stmtVerifica->bindValue(':qid', $questaoId);
        $stmtVerifica->bindValue(':conteudo', $respostaConteudo);
        $stmtVerifica->execute();
        $resultado = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

        if ($resultado && $resultado['resposta'] == 1) {
            $acertos++;
        }

        // 🔥 APAGA RESPOSTA ANTERIOR DO ALUNO (EVITA DUPLICAÇÃO)
        $stmtDelete = $conexao->prepare("
            DELETE FROM respostaalunos 
            WHERE alunoid = :aluno AND questaoid = :questao AND questionarioid = :questionario
        ");
        $stmtDelete->bindValue(':aluno', $alunoId);
        $stmtDelete->bindValue(':questao', $questaoId);
        $stmtDelete->bindValue(':questionario', $questionarioId);
        $stmtDelete->execute();

        // 🔥 SALVA A NOVA RESPOSTA
        $stmtResposta = $conexao->prepare("
            INSERT INTO respostaalunos (alunoid, questaoid, resposta, questionarioid)
            VALUES (:aluno, :questao, :resposta, :questionario)
        ");
        $stmtResposta->bindValue(':aluno', $alunoId);
        $stmtResposta->bindValue(':questao', $questaoId);
        $stmtResposta->bindValue(':resposta', $respostaConteudo);
        $stmtResposta->bindValue(':questionario', $questionarioId);
        $stmtResposta->execute();
    }

    // SALVA RESULTADO NA SESSÃO PARA MOSTRAR NA PRÓXIMA PÁGINA
    $_SESSION['resultado_qtd'] = $acertos;
    $_SESSION['resultado_total'] = count($respostas);
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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS padrão do sistema -->
    <link rel="stylesheet" type="text/css" href="../CSS/cadastro.css">
</head>
<body>

<header>
    <h1>Responder Questionário</h1>
</header>

<nav>
    <a href="Aluno.php" class="btn btn-link">Início</a>
    <a href="../Controle/sair.php" class="btn btn-link">Sair</a>
</nav>

<div class="container mt-4">

    <h2 class="text-center mb-3"><?= htmlspecialchars($questionario['titulo']) ?></h2>
    <p class="text-center"><?= htmlspecialchars($questionario['descricao']) ?></p>

    <form method="POST">

        <?php foreach ($questoes as $q): ?>

            <div class="card mb-4 shadow-sm">
                <div class="card-body">

                    <h5 class="fw-bold"><?= htmlspecialchars($q['titulo']) ?></h5>
                    <p><?= htmlspecialchars($q['descricao']) ?></p>

                    <?php
                    // Buscar alternativas
                    $stmtOp = $conexao->prepare("
                        SELECT * FROM opcoes WHERE questaoid = :qid
                    ");
                    $stmtOp->bindValue(':qid', $q['id']);
                    $stmtOp->execute();
                    $opcoes = $stmtOp->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php foreach ($opcoes as $opcao): ?>
                        <div class="form-check mb-1">
                            <input class="form-check-input"
                                type="radio"
                                name="respostas[<?= $q['id'] ?>]"
                                value="<?= htmlspecialchars($opcao['conteudo']) ?>"
                                required>
                            <label class="form-check-label">
                                <?= htmlspecialchars($opcao['conteudo']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

        <?php endforeach; ?>

        <div class="text-center">
            <button class="btn btn-primary px-4">Enviar Respostas</button>
        </div>

    </form>
</div>

<footer>
    <p>&copy; 2024 Sistema de Gestão de Questionários</p>
</footer>

</body>
</html>
