<?php
    // Inclui as classes Banco e Professor, que contêm funcionalidades relacionadas ao banco de dados e aos professores
    require_once ("modelo/Banco.php");
    require_once ("modelo/professor.php");

    // Obtém os dados enviados por meio de uma requisição POST em formato JSON
    $textoRecebido = file_get_contents("php://input");
    // Decodifica os dados JSON recebidos em um objeto PHP ou interrompe o script se o formato estiver incorreto
    $objJson = json_decode($textoRecebido) or die('{"msg":"formato incorreto"}');

    // Cria um novo objeto para armazenar a resposta 
    $objResposta = new stdClass();
    // Cria um novo objeto da classe professor
    $objProfessor = new Professor();

    // Define o nome do professor recebido do JSON no objeto professor
    $objProfessor->setnomeProfessor($objJson->professores->nomeProfessor);
    $objProfessor->settelefone($objJson->professores->telefone);
    $objProfessor->setcpf($objJson->professores->cpf);
    $objProfessor->setespecialidade($objJson->professores->especialidade);
    $objProfessor->setescolas_idEscola($objJson->professores->escolas_idEscola);

    // Verifica se o nomeProfessor do professor está vazio
    if ($objProfessor->getnomeProfessor() == "") {
        $objResposta->cod = 1;
        $objResposta->status = false;
        $objResposta->msg = "o nome do professor nao pode ser vazio";
    } 

    // Verifica se já existe um professor cadastrado com o mesmo nomeProfessor
    else if ($objProfessor->isprofessor() == true) {
        $objResposta->cod = 3;
        $objResposta->status = false;
        $objResposta->msg = "Ja existe um professor cadastrado com o nome: " . $objProfessor->getnomeProfessor();
    } 
    // Se todas as condições anteriores forem atendidas, tenta criar um novo professor
    else {
        // Verifica se a criação da nova professor foi bem-sucedida
        if ($objProfessor->create() == true) {
            $objResposta->cod = 4;
            $objResposta->status = true;
            $objResposta->msg = "cadastrado com sucesso";
            $objResposta->novaProfessor = $objProfessor;
        } 
        // Se houver erro na criação do professor, define a mensagem de erro
        else {
            $objResposta->cod = 5;
            $objResposta->status = false;
            $objResposta->msg = "Erro ao cadastrar novo professor";
        }
    }

    // Define o tipo de conteúdo da resposta como JSON
    header("Content-Type: application/json");

    // Define o código de status da resposta com base no status da operação
    if ($objResposta->status == true) {
        header("HTTP/1.1 201");
    } else {
        header("HTTP/1.1 200");
    }

    // Converte o objeto resposta em JSON e o imprime na saída
    echo json_encode($objResposta);

?>
