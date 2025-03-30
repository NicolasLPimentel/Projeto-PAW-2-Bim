<?php
    // Inclui o arquivo Banco.php, que contém funcionalidades relacionadas ao banco de dados
    require_once ("modelo/Banco.php");

    // Definição da classe Turma, que implementa a interface JsonSerializable
    class Turma implements JsonSerializable
    {
        // Propriedades privadas da classe
        private $idTurma;
        private $série;
        private $quantiaAlunos;
        private $cursoTécnico;
        private $professores_idProf;
        
        // Método necessário pela interface JsonSerializable para serialização do objeto para JSON
        public function jsonSerialize()
        {
            // Cria um objeto stdClass para armazenar os dados da turma
            $objetoResposta = new stdClass();
            // Define as propriedades do objeto com os valores das propriedades da classe
            $objetoResposta->idTurma = $this->idTurma;
            $objetoResposta->série = $this->série;
            $objetoResposta->quantiaAlunos = $this->quantiaAlunos;
            $objetoResposta->cursoTécnico = $this->cursoTécnico;
            $objetoResposta->professores_idProf = $this->professores_idProf;

            // Retorna o objeto para serialização
            return $objetoResposta;
        }
        
        // Método para criar uma nova turma no banco de dados
        public function create()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para inserir uma nova turma  
            $SQL = "INSERT INTO turmas (série, quantiaAlunos, cursoTécnico, professores_idProf)VALUES(?, ?, ?, ?);";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com a série da turma  
            $prepareSQL->bind_param("sisi", $this->série, $this->quantiaAlunos, $this->cursoTécnico, $this->professores_idProf);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Obtém o ID da turma inserida
            $idCadastrado = $conexao->insert_id;
            // Define o ID do turma na instância atual da classe
            $this->setidTurma($idCadastrado);
            // Retorna se a operação foi executada com sucesso
            return $executou;
        }
        
        // Método para excluir uma turma do banco de dados
        public function delete()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para excluir uma turma pelo ID
            $SQL = "delete from turmas where idTurma=?;";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com o ID da turma
            $prepareSQL->bind_param("i", $this->idTurma);
            // Executa a consulta
            return $prepareSQL->execute();
        }

        // Método para atualizar os dados de uma turma no banco de dados
        public function update()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para atualizar o nome da turma pelo ID
            $SQL = "update turmas set série=?,quantiaAlunos=?,cursoTécnico=?,professores_idProf=? where idTurma=?";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define os parâmetros da consulta com os novos dados da turma e o ID da turma
            $prepareSQL->bind_param("sisii", $this->série, $this->quantiaAlunos, $this->cursoTécnico, $this->professores_idProf, $this->idTurma,);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Retorna se a operação foi executada com sucesso
            return $executou;
        }
        
        // Método para verificar se uma turma já existe no banco de dados
        public function isTurma()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para contar quantas turmas possuem o mesmo nome
            $SQL = "SELECT COUNT(*) AS qtd FROM turmas WHERE série =?;";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com a série da turma
            $prepareSQL->bind_param("s", $this->série);
            // Executa a consulta
            $executou = $prepareSQL->execute();

            // Obtém o resultado da consulta
            $matrizTuplas = $prepareSQL->get_result();

            // Extrai o objeto da tupla
            $objTupla = $matrizTuplas->fetch_object();
            // Retorna se a quantidade de turmas encontradas é maior que zero
            return $objTupla->qtd > 0;

        }
        
        // Método para ler todos as turmas do banco de dados
        public function readAll()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para selecionar todos as turmas ordenados pela série
            $SQL = "Select * from turmas order by série";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Obtém o resultado da consulta
            $matrizTuplas = $prepareSQL->get_result();
            // Inicializa um vetor para armazenar as turmas
            $vetorTurmas = array();
            $i = 0;
            // Itera sobre as tuplas do resultado
            while ($tupla = $matrizTuplas->fetch_object()) {
                // Cria uma nova instância de turma para cada tupla encontrada
                $vetorTurmas[$i] = new Turma();
                // Define o ID, série, quantiaAlunos, curso e professor na instância
                $vetorTurmas[$i]->setidTurma($tupla->idTurma);
                $vetorTurmas[$i]->setsérie($tupla->série);
                $vetorTurmas[$i]->setquantiaAlunos($tupla->quantiaAlunos);
                $vetorTurmas[$i]->setcursoTécnico($tupla->cursoTécnico);
                $vetorTurmas[$i]->setprofessores_idProf($tupla->professores_idProf);

                $i++;
            }
            // Retorna o vetor com as turmas encontrados
            return $vetorTurmas;
        }
        
        // Método para ler uma turma do banco de dados com base no ID
        public function readByID()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para selecionar uma turma pelo ID
            $SQL = "SELECT * FROM turmas WHERE idTurma=?;";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com o ID da turma
            $prepareSQL->bind_param("i", $this->idTurma);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Obtém o resultado da consulta
            $matrizTuplas = $prepareSQL->get_result();
            // Inicializa um vetor para armazenar as turmas
            $vetorTurmas = array();
            $i = 0;
            // Itera sobre as tuplas do resultado
            while ($tupla = $matrizTuplas->fetch_object()) {
                // Cria uma nova instância de turma para cada tupla encontrada
                $vetorTurmas[$i] = new Turma();
                // Define o ID,série,quantia de alunos,curso e professor na instância
                $vetorTurmas[$i]->setidTurma($tupla->idTurma);
                $vetorTurmas[$i]->setsérie($tupla->série);
                $vetorTurmas[$i]->setquantiaAlunos($tupla->quantiaAlunos);
                $vetorTurmas[$i]->setcursoTécnico($tupla->cursoTécnico);
                $vetorTurmas[$i]->setprofessores_idProf($tupla->professores_idProf);

                $i++;
            }
            // Retorna o vetor com as turmas encontradas
            return $vetorTurmas;
        }

        // Método getter para idTurma
        public function getidTurma()
        {
            return $this->idTurma;
        }

        // Método setter para idTurma
        public function setidTurma($idTurma)
        {
            $this->idTurma = $idTurma;

            return $this;
        }

        //Método getter para professores_idProf
        public function getprofessores_idProf()
        {
            return $this->professores_idProf;
        }

        //Método setter para professores_idProf
        public function setprofessores_idProf($professores_idProf)
        {
            $this->professores_idProf = $professores_idProf;

            return $this;
        }

        //Método getter para quantiaAlunos
        public function getquantiaAlunos()
        {
            return $this->quantiaAlunos;
        }

        //Método setter para quantiaAlunos
        public function setquantiaAlunos($quantiaAlunos)
        {
            $this->quantiaAlunos = $quantiaAlunos;

            return $this;
        }

        //Método getter para cursoTécnico
        public function getcursotécnico()
        {
            return $this->cursoTécnico;
        }

        //Método setter para cursoTécnico
        public function setcursotécnico($cursoTécnico)
        {
            $this->cursoTécnico = $cursoTécnico;

            return $this;
        }
        

        // Método getter para série
        public function getsérie()
        {
            return $this->série;
        }

        // Método setter para série
        public function setsérie($x)
        {
            $this->série = $x;

            return $this;
        }
    }

?>
