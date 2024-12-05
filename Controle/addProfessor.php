<?php
include_once  __DIR__ . '/../Banco/conexao.php';
include_once 'controleprofessor.php';

function addProfessor(Professor $professor) {
    $professordao = new controleprofessor();
    $result = $professordao->cadastrarprofessor($professor);

    if ($result){
        echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../../TCC/Telas/login.php'>
            <script type=\"text/javascript\">
                alert(\"Cadastro realizado com sucesso!\");
            </script>
            ";
    }else{
        echo "Erro ao cadastrar";
    }
}
?>
