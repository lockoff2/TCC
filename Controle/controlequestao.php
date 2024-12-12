<?php

include_once  __DIR__ . '/../Banco/conexao.php';


class controlequestao{

 public function todasQuestoes() {
            $conexao = new Conexao();
            $conexao = $conexao->conexao();
            $stmt = $conexao->prepare("SELECT * FROM questoes;");
            $stmt->execute();
            $questoes = $stmt->fetchAll();
            $stmt = null;
            return $questoes;
        }

        public function cadastrarQuestao(Questao $questao){
            $conexao = new Conexao();
            $conexao = $conexao->conexao();
            $sql = "INSERT INTO questoes(titulo, descricao, tipo, professorid, questionarioid ) VALUES(:etitulo, :edescricao, :etipo, :eprofessorid, :equestionarioid);";
            $pstmt = $conexao->prepare($sql);
            $pstmt->bindValue(':etitulo', $questao->getTitulo());
            $pstmt->bindValue(':edescricao', $questao->getDescricao());
            $pstmt->bindValue(':etipo',$questao->getTipo());
            $pstmt->bindValue(':eprofessorid', $questao->getProfessorid());
            $pstmt->bindValue(':equestionarioid', $questao->getQuestionarioid());
            $result =  $pstmt->execute();
            return $conexao->lastInsertId();
        }

        public function cadastrarOpcoes(Opcoes $opcoes){
            $conexao = new Conexao();
            $conexao = $conexao->conexao();
            $sql = "INSERT INTO opcoes(conteudo, resposta, questaoid ) VALUES(:econteudo, :eresposta, :equestaoid);";
            $pstmt = $conexao->prepare($sql);
            $pstmt->bindValue(':econteudo', $opcoes->getConteudo());
            $pstmt->bindValue(':eresposta', $opcoes->getResposta());
            $pstmt->bindValue(':equestaoid',$opcoes->getQuestaoid());
            $result =  $pstmt->execute();
        }

}
?>