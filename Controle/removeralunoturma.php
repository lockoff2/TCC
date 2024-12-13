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

if (isset($_GET['idTurma'])&& isset($_GET['idAluno'])) {
    $idturma = $_GET['idTurma'];
    $idaluno = $_GET['idAluno'];
    if ($turma->removerTurmaaluno($idturma, $idaluno)) {
        echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=../Telas/Gerenciaralunos.php?idTurma={$idturma}'>
              <script type=\"text/javascript\">
                  alert(\"Aluno Removido com Sucesso!\");
              </script>";
    } else {
        echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=../Telas/Gerenciaralunos.php?idTurma={$idturma}'>
              <script type=\"text/javascript\">
                  alert(\"Erro ao Remover aluno!\");
              </script>";
    }
} else {
    header('Location: ../Telas/Gerenciaralunos.php?idTurma={$idturma}');
    exit;
}

?>