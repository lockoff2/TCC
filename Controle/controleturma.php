<?php

include_once __DIR__ . '/../Banco/conexao.php';


class controleturmma
{

    public function todasturmas()
    {
        $conexao = new Conexao();
        $conexao = $conexao->conexao();
        $stmt = $conexao->prepare("SELECT * FROM turma;");
        $stmt->execute();
        $turma = $stmt->fetchAll();
        $stmt = null;
        return $turma;
    }

    public function cadastrarTurma(Turma $turma)
    {
        $conexao = new Conexao();
        $conexao = $conexao->conexao();
        $sql = "INSERT INTO turma(nome, descricao, professorid, alunoid ) VALUES(:enome, :edescricao, :eprofessorid, :ealunoid);";
        $pstmt = $conexao->prepare($sql);
        $pstmt->bindValue(':enome', $turma->getNome());
        $pstmt->bindValue(':edescricao', $turma->getDescricao());
        $pstmt->bindValue(':eprofessorid', $turma->getProfessorid());
        $pstmt->bindValue(':ealunoid', $turma->getAlunoid());
        $result = $pstmt->execute();
        return $result;
    }

    public function listarTurmasProfessor($idprofessor)
    {
        $conexao = new Conexao();
        $conexao = $conexao->conexao();
        $stmt = $conexao->prepare("SELECT * FROM turma WHERE professorid = :idprofessor");
        $stmt->bindParam(':idprofessor', $idprofessor, PDO::PARAM_INT);
        $stmt->execute();
        $anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $anuncios;
    }

    public function editarTurma(Turma $turma)
    {

        $conexao = new Conexao();
        $conexao = $conexao->conexao();

        $sqlSetor = "UPDATE setor SET nome = :enome, descricao = :edescricao WHERE id = :eid AND professorid = :eprofessorid";
        $pstmt = $conexao->prepare($sqlSetor);
        $pstmt->bindValue(':enome', $turma->getNome());
        $pstmt->bindValue(':edescricao', $turma->getDescricao());
        $pstmt->bindValue(':eprofessorid', $turma->getProfessorid());
        $pstmt->bindValue(':eid', $turma->getId());

        $pstmt->execute();

        return true;
    }
}

?>