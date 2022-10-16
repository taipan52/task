<?php

namespace Task\Api;

/**
 * DB class 
 * подключение и работа с БД
 * 
 */
class DB {

    private $host =   DB_HOST;
    private $user =   DB_USER;
    private $pass =   DB_PASS;
    private $dbname = DB_NAME;

    private $conn;

    public $last_error;

    function __construct() {

        try {

            $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
            $this->conn = new \PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {

            $this->last_error = $e->getMessage();
        }
        
    }

    public function getInstance() {
        return $this->conn;
    }

    public function makeQuery($query) {

        $res = [];

        if($this->conn && !$this->last_error) {
            
            try {

                $stmt = $this->conn->prepare($query);
                $stmt->execute();

                $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            } catch (\PDOException $e) {

                $this->last_error = $e->getMessage();
            }
        }

        return $res;

    }


}