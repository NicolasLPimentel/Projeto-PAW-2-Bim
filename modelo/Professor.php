<?php
    // Inclui o arquivo Banco.php, que contém funcionalidades relacionadas ao banco de dados
    require_once ("modelo/Banco.php");

    // Definição da classe Professor, que implementa a interface JsonSerializable
    class Professor implements JsonSerializable
    {
        // Propriedades privadas da classe
        private $idProfessor;
        private $nomeProfessor;
        private $telefone;
        private $cpf;
        private $especialidade;
        private $escolas_idEscola;
        
        // Método necessário pela interface JsonSerializable para serialização do objeto para JSON
        public function jsonSerialize()
        {
            // Cria um objeto stdClass para armazenar os dados do Professor
            $objetoResposta = new stdClass();
            // Define as propriedades do objeto com os valores das propriedades da classe
            $objetoResposta->idProfessor = $this->idProfessor;
            $objetoResposta->nomeProfessor = $this->nomeProfessor;
            $objetoResposta->telefone = $this->telefone;
            $objetoResposta->cpf = $this->cpf;
            $objetoResposta->especialidade = $this->especialidade;
            $objetoResposta->escolas_idEscola = $this->escolas_idEscola;

            // Retorna o objeto para serialização
            return $objetoResposta;
        }
        
        // Método para criar um novo professor no banco de dados
        public function create()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para inserir um novo Professor  
            $SQL = "INSERT INTO professores (nomeProfessor, telefone, cpf, especialidade, escolas_idEscola)VALUES(?, ?, ?, ?, ?);";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com o nome do Professor  
            $prepareSQL->bind_param("ssssi", $this->nomeProfessor, $this->telefone, $this->cpf, $this->especialidade, $this->escolas_idEscola);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Obtém o ID do Professor inserido
            $idCadastrado = $conexao->insert_id;
            // Define o ID do Professor na instância atual da classe
            $this->setidProfessor($idCadastrado);
            // Retorna se a operação foi executada com sucesso
            return $executou;
        }
        
        // Método para excluir um Professor do banco de dados
        public function delete()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para excluir uma Professor pelo ID
            $SQL = "delete from professores where idProfessor=?;";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com o ID da Professor
            $prepareSQL->bind_param("i", $this->idProfessor);
            // Executa a consulta
            return $prepareSQL->execute();
        }

        // Método para atualizar os dados de uma Professor no banco de dados
        public function update()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para atualizar o nome da Professor pelo ID
            $SQL = "update professores set nomeProfessor=?,telefone=?,cpf=?, especialidade=?,escolas_idEscola=? where idProfessor=?";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define os parâmetros da consulta com os novos dados da Professor e o ID da Professor
            $prepareSQL->bind_param("ssssii", $this->nomeProfessor, $this->telefone, $this->cpf, $this->especialidade, $this->escolas_idEscola, $this->idProfessor,);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Retorna se a operação foi executada com sucesso
            return $executou;
        }
        
        // Método para verificar se uma Professor já existe no banco de dados
        public function isprofessor()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para contar quantas professores possuem o mesmo nome
            $SQL = "SELECT COUNT(*) AS qtd FROM professores WHERE nomeProfessor =?;";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com a nomeProfessor do Professor
            $prepareSQL->bind_param("s", $this->nomeProfessor);
            // Executa a consulta
            $executou = $prepareSQL->execute();

            // Obtém o resultado da consulta
            $matrizTuplas = $prepareSQL->get_result();

            // Extrai o objeto da tupla
            $objTupla = $matrizTuplas->fetch_object();
            // Retorna se a quantidade de professores encontradas é maior que zero
            return $objTupla->qtd > 0;

        }
        
        // Método para ler todos os professores do banco de dados
        public function readAll()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para selecionar todos as professores ordenados pela nomeProfessor
            $SQL = "Select * from professores order by nomeProfessor";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Obtém o resultado da consulta
            $matrizTuplas = $prepareSQL->get_result();
            // Inicializa um vetor para armazenar os professores
            $vetorprofessores = array();
            $i = 0;
            // Itera sobre as tuplas do resultado
            while ($tupla = $matrizTuplas->fetch_object()) {
                // Cria uma nova instância de Professor para cada tupla encontrada
                $vetorprofessores[$i] = new Professor();
                // Define o ID, nomeProfessor, telefone, curso e professor na instância
                $vetorprofessores[$i]->setidProfessor($tupla->idProfessor);
                $vetorprofessores[$i]->setnomeProfessor($tupla->nomeProfessor);
                $vetorprofessores[$i]->settelefone($tupla->telefone);
                $vetorprofessores[$i]->setcpf($tupla->cpf);
                $vetorprofessores[$i]->setespecialidade($tupla->especialidade);
                $vetorprofessores[$i]->setescolas_idEscola($tupla->escolas_idEscola);

                $i++;
            }
            // Retorna o vetor com as professores encontrados
            return $vetorprofessores;
        }
        
        // Método para ler uma Professor do banco de dados com base no ID
        public function readByID()
        {
            // Obtém a conexão com o banco de dados
            $conexao = Banco::getConexao();
            // Define a consulta SQL para selecionar uma Professor pelo ID
            $SQL = "SELECT * FROM professores WHERE idProfessor=?;";
            // Prepara a consulta
            $prepareSQL = $conexao->prepare($SQL);
            // Define o parâmetro da consulta com o ID da Professor
            $prepareSQL->bind_param("i", $this->idProfessor);
            // Executa a consulta
            $executou = $prepareSQL->execute();
            // Obtém o resultado da consulta
            $matrizTuplas = $prepareSQL->get_result();
            // Inicializa um vetor para armazenar as professores
            $vetorprofessores = array();
            $i = 0;
            // Itera sobre as tuplas do resultado
            while ($tupla = $matrizTuplas->fetch_object()) {
                // Cria uma nova instância de Professor para cada tupla encontrada
                $vetorprofessores[$i] = new Professor();
                // Define o ID,nomeProfessor,quantia de alunos,curso e professor na instância
                $vetorprofessores[$i]->setidProfessor($tupla->idProfessor);
                $vetorprofessores[$i]->setnomeProfessor($tupla->nomeProfessor);
                $vetorprofessores[$i]->settelefone($tupla->telefone);
                $vetorprofessores[$i]->setcpf($tupla->cpf);
                $vetorprofessores[$i]->setespecialidade($tupla->especialidade);
                $vetorprofessores[$i]->setescolas_idEscola($tupla->escolas_idEscola);

                $i++;
            }
            // Retorna o vetor com as professores encontradas
            return $vetorprofessores;
        }

        // Método getter para idProfessor
        public function getidProfessor()
        {
            return $this->idProfessor;
        }

        // Método setter para idProfessor
        public function setidProfessor($idProfessor)
        {
            $this->idProfessor = $idProfessor;

            return $this;
        }

        //Método getter para escolas_idEscola
        public function getescolas_idEscola()
        {
            return $this->escolas_idEscola;
        }

        //Método setter para escolas_idEscola
        public function setescolas_idEscola($escolas_idEscola)
        {
            $this->escolas_idEscola = $escolas_idEscola;

            return $this;
        }

        //Método getter para telefone
        public function gettelefone()
        {
            return $this->telefone;
        }

        //Método setter para telefone
        public function settelefone($telefone)
        {
            $this->telefone = $telefone;

            return $this;
        }

        //Método getter para cpf
        public function getcpf()
        {
            return $this->cpf;
        }

        //Método setter para cpf
        public function setcpf($cpf)
        {
            $this->cpf = $cpf;

            return $this;
        }

         //Método getter para especialidade
         public function getespecialidade()
         {
            return $this->especialidade;
         }
 
         //Método setter para especialidade
         public function setespecialidade($especialidade)
         {
             $this->especialidade = $especialidade;
 
             return $this;
         }
        

        // Método getter para IdProfessor
        public function getnomeProfessor()
        {
            return $this->nomeProfessor;
        }

        // Método setter para IdProfessor
        public function setnomeProfessor($nomeProfessor)
        {
            $this->nomeProfessor = $nomeProfessor;

            return $this;
        }
    }

?>
