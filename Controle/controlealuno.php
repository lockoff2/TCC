<?php

include_once  __DIR__ . '/../Banco/conexao.php';


class controlealuno{

 public function todosalunos() {
            $conexao = new Conexao();
            $conexao = $conexao->conexao();
            $stmt = $conexao->prepare("SELECT * FROM aluno;");
            $stmt->execute();
            $professor = $stmt->fetchAll();
            $stmt = null;
            return $professor;
        }

        public function cadastraraluno(Aluno $aluno) {
            $conexao = new Conexao();
            $conexao = $conexao->conexao();
            $sql = "INSERT INTO aluno(nome, cpf, email, senha) VALUES(:enome, :ecpf, :eemail, :esenha);";
            $pstmt = $conexao->prepare($sql);
            $pstmt->bindValue(':enome', $aluno->getNome());
            $pstmt->bindValue(':ecpf', $aluno->getCpf());
            $pstmt->bindValue(':eemail',$aluno->getEmail());
            $pstmt->bindValue(':esenha', $aluno->getSenha());
            $result =  $pstmt->execute();
            return $result;
        }

        public function login($email, $senha) {
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
            }else {
                return false;
            }
        }

        public function logout(){
            session_destroy();
        }

        public function returnid() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (isset($_SESSION['user_id'])) {
                return $_SESSION['user_id'];
            } else {
                return null;
            }

        }        public function isLoggedIn(){
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
                return true;
            }
            return false;
        }
}
?>