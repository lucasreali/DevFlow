<?php

namespace Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $connection = null;

    private function __construct() {
    }

    /**
     * Este método fornece uma instância singleton da conexão PDO.
     * 
     * - Se a propriedade `$connection` for `null`, ele inicializa a conexão.
     * - Recupera as credenciais do banco de dados das variáveis de ambiente (`$_ENV`).
     * - Constrói uma string DSN (Data Source Name) para um banco de dados MySQL.
     * - Cria uma nova instância de PDO com o DSN e as credenciais.
     * - Define o modo de erro do PDO para lançar exceções, facilitando o tratamento de erros.
     * - Se a conexão falhar, captura a `PDOException` e encerra o script com uma mensagem de erro.
     * 
     * Uma vez que a conexão é estabelecida, ela é reutilizada para chamadas subsequentes, evitando múltiplas conexões.
     * 
     * @return PDO A instância singleton da conexão PDO.
     */
    public static function getInstance(): PDO {
        if (self::$connection === null) {
            try {
                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $username = $_ENV['DB_USER'];
                $password = $_ENV['DB_PASS'];

                $dsn = "mysql:host=$host;dbname=$dbname";
                self::$connection = new PDO($dsn, $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Failed to connect: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
