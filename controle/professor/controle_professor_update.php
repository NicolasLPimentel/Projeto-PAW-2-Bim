<?php
// Inclui as classes Banco e Professor, que contêm funcionalidades relacionadas ao banco de dados e aos professores
require_once ("modelo/Banco.php");
require_once ("modelo/Professor.php");

// Obtém os dados enviados por meio de uma requisição POST em formato JSON
$textoRecebido = file_get_contents("php://input");
// Decodifica os dados JSON recebidos em um objeto PHP ou interrompe o script se o formato estiver incorreto
$objJson = json_decode($textoRecebido) or die('{"msg":"formato incorreto"}');

// Cria um novo objeto para armazenar a resposta
$objResposta = new stdClass();
// Cria um novo objeto da classe professor
$objProfessor = new Professor();
// Define o ID da professor a ser atualizado
$objProfessor->setidProfessor($idProfessor);
// Define o nome do professor com base nos dados recebidos do JSON
$objProfessor->setnomeProfessor($objJson->professores->nomeProfessor);
// Define o telefone da professor com base nos dados recebidos do JSON
$objProfessor->settelefone($objJson->professores->telefone);
// Define o cpf da professor com base nos dados recebidos do JSON
$objProfessor->setcpf($objJson->professores->cpf);
//Define a especialidade do professor com base nos dados recebidos do JSON
$objProfessor->setespecialidade($objJson->professores->especialidade);
// Define a escola do professor com base nos dados recebidos do JSON
$objProfessor->setescolas_idEscola($objJson->professores->escolas_idEscola);


// Verifica se o nome do professor está vazio
if ($objProfessor->getnomeProfessor() == "") {
    $objResposta->cod = 1;
    $objResposta->status = false;
    $objResposta->msg = "o nome nao pode ser vazia";
} 

// Verifica se já existe um professor cadastrado com a mesmo nome
else if ($objProfessor->isprofessor() == true) {
    $objResposta->cod = 3;
    $objResposta->status = false;
    $objResposta->msg = "Ja existe um professor cadastrado com o nome: " . $objProfessor->getnomeProfessor();
} 
// Se todas as condições anteriores forem atendidas, tenta atualizar a professor
else {
    // Verifica se a atualização da professor foi bem-sucedida
    if ($objProfessor->update() == true) {
        $objResposta->cod = 4;
        $objResposta->status = true;
        $objResposta->msg = "Atualizada com sucesso";
        $objResposta->professorAtualizada = $objProfessor;
    } 
    // Se houver erro na atualização do professor, define a mensagem de erro
    else {
        $objResposta->cod = 5;
        $objResposta->status = false;
        $objResposta->msg = "Erro ao cadastrar novo professor";
    }
}
// Define o código de status da resposta como 200 (OK)
header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");
// Converte o objeto resposta em JSON e o imprime na saída
echo json_encode($objResposta);
?>
