<?php
session_start();


if (!isset($_SESSION['resultado_qtd'])) {
    header("Location: Aluno.php");
    exit;
}

$acertos = $_SESSION['resultado_qtd'];
$total = $_SESSION['resultado_total'];
$questionario = $_SESSION['resultado_titulo'];

$percentual = 0;

if ($total > 0) {
    $percentual = ($acertos * 100) / $total;
}


unset($_SESSION['resultado_qtd']);
unset($_SESSION['resultado_total']);
unset($_SESSION['resultado_titulo']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resultado do Questionário</title>

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

                <a href="DesempenhoAluno.php" class="btn btn-outline-light me-2">
                    Meu Desempenho
                </a>

                <a href="../Controle/sair.php" class="btn btn-light">
                    Sair
                </a>

            </div>

        </div>

    </nav>

    <main class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow border-0">

                    <div class="card-header bg-primary text-white">

                        <h3 class="mb-0">
                            Resultado do Questionário
                        </h3>

                    </div>

                    <div class="card-body p-4 text-center">

                        <h4 class="text-primary mb-4">
                            <?= htmlspecialchars($questionario) ?>
                        </h4>

                        <div class="row g-3 mb-4">

                            <div class="col-md-4">

                                <div class="border rounded p-3 h-100">

                                    <h6 class="text-muted">
                                        Acertos
                                    </h6>

                                    <h2 class="text-success mb-0">
                                        <?= (int) $acertos ?>
                                    </h2>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="border rounded p-3 h-100">

                                    <h6 class="text-muted">
                                        Total de questões
                                    </h6>

                                    <h2 class="text-primary mb-0">
                                        <?= (int) $total ?>
                                    </h2>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="border rounded p-3 h-100">

                                    <h6 class="text-muted">
                                        Aproveitamento
                                    </h6>

                                    <h2 class="text-warning mb-0">
                                        <?= number_format($percentual, 2, ',', '.') ?>%
                                    </h2>

                                </div>

                            </div>

                        </div>

                        <?php if ($acertos == $total && $total > 0): ?>

                            <div class="alert alert-success">
                                Excelente! Você acertou todas as questões.
                            </div>

                        <?php elseif ($acertos >= ($total / 2)): ?>

                            <div class="alert alert-warning">
                                Bom trabalho! Continue estudando para melhorar ainda mais.
                            </div>

                        <?php else: ?>

                            <div class="alert alert-danger">
                                Continue estudando. Você pode melhorar seu resultado.
                            </div>

                        <?php endif; ?>

                        <div class="d-flex justify-content-center gap-2 mt-4">

                            <a href="Aluno.php" class="btn btn-primary">
                                Voltar ao início
                            </a>

                            <a href="DesempenhoAluno.php" class="btn btn-warning">
                                Ver meu desempenho
                            </a>

                        </div>

                    </div>

                </div>

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