<?php
session_start();
include_once '../Controle/controlealuno.php';

$aluno = new controlealuno();

if (!$aluno->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$nomeAluno = $_SESSION['nome'] ?? "Aluno";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CodeQuiz - Aluno</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
        }

        .navbar {
            background: #0d6efd;
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: white !important;
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        footer {
            margin-top: 60px;
            text-align: center;
            border-top: 1px solid #ccc;
            padding: 15px;
        }

        .cards-info {
            display: flex;
            align-items: stretch;
        }

        .cards-info .col-md-6 {
            display: flex;
        }

        .cards-info .card {
            width: 100%;
            height: 100%;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg">

        <div class="container">

            <a class="navbar-brand" href="#">CodeQuiz</a>

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="Turmaaluno.php">Minhas Turmas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Questionariosaluno.php">Avaliações</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="perfilaluno.php">Perfil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../Controle/sair.php">Sair</a>
                </li>

            </ul>

        </div>

    </nav>

    <div class="container mt-5">

        <h1>Olá, <?= $nomeAluno ?> 👋</h1>

        <p>Bem-vindo ao CodeQuiz.</p>

        <div class="row g-4">

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body text-center">

                        <h1>🏫</h1>

                        <h2>Minhas Turmas</h2>

                        <p>Visualize as turmas em que você está matriculado.</p>

                        <a href="Turmaaluno.php" class="btn btn-primary">
                            Acessar
                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body text-center">

                        <h1>📝</h1>

                        <h2>Avaliações</h2>

                        <p>Responda os questionários disponíveis.</p>

                        <a href="Questionariosaluno.php" class="btn btn-success">
                            Acessar
                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body text-center">

                        <h1>📈</h1>

                        <h2>Meu Desempenho</h2>

                        <p>Consulte suas notas e resultados obtidos em todos os questionários respondidos.</p>

                        <a href="DesempenhoAluno.php" class="btn btn-warning">
                            Visualizar
                        </a>

                    </div>

                </div>

            </div>


            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header bg-primary text-white">

                        Acesso Rápido

                    </div>

                    <div class="card-body d-flex flex-column">

                        <a href="Questionariosaluno.php" class="btn btn-outline-success mb-3">
                            📝 Responder Questionários
                        </a>

                        <a href="Turmaaluno.php" class="btn btn-outline-primary mb-3">
                            🏫 Minhas Turmas
                        </a>

                        <a href="DesempenhoAluno.php" class="btn btn-outline-warning mb-3">
                            📊 Meu Desempenho
                        </a>

                        <a href="perfilaluno.php" class="btn btn-outline-dark mt-auto">
                            👤 Meu Perfil
                        </a>

                    </div>

                </div>

            </div>
            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header bg-success text-white">

                        Sobre o Sistema

                    </div>

                    <div class="card-body">

                        <p>

                            O <strong>CodeQuiz</strong> permite que você responda avaliações criadas pelos professores e
                            acompanhe seu desempenho durante o curso.

                        </p>

                        <ul>

                            <li>✔ Participar de Turmas</li>

                            <li>✔ Responder Questionários</li>

                            <li>✔ Receber Correção Automática</li>

                            <li>✔ Visualizar Feedback</li>

                            <li>✔ Consultar seu Desempenho</li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <footer>

        © 2026 CodeQuiz - Trabalho de Conclusão de Curso

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>