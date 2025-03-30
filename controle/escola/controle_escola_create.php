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

    // Define o nome do Escola recebido do JSON no objeto Escola
    $objEscola->setemail($objJson->escolas->email);
    $objEscola->setnomeEscola($objJson->escolas->nomeEscola);


    // Verifica se o nomeEscola da Escola está vazio
    if ($objEscola->getnomeEscola() == "") {
        $objResposta->cod = 1;
        $objResposta->status = false;
        $objResposta->msg = "o nome da escola nao pode ser vazio";
    } 

    // Verifica se já existe uma escola cadastrado com o mesmo nome 
    else if ($objEscola->isescola() == true) {
        $objResposta->cod = 3;
        $objResposta->status = false;
        $objResposta->msg = "Ja existe uma Escola cadastrada com o nome: " . $objEscola->getnomeEscola();
    } 
    // Se todas as condições anteriores forem atendidas, tenta criar uma nova Escola
    else {
        // Verifica se a criação da nova Escola foi bem-sucedida
        if ($objEscola->create() == true) {
            $objResposta->cod = 4;
            $objResposta->status = true;
            $objResposta->msg = "cadastrado com sucesso";
            $objResposta->novaEscola = $objEscola;
        } 
        // Se houver erro na criação da Escola, define a mensagem de erro
        else {
            $objResposta->cod = 5;
            $objResposta->status = false;
            $objResposta->msg = "Erro ao cadastrar nova Escola";
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
