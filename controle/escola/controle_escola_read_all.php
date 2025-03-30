<?php
// Inclui as classes Banco e Escola, que contêm funcionalidades relacionadas ao banco de dados e as Escolas
require_once ("modelo/Banco.php");
require_once ("modelo/Escola.php");

// Cria um novo objeto para armazenar a resposta
$objResposta = new stdClass();
// Cria um novo objeto da classe Escola
$objEscola = new Escola();

// Obtém todos as Escolas do banco de dados
$vetor = $objEscola ->readAll();

// Define o código de resposta como 1
$objResposta->cod = 1;
// Define o status da resposta como verdadeiro
$objResposta->status = true;
// Define a mensagem de sucesso
$objResposta->msg = "executado com sucesso";
// Define o vetor de Escolas na resposta
$objResposta->Escolas = $vetor;

// Define o código de status da resposta como 200 (OK)
header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");
// Converte o objeto resposta em JSON e o imprime na saída
echo json_encode($objResposta);

?>
