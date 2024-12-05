<?php
/*
session_start();
include_once 'Controle/controleusuario.php';
include_once 'Controle/controleevento.php';
include_once 'Model/Evento.php';
$user = new controleusuario();
if (!$user->isLoggedIn()) {
    header('Location: login.php');
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $evento = new Evento();
    $evento->setNomeevento($_POST['nomeEvento']);
    $evento->setDescricao($_POST['descricao']);
    $evento->setEstilo($_POST['estilo']);
    $evento->setLocal($_POST['local']);
    $evento->setTipo($_POST['tipo']);

    $eventodao = new controleevento();
    $eventoid = $eventodao->cadastrarEvento($evento);

    // Redirecionar para a página setor.php com o ID do evento via GET
    header("Location: cadastrosetor.php?eventoid=$eventoid");
    exit;
}
*/
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../CSS/cadastro.css">
    <script src="JS/bootstrap.bundle.min.js"></script>
    <link href="CSS/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="text-center">
        <h1>Loja Virtual de Ingressos</h1>
    </header>
    <nav class="text-center">
        <a href="index.php">Início</a>

        <?php
        /*if ($user->isLoggedIn()) {
            echo '<a href="eventos.php">Seus Eventos</a>';
            echo '<a href="Controle/sair.php">Sair</a>';
        } else {
            echo '<a href="login.php">Login/Cadastre-se</a>';
        }*/
        ?>
    </nav>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Cadastrar uma Turma</h2>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nomeTurma" class="form-label">Nome da Turma:</label>
                    <input type="text" id="nomeTurma" name="nomeTurma" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição da Turma:</label>
                    <textarea id="descricao" name="descricao" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="alunos" class="form-label">Selecione os Alunos:</label>
                    <select id="alunos" name="alunos[]" class="form-control" multiple>
                        <?php

                        include_once '../Controle/controlealuno.php';
                        $aluno = new controlealuno();
                        $alunos = $aluno->todosalunos();
                        foreach ($alunos as $aluno) {
                            echo "<option value='{$aluno['id']}'>{$aluno['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="text-center">
                    <input type="submit" name="enviar" value="Próximo" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#alunos').select2({
            placeholder: "Selecione os alunos",
            allowClear: true,
        });
    });
    </script>

    <footer class="text-center">
        <p>&copy; 2024 Site de Venda de Ingressos</p>
    </footer>



</body>

</html>