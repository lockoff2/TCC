<?php
session_start();
include_once 'controleturma.php';
include_once '../Model/Turma.php';

$turmaCtrl = new controleturmma();
$professorid = $_SESSION['user_id'];

if (isset($_POST['nomeTurma']) && isset($_POST['descricao']) && isset($_POST['alunos'])) {
    $idaluno = $_POST['alunos'];
    $nometurma = $_POST['nomeTurma'];
    $descricao = $_POST['descricao'];

    $turma = new Turma();

    $turma->setNome($nometurma);
    $turma->setProfessorid($professorid);
    $turma->setDescricao($descricao);
    
    $turmaCtrl->cadastrarTurma($turma);
    
    $idturma = $turmaCtrl->getUltimaTurmaInserida();
    
    $turma->setId($idturma);


    foreach ($idaluno as $id) {
        
        $turmaCtrl->turmaaluno($id,$idturma);
    }
    
} 

?>