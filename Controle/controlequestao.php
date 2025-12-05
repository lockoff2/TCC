<?php

include_once __DIR__ . '/../Banco/conexao.php';

class controlequestao
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = new Conexao();
        $this->conexao = $this->conexao->conexao();
    }

    public function todasQuestoes()
    {
        $stmt = $this->conexao->prepare("SELECT * FROM questoes;");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function cadastrarQuestao(Questao $questao)
    {
        $sql = "INSERT INTO questoes (titulo, descricao, tipo, professorid, questionarioid)
                VALUES (:etitulo, :edescricao, :etipo, :eprofessorid, :equestionarioid)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':etitulo', $questao->getTitulo());
        $stmt->bindValue(':edescricao', $questao->getDescricao());
        $stmt->bindValue(':etipo', $questao->getTipo());
        $stmt->bindValue(':eprofessorid', $questao->getProfessorid());
        $stmt->bindValue(':equestionarioid', $questao->getQuestionarioid());

        $stmt->execute();

        return $this->conexao->lastInsertId(); 
    }

    public function cadastrarOpcoes(Opcoes $opcao)
    {
        $sql = "INSERT INTO opcoes (conteudo, resposta, questaoid)
                VALUES (:econteudo, :eresposta, :equestaoid)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':econteudo', $opcao->getConteudo());

        // 🔥 Aqui está a correção: armazenar 1 ou 0 em vez de boolean
        $stmt->bindValue(':eresposta', $opcao->getResposta() ? 1 : 0, PDO::PARAM_INT);

        $stmt->bindValue(':equestaoid', $opcao->getQuestaoid());

        $stmt->execute();
    }
}
