<?php
/**
 * Created by PhpStorm.
 * User: dan
 * @author Dan Verständig - dan@pixelspace.org
 * Date: 28.11.2015
 * Time: 23:14
 */

namespace Models\admin;

class Users extends \Core\Model
{

    public function get($id = 0)
    {
        if ($id == 0) {
            return $this->db->select("SELECT * FROM " . PREFIX . "members ORDER BY username");
        } else {
            return $this->db->select("SELECT * FROM " . PREFIX . "members WHERE memberID = :id", array(':id' => $id));
        }
    }

    public function insert($data)
    {
        $this->db->insert(PREFIX . "members", $data);
    }

    public function update($data, $where)
    {
        $this->db->update(PREFIX . "members", $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete(PREFIX . "members", $where);
    }
}