<?php
session_start();

include_once '../Banco/conexao.php';
include_once '../Controle/controleprofessor.php';

$professorCtrl = new controleprofessor();

if (!$professorCtrl->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$professorId = $_SESSION['user_id'];

$con = new Conexao();
$conexao = $con->conexao();

$stmt = $conexao->prepare("
    SELECT
        d.acertos,
        d.total,
        d.percentual,
        d.datarealizacao,

        a.nome AS aluno_nome,
        a.email AS aluno_email,

        q.titulo AS questionario_titulo,

        t.nome AS turma_nome

    FROM desempenho d

    INNER JOIN aluno a
        ON a.id = d.alunoid

    INNER JOIN questionario q
        ON q.id = d.questionarioid

    INNER JOIN turma t
        ON t.id = q.turmaid

    WHERE q.professorid = :professor

    ORDER BY
        d.datarealizacao DESC,
        a.nome ASC
");

$stmt->bindValue(':professor', $professorId, PDO::PARAM_INT);
$stmt->execute();

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalResultados = count($resultados);
$somaPercentuais = 0;
$alunosUnicos = [];

foreach ($resultados as $resultado) {
    $somaPercentuais += (float) $resultado['percentual'];
    $alunosUnicos[$resultado['aluno_email']] = true;
}

$totalAlunos = count($alunosUnicos);
$mediaGeral = 0;

if ($totalResultados > 0) {
    $mediaGeral = $somaPercentuais / $totalResultados;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Desempenho dos Alunos</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="../CSS/cadastro.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

        <div class="container">

            <a class="navbar-brand" href="Professor.php">
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

    <main class="container py-5">

        <div class="row g-4 mb-4">

            <div class="col-md-4">

                <div class="card shadow border-0 text-center h-100">

                    <div class="card-body">

                        <h5>Resultados registrados</h5>

                        <h2 class="text-primary mb-0">
                            <?= $totalResultados ?>
                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow border-0 text-center h-100">

                    <div class="card-body">

                        <h5>Alunos avaliados</h5>

                        <h2 class="text-success mb-0">
                            <?= $totalAlunos ?>
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
                    Desempenho dos alunos
                </h3>

            </div>

            <div class="card-body">

                <?php if (empty($resultados)): ?>

                    <div class="alert alert-warning text-center mb-0">

                        Nenhum aluno respondeu seus questionários.

                    </div>

                <?php else: ?>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-dark">

                                <tr>
                                    <th>Aluno</th>
                                    <th>Turma</th>
                                    <th>Questionário</th>
                                    <th>Acertos</th>
                                    <th>Total</th>
                                    <th>Desempenho</th>
                                    <th>Data</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($resultados as $resultado): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars($resultado['aluno_nome']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($resultado['turma_nome']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $resultado['questionario_titulo']
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= (int) $resultado['acertos'] ?>
                                        </td>

                                        <td>
                                            <?= (int) $resultado['total'] ?>
                                        </td>

                                        <td>
                                            <?= number_format(
                                                $resultado['percentual'],
                                                2,
                                                ',',
                                                '.'
                                            ) ?>%
                                        </td>

                                        <td>
                                            <?= date(
                                                'd/m/Y H:i',
                                                strtotime($resultado['datarealizacao'])
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