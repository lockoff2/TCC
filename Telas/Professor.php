<?php
session_start();
include_once '../Controle/controleprofessor.php';

$professor = new controleprofessor();

if (!$professor->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$nomeProfessor = $_SESSION['nome'] ?? "Professor";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CodeQuiz</title>

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

        /* Faz os cards inferiores ficarem iguais */

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
                    <a class="nav-link" href="turma.php">Turmas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Questionarios.php">Questionários</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="perfil.php">Perfil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../Controle/sair.php">Sair</a>
                </li>

            </ul>

        </div>

    </nav>


    <div class="container mt-5">

        <h1>Olá, <?= $nomeProfessor ?> 👋</h1>

        <p class="mb-4">
            Bem-vindo ao sistema CodeQuiz.
        </p>


        <!-- Cards superiores -->

        <div class="row g-4">

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body text-center">

                        <h1>🏫</h1>

                        <h2>Turmas</h2>

                        <p>Cadastre e gerencie suas turmas.</p>

                        <a href="turma.php" class="btn btn-primary">
                            Acessar
                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body text-center">

                        <h1>📝</h1>

                        <h2>Questionários</h2>

                        <p>Crie provas e listas de exercícios.</p>

                        <a href="Questionarios.php" class="btn btn-success">
                            Acessar
                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body text-center">

                        <h1>📊</h1>

                        <h2>Desempenho</h2>

                        <p>Visualize o desempenho dos alunos em todos os questionários.</p>

                        <a href="DesempenhoProfessor.php" class="btn btn-warning">
                            Visualizar
                        </a>

                    </div>

                </div>

            </div>


            <!-- Cards inferiores -->

            <div class="row mt-5 cards-info">

                <!-- Ações rápidas -->

                <div class="col-md-6">

                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">

                            Ações rápidas

                        </div>

                        <div class="card-body d-flex flex-column">

                            <a href="cadastrarTurma.php" class="btn btn-outline-primary mb-3">
                                + Nova Turma
                            </a>

                            <a href="cadastroQuestionario.php" class="btn btn-outline-success mb-3">
                                + Novo Questionário
                            </a>

                            <a href="Questionarios.php" class="btn btn-outline-dark mb-3">
                                Gerenciar Questionários
                            </a>

                            <a href="turma.php" class="btn btn-outline-info mt-auto">
                                Gerenciar Turmas
                            </a>

                        </div>
                    </div>

                </div>

                <!-- Sobre o Sistema -->

                <div class="col-md-6">

                    <div class="card shadow">

                        <div class="card-header bg-success text-white">

                            Sobre o Sistema

                        </div>

                        <div class="card-body">

                            <p>

                                O <strong>CodeQuiz</strong> é um ambiente interativo para auxiliar professores na
                                criação de avaliações e no acompanhamento do desempenho dos alunos.

                            </p>

                            <ul>

                                <li>✔ Cadastro de Turmas</li>

                                <li>✔ Criação de Questionários</li>

                                <li>✔ Correção Automática</li>

                                <li>✔ Feedback ao Aluno</li>

                                <li>✔ Relatórios de Desempenho</li>

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