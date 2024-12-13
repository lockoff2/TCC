<?php
session_start();
include_once 'controleprofessor.php';
include_once 'controleturma.php';

$user = new controleprofessor();
$turma = new controleturmma();

if (!$user->isLoggedIn()) {
    header('Location: ../Telas/login.php');
    exit;
}

if (isset($_GET['idturma'])) {
    $idturma = $_GET['idturma'];
    if ($turma->apagarTurma($idturma)) {
        echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../Telas/Turma.php'>
              <script type=\"text/javascript\">
                  alert(\"Turma Apagada com Sucesso!\");
              </script>";
    } else {
        echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../Telas/Turma.php'>
              <script type=\"text/javascript\">
                  alert(\"Erro ao apagar o Turma!\");
              </script>";
    }
} else {
    header('Location: ../Telas/Turma.php');
    exit;
}

?>