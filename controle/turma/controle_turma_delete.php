<?php
// Inclui a classe Turma.php, que provavelmente contém funcionalidades relacionadas as turmas
require_once ("modelo/Turma.php");
// Cria um novo objeto para armazenar a resposta
$objResposta = new stdClass();
// Cria um novo objeto da classe Turma
$objTurma = new Turma();
// Define o ID da turma a ser excluída
$objTurma->setidTurma($idTurma);
// Verifica se a exclusão da turma foi bem-sucedida 
if($objTurma->delete()==true){
    // Define o código de status da resposta como 204 (No Content)
    header("HTTP/1.1 204");
}else{
    // Define o código de status da resposta como 200 (OK)
    header("HTTP/1.1 200");
    // Define o tipo de conteúdo da resposta como JSON
    header("Content-Type: application/json");
    // Define o status da resposta como falso
    $objResposta->status = false;
    // Define o código de resposta como 1
    $objResposta->cod = 1;
    // Define a mensagem de erro
    $objResposta->msg = "Erro ao excluir turma";
    // Converte o objeto resposta em JSON e o imprime na saída
    echo json_encode($objResposta);
}
?>
