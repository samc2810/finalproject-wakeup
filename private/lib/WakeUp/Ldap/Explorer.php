<?php

namespace WakeUp\Ldap;

/**
 * Description of Explorer
 *
 * @author sarora
 */
class Explorer {
//put your code here
    private $connection;
    private $user = "ldapview@isa-hamburg.lan";
    private $pass = "isa99#";

    public function __construct() {
        $this->connection = ldap_connect("dc-0.isa-hamburg.lan");
        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
    }

    public function bind($username, $password) {
        $success = false;

        if($pass !== '') {
            if(@ldap_bind($this->connection, $username.'@isa-hamburg.lan', $password))
                $success = true;
        }

        return $success;
    }

    public function searchEntries($filter, $base_dn="ou=isa,dc=isa-hamburg,dc=lan", $attributes=null) {

        if($this->connection) {
            if(ldap_bind($this->connection, $this->user, $this->pass)) {
                $search = ldap_search($this->connection, $base_dn, $filter);#, $attributes);
                $data = ldap_get_entries($this->connection, $search);
                return $data;
            }else return false;
        }else return false;
    }
}
?>
