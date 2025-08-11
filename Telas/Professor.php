<?php
session_start();
include_once '../Controle/controleprofessor.php';


$professor = new controleprofessor();


$result = $professor->isLoggedIn();


?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeQuiz</title>
    <link rel="stylesheet" type="text/css" href="../CSS/index.css">
    <script src="JS/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    
    <link href="CSS/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <h1>CodeQuiz</h1>
    </header>
    <nav>
        <?php
        if ($result == true) {
            echo '<a href="turma.php">Suas Turmas</a>';
            echo '<a href="Questionarios.php">Suas Avaliações</a>';
            echo '<a href="../Controle/sair.php">Sair</a>';
            }else{
                header('Location: ../Telas/login.php');
            }
        ?>
    </nav>
    <div class="container mt-4">
        

        </div>
    </div>
    <footer>
        <p>&copy; 2024 CodeQuiz</p>
    </footer>
</body>

</html>