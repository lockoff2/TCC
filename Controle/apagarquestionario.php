<?php
session_start();
include_once 'controleprofessor.php';
include_once 'controlequestionario.php';

$user = new controleprofessor();
$questionario = new controlequestionario();

if (!$user->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['idquestionario'])) {
    $idquestionario = $_GET['idquestionario'];
    if ($questionario->apagarQuestionario($idquestionario)) {
        echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../Telas/Questionarios.php'>
              <script type=\"text/javascript\">
                  alert(\"Questionario Apagado com sucesso!\");
              </script>";
    } else {
        echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../Telas/Questionarios.php'>
              <script type=\"text/javascript\">
                  alert(\"Erro ao apagar o Questionario!\");
              </script>";
    }
} else {
    header('Location: ../Telas/Questionarios.php');
    exit;
}

?>