<?php
// Inclui as classes Banco e Escola, que contêm funcionalidades relacionadas ao banco de dados e as escolas
require_once ("modelo/Banco.php");
require_once ("modelo/Escola.php");

// Obtém os dados enviados por meio de uma requisição POST em formato JSON
$textoRecebido = file_get_contents("php://input");
// Decodifica os dados JSON recebidos em um objeto PHP ou interrompe o script se o formato estiver incorreto
$objJson = json_decode($textoRecebido) or die('{"msg":"formato incorreto"}');

// Cria um novo objeto para armazenar a resposta
$objResposta = new stdClass();
// Cria um novo objeto da classe Escola
$objEscola = new Escola();
// Define o ID da Escola a ser atualizado
$objEscola->setidEscola($idEscola);
// Define o email da Escola com base nos dados recebidos do JSON
$objEscola->setemail($objJson->escolas->email);
// Define o nome da Escola com base nos dados recebidos do JSON
$objEscola->setnomeEscola($objJson->escolas->nomeEscola);


// Verifica se o nome da Escola está vazio
if ($objEscola->getnomeEscola() == "") {
    $objResposta->cod = 1;
    $objResposta->status = false;
    $objResposta->msg = "a nome da escola nao pode ser vazia";
} 

// Verifica se já existe um Escola cadastrado com a mesma nome da escola
else if ($objEscola->isescola() == true) {
    $objResposta->cod = 3;
    $objResposta->status = false;
    $objResposta->msg = "Ja existe uma escola cadastrada com o nome: " . $objEscola->getnomeEscola();
} 
// Se todas as condições anteriores forem atendidas, tenta atualizar a Escola
else {
    // Verifica se a atualização da Escola foi bem-sucedida
    if ($objEscola->update() == true) {
        $objResposta->cod = 4;
        $objResposta->status = true;
        $objResposta->msg = "Atualizada com sucesso";
        $objResposta->escolaAtualizada = $objEscola;
    } 
    // Se houver erro na atualização da Escola, define a mensagem de erro
    else {
        $objResposta->cod = 5;
        $objResposta->status = false;
        $objResposta->msg = "Erro ao cadastrar a nova Escola";
    }
}
// Define o código de status da resposta como 200 (OK)
header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");
// Converte o objeto resposta em JSON e o imprime na saída
echo json_encode($objResposta);
?>
