<?php
/**
 * Created by PhpStorm.
 * User: dan
 * @author Dan Verständig - dan@pixelspace.org
 * Date: 28.11.2015
 * Time: 21:46
 */

namespace Models\admin;

use Helpers\Session;

class Auth extends \Core\Model
{
    public function getHash($username)
    {
        $data = $this->db->select("SELECT password FROM " . PREFIX . "members WHERE username = :username", array(':username' => $username));
        return $data[0]->password;
    }

    public function getID($username)
    {
        $data = $this->db->select("SELECT memberID FROM " . PREFIX . "members WHERE username = :username", array(':username' => $username));
        return $data[0]->memberID;
    }

    public function logged_in()
    {
        if ((!Session::get('loggedin') || Session::get('loggedin') == false) ||
            (Session::get('ip_address') !== $this->get_ip_address()) ||
            (!isset($_SERVER['HTTP_USER_AGENT']) || Session::get('user_agent') !== $_SERVER['HTTP_USER_AGENT'])
        ) {
            Session::destroy();
            return false;
        }
        return true;
    }

    public function get_ip_address()
    {
        $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ($this->validate_ip($ip)) {
                        return $ip;
                    }
                }
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }

    private function validate_ip($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }
}