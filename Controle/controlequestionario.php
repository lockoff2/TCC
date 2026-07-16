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
        return $stmt->fetchAll();
    }

    public function listarQuestionariosProfessor($professorId)
    {
        $sql = "SELECT q.id, q.titulo, q.descricao 
                FROM questionario q 
                WHERE q.professorid = :professorId";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':professorId', $professorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarQuestionariosPorVariasTurmas(array $turmas)
    {
        if (empty($turmas)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($turmas), '?'));

        $sql = "SELECT * FROM questionario 
            WHERE turmaid IN ($placeholders)";

        $stmt = $this->conexao->prepare($sql);

        foreach ($turmas as $i => $idTurma) {
            $stmt->bindValue($i + 1, $idTurma);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarQuestionariosPorTurma($idTurma)
    {
        $stmt = $this->conexao->prepare("
        SELECT * FROM questionario
        WHERE turmaid = :turma
    ");
        $stmt->bindValue(':turma', $idTurma);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function cadastrarQuestionario(Questionario $questionario)
    {
        $sql = "INSERT INTO questionario (titulo, descricao, professorid, turmaid)
                VALUES (:etitulo, :edescricao, :eprofessorid, :eturmaid)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':etitulo', $questionario->getTitulo());
        $stmt->bindValue(':edescricao', $questionario->getDescricao());
        $stmt->bindValue(':eprofessorid', $questionario->getProfessorid());
        $stmt->bindValue(':eturmaid', $questionario->getTurmaid());

        $stmt->execute();
        return true;
    }

    public function apagarQuestionario($id)
    {


        // 3 — apagar o questionário
        $sqlQuestionario = "DELETE FROM questionario WHERE id = :id";
        $stmt3 = $this->conexao->prepare($sqlQuestionario);
        $stmt3->bindValue(":id", $id);
        return $stmt3->execute();
    }

    public function getUltimoQuestionarioInserido()
    {
        return $this->conexao->lastInsertId();
    }
}


?>