<?php
session_start();

// Verifica se existe resultado na sessão
if (!isset($_SESSION['resultado_qtd'])) {
    header("Location: Aluno.php");
    exit;
}

$acertos = $_SESSION['resultado_qtd'];
$total = $_SESSION['resultado_total'];
$questionario = $_SESSION['resultado_titulo'];

// limpa sessão após uso
unset($_SESSION['resultado_qtd']);
unset($_SESSION['resultado_total']);
unset($_SESSION['resultado_titulo']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow p-4">
        <h1 class="text-center mb-3">Resultado do Questionário</h1>

        <h3 class="text-center text-primary"><?= htmlspecialchars($questionario) ?></h3>
        <hr>

        <p class="text-center fs-4">
            Você acertou <strong><?= $acertos ?></strong> de <strong><?= $total ?></strong> questões!
        </p>

        <?php if ($acertos == $total): ?>
            <div class="alert alert-success text-center">Excelente! Você acertou tudo! 🎉</div>
        <?php elseif ($acertos >= ($total / 2)): ?>
            <div class="alert alert-warning text-center">Bom trabalho! Mas dá para melhorar. 😉</div>
        <?php else: ?>
            <div class="alert alert-danger text-center">Continue estudando! Você consegue melhorar! 💪</div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="Aluno.php" class="btn btn-primary">Voltar ao início</a>
        </div>
    </div>

</div>

</body>
</html>
