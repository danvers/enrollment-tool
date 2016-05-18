<?php
/**
 * Created by PhpStorm.
 * User: dan
 * @author Dan Verständig - dan@pixelspace.org
 * Date: 29.11.2015
 * Time: 16:47
 */

namespace Models\admin;

class Entries extends \Core\Model
{

    public function get($id)
    {
        return $this->db->select("SELECT e.* FROM " . PREFIX . "entries e
                                    LEFT JOIN " . PREFIX . "entries_to_courses etc ON e.id = etc.entry_id
                                    WHERE etc.course_id = :list_id
                                    GROUP by e.id ORDER BY e.id ASC", array(':list_id' => $id));

    }

    public function insert($data)
    {
        $this->db->insert(PREFIX . "entries", $data);
    }

    public function update($data, $where)
    {
        $this->db->update(PREFIX . "entries", $data, $where);
    }

    public function delete($where)
    {

        // unlink entry and course
        $this->db->delete(PREFIX . "entries_to_courses", $where);

        $check = $this->db->select("SELECT entry_id FROM " . PREFIX . "entries_to_courses WHERE entry_id =:id ",
            array(':id' => $where['entry_id'])
        );
        if (!is_object($check[0])) {
            // no enrollments left associated with the registrant, so delete entry data
            $this->db->delete(PREFIX . "entries", array('id' => $where['entry_id']));
        }
    }
}