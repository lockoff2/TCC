<?php

include_once __DIR__ . '/../Banco/conexao.php';


class controlequestionario
{

    private $conexao;


    public function __construct()
    {
        $this->conexao = new Conexao();
        $this->conexao = $this->conexao->conexao();
    }

    public function todosquestionarios()
    {

        $stmt = $this->conexao->prepare("SELECT * FROM questionario;");
        $stmt->execute();
        $questionario = $stmt->fetchAll();
        $stmt = null;
        return $questionario;
    }

    public function listarQuestionariosProfessor($professorId)
    {
        $sql = "SELECT q.id, q.titulo, q.descricao FROM questionario q WHERE q.professorid = :professorId;";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':professorId', $professorId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrarQuestionario(Questionario $questionario)
    {
        $sql = "INSERT INTO questionario(titulo, descricao, professorid, turmaid ) VALUES(:etitulo, :edescricao, :eprofessorid, :eturmaid);";
        $pstmt = $this->conexao->prepare($sql);
        $pstmt->bindValue(':etitulo', $questionario->getTitulo());
        $pstmt->bindValue(':edescricao', $questionario->getDescricao());
        $pstmt->bindValue(':eprofessorid', $questionario->getProfessorid());
        $pstmt->bindValue(':eturmaid', $questionario->getTurmaid());
        $result = $pstmt->execute();
        return $result;
    }

    public function listarTurmasProfessor($idprofessor)
    {
        $stmt = $this->conexao->prepare("SELECT * FROM turma WHERE professorid = :idprofessor");
        $stmt->bindParam(':idprofessor', $idprofessor, PDO::PARAM_INT);
        $stmt->execute();
        $anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $anuncios;
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