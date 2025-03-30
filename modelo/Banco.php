<?php
    // Definição da classe Banco
    class Banco{
        // Propriedades estáticas para armazenar informações de conexão com o banco de dados
        private static $HOST='127.0.0.1';
        private static $USER= 'root';
        private static $PWD= '';
        private static $DB= 'projeto';
        private static $PORT= 3306;
        private static $CONEXAO= null;

        // Método privado para estabelecer uma conexão com o banco de dados
        private static function conectar(){
            // Configura o relatório de erros para ocultar mensagens de erro devido a conexões mal-sucedidas
            error_reporting(E_ERROR | E_PARSE);
            // Verifica se já existe uma conexão estabelecida
            if(Banco::$CONEXAO==null){
                // Tenta estabelecer uma nova conexão utilizando as informações fornecidas
                Banco::$CONEXAO = new mysqli(Banco::$HOST,Banco::$USER,Banco::$PWD,Banco::$DB,Banco::$PORT);
                // Verifica se ocorreu algum erro na conexão
                if(Banco::$CONEXAO->connect_error) {
                    // Cria um objeto stdClass para armazenar informações sobre o erro
                    $objResposta = new stdClass();
                    $objResposta->cod = 1; 
                    $objResposta->msg = "Erro ao conectar no banco"; 
                    $objResposta->erro = Banco::$CONEXAO->connect_error;

                    // Encerra o script e retorna o objeto JSON com as informações do erro
                    die(json_encode($objResposta));
                }
            }
        }
        
        // Método público para obter a conexão com o banco de dados
        public static function getConexao(){
            // Verifica se já existe uma conexão estabelecida
            if(Banco::$CONEXAO==null){
                // Se não houver, estabelece uma nova conexão
                Banco::conectar();
            }
            // Retorna a conexão
            return Banco::$CONEXAO;
        }
    }
?> 
