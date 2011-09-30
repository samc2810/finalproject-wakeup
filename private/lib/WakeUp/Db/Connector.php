<?php
namespace WakeUp\Db;

/**
 * Description of Connector
 *
 * @author sarora
 */
class Connector {
//put your code here

    private $connection=null;

    public function __construct($host, $dbuser, $pass) {
        $this->connection = mysql_connect($host, $dbuser, $pass);
    }

    public function getConnection() {
        return $this->connection;
    }

    /**
     * Zum Ausführen von SQL-Statements, die einen ResultSet zurückgeben<br/>
     * z.B. SELECT, SHOW, DESCRIBE, EXPLAIN
     * @param string $query
     * @return array oder null
     */
    public function executeQuery($query) {
        $result = mysql_query($query,$this->connection);

        if(!$result)
            return null;

        $assocRows = array();

        while($row = mysql_fetch_assoc($result)) {
            $assocRows[] = $row;
        }

        return $assocRows;
    }

    /**
     * zum Ausführen von SQL-Statements, die keinen ResultSet zurückgeben<br/>
     * z.B. DELETE, INSERT, REPLACE, or UPDATE
     * @param string $query
     * @return int Anzahl der veränderten Datensätze oder -1 wenn der Befehl fehlschlug
     */
    public function changeQuery($query){
        $result = mysql_query($query,$this->connection);

        if(!$result)
            return null;

        return mysql_affected_rows($this->connection);
    }

}