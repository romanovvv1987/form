<?php

/**
 * Class PDOClass
 */
class PDOClass
{
    private static $_instance = null;
    private $_db;

    public function __construct()
    {
        try {
            $this->dbhost = new \PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USERNAME, PASSWORD,[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new PdoClass();
        }

        return self::$_instance;
    }

    public function query($query)
    {
        $this->_db = $this->dbhost->prepare($query);
    }

   public function bind($param, $value, $type = null)
    {
        $this->_db->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->_db->execute();
    }

    public function single()
    {
        $this->execute();
        return $this->_db->fetch(\PDO::FETCH_ASSOC);
    }
}


