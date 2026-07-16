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
        return $stmt->fetchAll();
    }

    public function cadastrarTurma(Turma $turma)
    {
        $sql = "INSERT INTO turma(nome, descricao, professorid)
                VALUES(:enome, :edescricao, :eprofessorid);";

        $pstmt = $this->conexao->prepare($sql);
        $pstmt->bindValue(':enome', $turma->getNome());
        $pstmt->bindValue(':edescricao', $turma->getDescricao());
        $pstmt->bindValue(':eprofessorid', $turma->getProfessorid());

        return $pstmt->execute();
    }

    public function apagarTurma($idturma)
    {
        $stmt = $this->conexao->prepare("DELETE FROM turma WHERE id = :idturma");
        $stmt->bindValue(':idturma', $idturma, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarTurmaPorId($idTurma)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM turma WHERE id = ?;");
        $stmt->execute([$idTurma]);
        return $stmt->fetch();
    }

    public function removerTurmaaluno($idturma, $idaluno)
    {
        $stmt = $this->conexao->prepare("
            DELETE FROM turmaaluno 
            WHERE alunoid = :idaluno AND turmaid = :idturma
        ");
        $stmt->bindValue(':idaluno', $idaluno);
        $stmt->bindValue(':idturma', $idturma);
        return $stmt->execute();
    }

    public function listarTurmasProfessor($idprofessor)
    {
        $stmt = $this->conexao->prepare("
            SELECT * FROM turma WHERE professorid = :idprofessor
        ");
        $stmt->bindValue(':idprofessor', $idprofessor);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function turmaaluno($idaluno, $turmaid)
    {
        $sql = "INSERT INTO turmaaluno(alunoid, turmaid)
                VALUES(:ealunoid, :eturmaid);";

        $pstmt = $this->conexao->prepare($sql);
        $pstmt->bindValue(':ealunoid', $idaluno);
        $pstmt->bindValue(':eturmaid', $turmaid);

        return $pstmt->execute();
    }

    public function NomeTurma($idTurma)
    {
        $stmt = $this->conexao->prepare("SELECT nome FROM turma WHERE id = :idturma");
        $stmt->bindValue(':idturma', $idTurma);
        $stmt->execute();
        $turma = $stmt->fetch(PDO::FETCH_ASSOC);

        return $turma['nome'] ?? null;
    }

    public function getUltimaTurmaInserida()
    {
        return $this->conexao->lastInsertId();
    }

    public function buscarTurmasPorAluno($idAluno)
    {
        $stmt = $this->conexao->prepare("
        SELECT t.id
        FROM turma t
        INNER JOIN turmaaluno ta ON ta.turmaid = t.id
        WHERE ta.alunoid = :idAluno
    ");

        $stmt->bindValue(':idAluno', $idAluno);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarTurma(Turma $turma)
    {
        $sql = "UPDATE turma 
                SET nome = :enome, descricao = :edescricao, professorid = :eprofessorid
                WHERE id = :eid";

        $pstmt = $this->conexao->prepare($sql);
        $pstmt->bindValue(':enome', $turma->getNome());
        $pstmt->bindValue(':edescricao', $turma->getDescricao());
        $pstmt->bindValue(':eprofessorid', $turma->getProfessorid());
        $pstmt->bindValue(':eid', $turma->getId());

        return $pstmt->execute();
    }
}
?>