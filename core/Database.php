<?php


class Database 
{
    private $_servername;
    private $_username;
    private $_password;
    private $_dns;
    protected $_pdo;

    public function __construct()
    {
        global $DB_PASSWORD, $DB_USER_NAME, $SERVER_NAME, $DB_DNS;
        $this->_servername = $SERVER_NAME;
        $this->_username =  $DB_USER_NAME;
        $this->_password = $DB_PASSWORD;
        $this->_dns = $DB_DNS;
        $this->_pdo = null;
    }

    private function _getPDO()
    {
        if ($this->_pdo === null)
        {
            try {
                $pdo = new PDO("$this->_dns", "$this->_username", "$this->_password");
            } 
            catch (\Throwable $error) {
                return null;
            }
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo = $pdo;
        }
        return $this->_pdo;
    }

    public function execute($query, $data = [])
    {
        if (!($PDO = $this->_getPDO()))
            return false;
        try {
            $statement = $PDO->prepare($query);
        }
        catch (\Throwable $error){
            return (false);
        }
        $ret = $statement->execute($data);
        return $ret;
    }

    public function select($query, $data = [])
    {
        if (!($PDO = $this->_getPDO()))
            return null;
        try {
          $statement = $PDO->prepare($query);
        }
        catch (\Throwable $error){
            return (null);
        }
        if (!($statement->execute($data)))
            return null;
        if (!($select = $statement->fetch(PDO::FETCH_ASSOC)))
            return null;
        return $select;
    }

    public function selectAll($query, $data = [])
    {
        if (!($PDO = $this->_getPDO()))
            return null;
        try {
            $statement = $PDO->prepare($query);
        }
        catch (\Throwable $error){
            return (null);
        }
        if (!($statement->execute($data)))
            return null;
        if (!($select = $statement->fetchAll(PDO::FETCH_ASSOC)))
           return null;
        return $select;
    }

    public function close()
    {
        $this->_pdo = NULL;
    }
}
?>