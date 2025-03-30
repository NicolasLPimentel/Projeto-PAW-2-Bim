<?php
// Inclui as classes Banco e Turma, que contêm funcionalidades relacionadas ao banco de dados e as turmas
require_once ("modelo/Banco.php");
require_once ("modelo/Turma.php");

// Cria um novo objeto para armazenar a resposta
$objResposta = new stdClass();

// Cria um novo objeto da classe Turma
$objTurma = new Turma();
// Define o ID da turma a ser lido 
$objTurma->setidTurma($idTurma);

// Obtém a turma específica do banco de dados com base no ID fornecido
$vetor = $objTurma ->readByID();

// Define o código de resposta como 1
$objResposta->cod = 1;
// Define o status da resposta como verdadeiro
$objResposta->status = true;
// Define a mensagem de sucesso
$objResposta->msg = "executado com sucesso";
// Define o vetor de turmas na resposta
$objResposta->turmas = $vetor;

// Define o código de status da resposta como 200 (OK)
header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");
// Converte o objeto resposta em JSON e o imprime na saída
echo json_encode($objResposta);

?>
