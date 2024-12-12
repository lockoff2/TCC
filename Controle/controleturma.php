<?php

include_once __DIR__ . '/../Banco/conexao.php';


class controleturmma
{

    private $conexao;


    public function __construct()
    {
        $this->conexao = new Conexao();
        $this->conexao = $this->conexao->conexao();
    }

    public function todasturmas()
    {

        $stmt = $this->conexao->prepare("SELECT * FROM turma;");
        $stmt->execute();
        $turma = $stmt->fetchAll();
        $stmt = null;
        return $turma;
    }

    public function cadastrarTurma(Turma $turma)
    {
        $sql = "INSERT INTO turma(nome, descricao, professorid ) VALUES(:enome, :edescricao, :eprofessorid);";
        $pstmt = $this->conexao->prepare($sql);
        $pstmt->bindValue(':enome', $turma->getNome());
        $pstmt->bindValue(':edescricao', $turma->getDescricao());
        $pstmt->bindValue(':eprofessorid', $turma->getProfessorid());
        $result = $pstmt->execute();
        return $result;
    }

    public function listarTurmasProfessor($idprofessor)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM turma WHERE professorid = :idprofessor");
        $stmt->bindParam(':idprofessor', $idprofessor, PDO::PARAM_INT);
        $stmt->execute();
        $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $turmas;
    }

    public function turmaaluno($idaluno, $turmaid)
    {
        $sql = "INSERT INTO turmaaluno(alunoid, turmaid ) VALUES( :ealunoid, :eturmaid);";
        $pstmt = $this->conexao->prepare($sql);
        $pstmt->bindValue(':ealunoid', $idaluno);
        $pstmt->bindValue(':eturmaid', $turmaid);
        $result = $pstmt->execute();
        return $result;
    }

    public function NomeTurma($idTurma)
    {
        $stmt = $this->conexao->prepare("SELECT nome FROM turma WHERE id = :idturma");
        $stmt->bindParam(':idturma', $idTurma); 
        $stmt->execute();
        $turma = $stmt->fetch(PDO::FETCH_ASSOC); 
        if ($turma) {
            return $turma['nome']; 
        } else {
            return null; 
        }
    }

    public function getUltimaTurmaInserida()
    {
        return $this->conexao->lastInsertId();
    }

    public function editarTurma(Turma $turma)
    {

        $sqlSetor = "UPDATE setor SET nome = :enome, descricao = :edescricao WHERE id = :eid AND professorid = :eprofessorid";
        $pstmt = $this->conexao->prepare($sqlSetor);
        $pstmt->bindValue(':enome', $turma->getNome());
        $pstmt->bindValue(':edescricao', $turma->getDescricao());
        $pstmt->bindValue(':eprofessorid', $turma->getProfessorid());
        $pstmt->bindValue(':eid', $turma->getId());

        $pstmt->execute();

        return true;
    }
}

?>