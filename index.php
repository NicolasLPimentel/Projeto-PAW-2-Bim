<?php
    // Inclui o arquivo Router.php, que provavelmente contém a definição da classe Router
    require_once ("modelo/Router.php");

    // Instancia um objeto da classe Router
    $roteador = new Router();

    //-------------------------TURMAS----------------------------

    // Define uma rota para a obtenção de todos as turmas 
    $roteador->get("/turmas", function () {
        // Requer o arquivo de controle responsável por obter todos os turmas
        require_once ("controle/turma/controle_turma_read_all.php");
    }); 

    // Define uma rota para a obtenção de um turma específico pelo ID
    $roteador->get("/turmas/(\d+)", function ($idTurma) {
        // Requer o arquivo de controle responsável por obter um turma pelo ID
        require_once ("controle/turma/controle_turma_read_by_id.php");
    });

    // Define uma rota para a criação de uma nova turma
    $roteador->post("/turmas", function () {
        // Requer o arquivo de controle responsável por criar uma nova turma
        require_once ("controle/turma/controle_turma_create.php");
    });

    // Define uma rota para a atualização de um turma existente pelo ID
    $roteador->put("/turmas/(\d+)", function ($idTurma) {
        // Requer o arquivo de controle responsável por atualizar um turma pelo ID
        require_once ("controle/turma/controle_turma_update.php");
    });

    // Define uma rota para a exclusão de um turma existente pelo ID
    $roteador->delete("/turmas/(\d+)", function ($idTurma) {
        // Requer o arquivo de controle responsável por excluir um turma pelo ID
        require_once ("controle/turma/controle_turma_delete.php");
    });

    //-------------------------PROFESSORES----------------------------

     // Define uma rota para a obtenção de todos os professores 
     $roteador->get("/professores", function () {
        // Requer o arquivo de controle responsável por obter todos os turmas
        require_once ("controle/professor/controle_professor_read_all.php");
    }); 

    // Define uma rota para a obtenção de um turma específico pelo ID
    $roteador->get("/professores/(\d+)", function ($idProfessor) {
        // Requer o arquivo de controle responsável por obter um turma pelo ID
        require_once ("controle/professor/controle_professor_read_by_id.php");
    });

    // Define uma rota para a criação de um novo professor
    $roteador->post("/professores", function () {
        // Requer o arquivo de controle responsável por criar uma nova turma
        require_once ("controle/professor/controle_professor_create.php");
    });

    // Define uma rota para a atualização de um professor existente pelo ID
    $roteador->put("/professores/(\d+)", function ($idProfessor) {
        // Requer o arquivo de controle responsável por atualizar um turma pelo ID
        require_once ("controle/professor/controle_professor_update.php");
    });

    // Define uma rota para a exclusão de um professor existente pelo ID
    $roteador->delete("/professores/(\d+)", function ($idProfessor) {
        // Requer o arquivo de controle responsável por excluir um turma pelo ID
        require_once ("controle/professor/controle_professor_delete.php");
    });

    //-------------------------ESCOLAS----------------------------

    // Define uma rota para a obtenção de todas as escolas
    $roteador->get("/escolas", function () {
        // Requer o arquivo de controle responsável por obter todos as escolas
        require_once ("controle/escola/controle_escola_read_all.php");
    });

    // Define uma rota para a obtenção de uma escola específico pelo ID
    $roteador->get("/escolas/(\d+)", function ($idEscola) {
        // Requer o arquivo de controle responsável por obter uma escola pelo ID
        require_once ("controle/escola/controle_escola_read_by_id.php");
    });

    // Define uma rota para a criação de uma nova escola
    $roteador->post("/escolas", function () {
        // Requer o arquivo de controle responsável por criar uma nova escola
        require_once ("controle/escola/controle_escola_create.php");
    });

    // Define uma rota para a atualização de uma escola existente pelo ID
    $roteador->put("/escolas/(\d+)", function ($idEscola) {
        // Requer o arquivo de controle responsável por atualizar uma escola pelo ID
        require_once ("controle/escola/controle_escola_update.php");
    });

    // Define uma rota para a exclusão de uma escola existente pelo ID
    $roteador->delete("/escolas/(\d+)", function ($idEscola) {
        // Requer o arquivo de controle responsável por excluir uma escola pelo ID
        require_once ("controle/escola/controle_escola_delete.php");
    });

    // Executa o roteador para lidar com as requisições
    $roteador->run();
?>