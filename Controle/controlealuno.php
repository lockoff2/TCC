<?php

include_once __DIR__ . '/../Banco/conexao.php';


class controlealuno
{

    public function todosalunos()
    {
        $conexao = new Conexao();
        $conexao = $conexao->conexao();
        $stmt = $conexao->prepare("SELECT * FROM aluno;");
        $stmt->execute();
        $aluno = $stmt->fetchAll();
        $stmt = null;
        return $aluno;
    }

    public function cadastraraluno(Aluno $aluno)
    {
        $conexao = new Conexao();
        $conexao = $conexao->conexao();
        $sql = "INSERT INTO aluno(nome, cpf, email, senha) VALUES(:enome, :ecpf, :eemail, :esenha);";
        $pstmt = $conexao->prepare($sql);
        $pstmt->bindValue(':enome', $aluno->getNome());
        $pstmt->bindValue(':ecpf', $aluno->getCpf());
        $pstmt->bindValue(':eemail', $aluno->getEmail());
        $pstmt->bindValue(':esenha', $aluno->getSenha());
        $result = $pstmt->execute();
        return $result;
    }

    public function login($email, $senha)
    {
        $conexao = new Conexao();
        $conexao = $conexao->conexao();
        $pstmt = $conexao->prepare("SELECT id, nome, cpf, email, senha  FROM aluno WHERE email = :email AND senha = :senha");
        $pstmt->execute(array('email' => $email, 'senha' => $senha));
        if ($pstmt->rowcount() > 0) {
            $result = $pstmt->fetch();
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['user_email'] = $result['email'];
            $_SESSION['user_cpf'] = $result['cpf'];
            $_SESSION['user_nome'] = $result['nome'];
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {

        session_destroy();
    }

    public function returnid()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        } else {
            return null;
        }

    }
    public function isLoggedIn()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            return true;
        }
        return false;
    }

    public function listarAlunosPorTurma($idturma)
    {
        $conexao = new Conexao();
        $conexao = $conexao->conexao();
        $stmt = $conexao->prepare(
            "SELECT aluno.id, aluno.nome, aluno.email
            FROM aluno
            INNER JOIN turmaaluno ON aluno.id = turmaaluno.alunoid
            WHERE turmaaluno.turmaid = :turmaid"
        );

        $stmt->bindValue(':turmaid', $idturma); 
        $stmt->execute(); 
        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        return $alunos;
    }

    public function listarTurmasAluno($idAluno)
{
    $conexao = new Conexao();
        $conexao = $conexao->conexao();
        $stmt = $conexao->prepare(
        "SELECT t.id, t.nome, t.descricao 
                FROM turma t
                INNER JOIN turmaaluno ta ON t.id = ta.turmaid
                WHERE ta.alunoid = :idAluno;"
        );

        $stmt->bindValue(':idAluno', $idAluno); 
        $stmt->execute(); 
        $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        return $turmas;
}

public function buscarPorId($idAluno) {
    $conexao = new Conexao();
    $conexao = $conexao->conexao();
    $stmt = $conexao->prepare("SELECT * FROM aluno WHERE id = :id");
    $stmt->bindValue(':id', $idAluno);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>