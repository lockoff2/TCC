<?php
session_start();

include_once '../Banco/conexao.php';
include_once '../Controle/controlealuno.php';

$alunoCtrl = new controlealuno();

if (!$alunoCtrl->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$alunoId = $_SESSION['user_id'];

$con = new Conexao();
$conexao = $con->conexao();

$stmt = $conexao->prepare("
    SELECT
        d.acertos,
        d.total,
        d.percentual,
        d.datarealizacao,
        q.titulo,
        q.descricao,
        t.nome AS turma_nome
    FROM desempenho d

    INNER JOIN questionario q
        ON q.id = d.questionarioid

    INNER JOIN turma t
        ON t.id = q.turmaid

    WHERE d.alunoid = :aluno

    ORDER BY d.datarealizacao DESC
");

$stmt->bindValue(':aluno', $alunoId, PDO::PARAM_INT);
$stmt->execute();

$desempenhos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalQuestionarios = count($desempenhos);
$totalAcertos = 0;
$totalQuestoes = 0;

foreach ($desempenhos as $desempenho) {
    $totalAcertos += (int) $desempenho['acertos'];
    $totalQuestoes += (int) $desempenho['total'];
}

$mediaGeral = 0;

if ($totalQuestoes > 0) {
    $mediaGeral = ($totalAcertos * 100) / $totalQuestoes;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Meu Desempenho</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

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

                <a href="Questionariosaluno.php" class="btn btn-outline-light me-2">
                    Questionários
                </a>

                <a href="../Controle/sair.php" class="btn btn-light">
                    Sair
                </a>

            </div>

        </div>

    </nav>

    <main class="container py-5">

        <div class="row g-4 mb-4">

            <div class="col-md-4">

                <div class="card shadow border-0 text-center h-100">

                    <div class="card-body">

                        <h5>Questionários respondidos</h5>

                        <h2 class="text-primary mb-0">
                            <?= $totalQuestionarios ?>
                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow border-0 text-center h-100">

                    <div class="card-body">

                        <h5>Total de acertos</h5>

                        <h2 class="text-success mb-0">
                            <?= $totalAcertos ?>
                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow border-0 text-center h-100">

                    <div class="card-body">

                        <h5>Média geral</h5>

                        <h2 class="text-warning mb-0">
                            <?= number_format($mediaGeral, 2, ',', '.') ?>%
                        </h2>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white">

                <h3 class="mb-0">
                    Meu histórico
                </h3>

            </div>

            <div class="card-body">

                <?php if (empty($desempenhos)): ?>

                    <div class="alert alert-warning text-center mb-0">

                        Você ainda não respondeu nenhum questionário.

                    </div>

                <?php else: ?>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-dark">

                                <tr>
                                    <th>Questionário</th>
                                    <th>Turma</th>
                                    <th>Acertos</th>
                                    <th>Total</th>
                                    <th>Desempenho</th>
                                    <th>Data</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($desempenhos as $desempenho): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars($desempenho['titulo']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($desempenho['turma_nome']) ?>
                                        </td>

                                        <td>
                                            <?= (int) $desempenho['acertos'] ?>
                                        </td>

                                        <td>
                                            <?= (int) $desempenho['total'] ?>
                                        </td>

                                        <td>
                                            <?= number_format(
                                                $desempenho['percentual'],
                                                2,
                                                ',',
                                                '.'
                                            ) ?>%
                                        </td>

                                        <td>
                                            <?= date(
                                                'd/m/Y H:i',
                                                strtotime($desempenho['datarealizacao'])
                                            ) ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </main>

    <footer class="bg-dark text-white text-center py-3 mt-5">

        <p class="mb-0">
            &copy; 2024 CodeQuiz
        </p>

    </footer>

</body>

</html>