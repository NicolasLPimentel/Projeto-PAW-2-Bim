<?php
    // Inclui o arquivo Banco.php, que contém funcionalidades relacionadas ao banco de dados
    require_once ("modelo/Banco.php");

    // Definição da classe Escola, que implementa a interface JsonSerializable
    class Escola implements JsonSerializable
    {
        // Propriedades privadas da classe
        private $idEscola;
        private $email;
        private $nomeEscola;
        
        // Método necessário pela interface JsonSerializable para serialização do objeto para JSON
        public function jsonSerialize()
        {
            // Cria um objeto stdClass para armazenar os dados da escola
            $objetoResposta = new stdClass();
            // Define as propriedades do objeto com os valores das propriedades da classe
            $objetoResposta->idEscola = $this->idEscola;
            $objetoResposta->nomeEscola = $this->nomeEscola;
            $objetoResposta->email = $this->email;

            // Retorna o objeto para serialização
            return $objetoResposta;
        }
        
        // Método para criar uma nova escola no banco de dados
        public function create()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para inserir uma nova escola  
            $SQL = "INSERT INTO escolas (email, nomeEscola)VALUES(?, ?);";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com o nomeEscola da escola  
            $prepareSQL->bind_param("ss", $this->email, $this->nomeEscola);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Obtém o ID da escola inserida
            $idCadastrado = $conexao->insert_id;
            // Define o ID do escola na instância atual da classe
            $this->setidEscola($idCadastrado);
            // Retorna se a operação foi executada com sucesso
            return $executou;
        }
        
        // Método para excluir uma escola do banco de dados
        public function delete()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para excluir uma escola pelo ID
            $SQL = "delete from escolas where idEscola=?;";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com o ID da escola
            $prepareSQL->bind_param("i", $this->idEscola);
            // Executa a consulta
            return $prepareSQL->execute();
        }

        // Método para atualizar os dados de uma escola no banco de dados
        public function update()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para atualizar o nome da escola pelo ID
            $SQL = "update escolas set email=?, nomeEscola=?  where idEscola=?";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define os parâmetros da consulta com os novos dados da escola e o ID da escola
            $prepareSQL->bind_param("ssi", $this->email, $this->nomeEscola, $this->idEscola);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Retorna se a operação foi executada com sucesso
            return $executou;
        }
        
        // Método para verificar se uma escola já existe no banco de dados
        public function isescola()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para contar quantas escolas possuem o mesmo nome
            $SQL = "SELECT COUNT(*) AS qtd FROM escolas WHERE nomeEscola =?;";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com o nomeEscola da escola
            $prepareSQL->bind_param("s", $this->nomeEscola);
            // Executa a consulta
            $executou = $prepareSQL->execute();

            // Obtém o resultado da consulta
            $matrizTuplas = $prepareSQL->get_result();

            // Extrai o objeto da tupla
            $objTupla = $matrizTuplas->fetch_object();
            // Retorna se a quantidade de escolas encontradas é maior que zero
            return $objTupla->qtd > 0;

        }
        
        // Método para ler todos as escolas do banco de dados
        public function readAll()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para selecionar todos as escolas ordenados pelo nomeEscola
            $SQL = "Select * from escolas order by nomeEscola";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Obtém o resultado da consulta
            $matrizTuplas = $prepareSQL->get_result();
            // Inicializa um vetor para armazenar as escolas
            $vetorEscolas = array();
            $i = 0;
            // Itera sobre as tuplas do resultado
            while ($tupla = $matrizTuplas->fetch_object()) {
                // Cria uma nova instância de escola para cada tupla encontrada
                $vetorEscolas[$i] = new Escola();
                // Define o ID, nomeEscola e email
                $vetorEscolas[$i]->setidEscola($tupla->idEscola);
                $vetorEscolas[$i]->setemail($tupla->email);
                $vetorEscolas[$i]->setnomeEscola($tupla->nomeEscola);
                

                $i++;
            }
            // Retorna o vetor com as escolas encontrados
            return $vetorEscolas;
        }
        
        // Método para ler uma escola do banco de dados com base no ID
        public function readByID()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para selecionar uma escola pelo ID
            $SQL = "SELECT * FROM escolas WHERE idEscola=?;";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com o ID da escola
            $prepareSQL->bind_param("i", $this->idEscola);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Obtém o resultado da consulta
            $matrizTuplas = $prepareSQL->get_result();
            // Inicializa um vetor para armazenar as escolas
            $vetorEscolas = array();
            $i = 0;
            // Itera sobre as tuplas do resultado
            while ($tupla = $matrizTuplas->fetch_object()) {
                // Cria uma nova instância de escola para cada tupla encontrada
                $vetorEscolas[$i] = new Escola();
                // Define o ID,email e nomeEscola
                $vetorEscolas[$i]->setidEscola($tupla->idEscola);
                $vetorEscolas[$i]->setemail($tupla->email);
                $vetorEscolas[$i]->setnomeEscola($tupla->nomeEscola);

                $i++;
            }
            // Retorna o vetor com as escolas encontradas
            return $vetorEscolas;
        }

        // Método getter para idEscola
        public function getidEscola()
        {
            return $this->idEscola;
        }

        // Método setter para idEscola
        public function setidEscola($idEscola)
        {
            $this->idEscola = $idEscola;

            return $this;
        }

        //Método getter para email
        public function getemail()
        {
            return $this->email;
        }

        //Método setter para email
        public function setemail($email)
        {
            $this->email = $email;

            return $this;
        }

        // Método getter para nomeEscola
        public function getnomeEscola()
        {
            return $this->nomeEscola;
        }

        // Método setter para nomeEscola
        public function setnomeEscola($x)
        {
            $this->nomeEscola = $x;

            return $this;
        }
    }

?>
