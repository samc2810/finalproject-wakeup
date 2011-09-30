<?php
namespace WakeUp\Db;

/**
 * Description of Explorer
 *
 * @author sarora
 */
class Glpi {
//put your code here

/**
 *
 * @var Db_Connector
 */
    private $connector = null;
    private $DB = 'glpi';

    public function __construct() {

        $this->connector = new Db_Connector('database', 'wakeonlan', 'wol');
        mysql_select_db($this->DB, $this->connector->getConnection());
    }

    public function getMainComputer($username) {
        $query = "select c.name from glpi_users as u
	inner join glpi_computers as c on u.ID=c.FK_users AND u.name='$username' AND c.deleted=0";

        return $this->connector->executeQuery($query);
    }

    public function getMacAdresses($compname) {
        $query = 'SELECT ifmac FROM glpi_networking_ports
                    WHERE on_device =
                        (SELECT id FROM glpi_computers WHERE
                             name = \''.$compname.'\' and deleted = 0 LIMIT 1)
                     AND ifmac != "" AND iface=1';

        return $this->connector->executeQuery($query);

    }

    public function getComputersFromVlanOverComputer($mainComp) {
        $query = "SELECT gc.name FROM glpi_computers AS gc WHERE gc.ID IN
                    (SELECT gnp.on_device FROM glpi_networking_vlan AS gnv
                            INNER JOIN glpi_networking_ports AS gnp ON gnp.ID=gnv.FK_port
                                    AND FK_vlan =
                                        (SELECT  nv.FK_vlan FROM glpi_computers AS c
                                            INNER JOIN glpi_networking_ports AS np ON c.ID=np.ON_device
                                                AND c.deleted = 0 AND c.name='$mainComp'
                                                    AND np.iface=1
                                            INNER JOIN glpi_networking_vlan AS nv ON nv.FK_port=np.ID
                                         LIMIT 1)
                      GROUP BY gnp.on_device)
                AND gc.deleted=0 ORDER BY gc.name";

        return $this->connector->executeQuery($query);
    }

    public function getBroadCast($mainComp) {
        $query = "select comments from glpi_dropdown_vlan
                    where id=
                        (SELECT  nv.FK_vlan FROM glpi_computers AS c
                            INNER JOIN glpi_networking_ports AS np ON c.ID=np.ON_device
                                AND c.deleted = 0 AND c.name='$mainComp'
                                    AND np.iface=1
                            INNER JOIN glpi_networking_vlan AS nv ON nv.FK_port=np.ID
                         LIMIT 1)";

        $arr = $this->connector->executeQuery($query);
        if(!empty($arr)) {
            $comms = ($arr[0]['comments']);
            if($comms!=''){
                $pattern = "|\(.*\)|";
                $arrx = array();
                $str = trim(preg_replace($pattern, '', $comms));

                $pattern2 = "|(\\d+\\.\\d+\\.\\d+\\.)(\\d+)|";
                preg_match_all($pattern2, $str, $arrx);
//                var_dump($str);
//                var_dump($arrx);
                $str = $arrx[1][0].'255';
                return($str);

            }
        }
        return null;
    }

    public function getVlans(){
        $query = "SELECT * FROM glpi_dropdown_vlan WHERE comments LIKE '%255.255.255.0%'";
        return $this->connector->executeQuery($query);
    }

    public function getComputersFromVlan($vlanid){
        $query = "SELECT gc.name FROM glpi_computers AS gc WHERE gc.ID IN
                    (SELECT gnp.on_device FROM glpi_networking_vlan AS gnv
                            INNER JOIN glpi_networking_ports AS gnp ON gnp.ID=gnv.FK_port
                                    AND FK_vlan = $vlanid AND iface=1
                      GROUP BY gnp.on_device)
                AND gc.deleted=0 ORDER BY gc.name";

        return $this->connector->executeQuery($query);
    }

//    public function
}