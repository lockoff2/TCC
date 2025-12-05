<?php 

include_once __DIR__ . '/../Banco/conexao.php';

class controleprofessor {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao = $this->conexao->conexao();
    }

    public function todosprofessores() {
        $stmt = $this->conexao->prepare("SELECT * FROM professor;");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function cadastrarprofessor(Professor $professor) {
        $sql = "INSERT INTO professor(nome, cpf, email, senha)
                VALUES(:enome, :ecpf, :eemail, :esenha);";

        $pstmt = $this->conexao->prepare($sql);
        $pstmt->bindValue(':enome', $professor->getNome());
        $pstmt->bindValue(':ecpf', $professor->getCpf());
        $pstmt->bindValue(':eemail', $professor->getEmail());
        $pstmt->bindValue(':esenha', $professor->getSenha());

        return $pstmt->execute();
    }

    public function buscarPorId($idProfessor) {
        $sql = "SELECT * FROM professor WHERE id = :idprof;";
        $pstmt = $this->conexao->prepare($sql);
        $pstmt->bindValue(':idprof', $idProfessor);
        $pstmt->execute();
        return $pstmt->fetch();
    }

    public function login($email, $senha) {

        $sql = "SELECT id, nome, cpf, email, senha 
                FROM professor 
                WHERE email = :email AND senha = :senha";

        $pstmt = $this->conexao->prepare($sql);
        $pstmt->execute([
            'email' => $email,
            'senha' => $senha
        ]);

        if ($pstmt->rowCount() > 0) {
            $result = $pstmt->fetch();

            $_SESSION['logged_in']  = true;
            $_SESSION['user_id']    = $result['id'];
            $_SESSION['user_email'] = $result['email'];
            $_SESSION['user_cpf']   = $result['cpf'];
            $_SESSION['user_nome']  = $result['nome'];

            return true;
        }

        return false;
    }

    public function logout() {
        $_SESSION['logged_in'] = false;
        session_destroy();
        header('Location: ../Telas/login.php');
        exit;
    }

    public function returnid() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user_id'] ?? null;
    }

    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
}
?>
