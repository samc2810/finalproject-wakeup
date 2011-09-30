<?php
namespace WakeUp\Db;
/**
 * Description of Wol
 *
 * @author sarora
 */
class Wol {
    //put your code here

    /**
     *
     * @var Db_Connector
     */
    private $connector = null;
    private $DB = 'db_wakeonlan';

    public function __construct() {

        $this->connector = new Db_Connector('localhost', 'wol', 'wol99#');
        mysql_select_db($this->DB, $this->connector->getConnection());
    }

    public function modify($command, $params, $id=null) {
        switch($command){
            case 'insert':
                $query = 'INSERT INTO assignments (user, execution_time, computer, modified_on) values ("'.
                            $params['user'].'", "'.$params['execution_time'].'", "'.$params['computer'].
                            '", now())';

                $this->connector->changeQuery($query);
                return mysql_insert_id($this->connector->getConnection());
                break;

            case 'update':
                $query = 'UPDATE assignments SET execution_time = "'.$params['execution_time']
                        .'", user = "'.$params['user'].'", computer = "'.$params['computer']
                        .'", modified_on = now() WHERE id = '.$id;
                return $this->connector->changeQuery($query);
                break;
        }
    }

    public function deleteWithId($id=null){
        $query = 'DELETE FROM assignments'.($id ? ' WHERE id = '.$id:'');
        return $this->connector->changeQuery($query);
    }

    public function select($wheres=null, $order=null, $limit=null) {

        $whereStatement = '';
        if($wheres) {
            $cols = array_keys($wheres);
            $count = count($cols);
            $whereStatement = ' WHERE ';
            foreach($cols as $ind=>$col) {
                $whereStatement .= $col." = '".$wheres[$col]."'";
                if($ind < ($count - 1))
                    $whereStatement .= ' AND ';
            }
        }
        $query = "SELECT * FROM assignments".$whereStatement
                    .($order?' ORDER BY '.$order:'')
                    .($limit?' LIMIT '.$limit:'');

        return $this->connector->executeQuery($query);
    }
}
