<?php
/**
 * Created by PhpStorm.
 * User: dan
 * @author Dan Verständig - dan@pixelspace.org
 * Date: 29.11.2015
 * Time: 16:47
 */

namespace Models\admin;

class Listing extends \Core\Model
{

    public function get($id = 0)
    {
        if ($id == 0) {
            return $this->db->select("SELECT a.*, COUNT(etc.entry_id) as entries FROM " . PREFIX . "lists a
                                      LEFT JOIN " . PREFIX . "entries_to_courses etc ON a.id = etc.course_id
                                      GROUP by a.id
                                      ORDER BY a.id ASC");
        } else {
            return $this->db->select("SELECT a.*, COUNT(etc.entry_id) as entries FROM " . PREFIX . "lists a
                                      LEFT JOIN " . PREFIX . "entries_to_courses etc ON a.id = etc.course_id
                                      WHERE a.id = :id  GROUP BY a.id ORDER BY a.id ASC", array(':id' => $id));
        }
    }

    public function insert($data)
    {
        $this->db->insert(PREFIX . "lists", $data);
    }

    public function update($data, $where)
    {
        $this->db->update(PREFIX . "lists", $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete(PREFIX . "lists", $where);

        $where_entries = array('course_id' => $where['id']);
        $this->db->delete(PREFIX . "entries", $where_entries);
    }

    public function check($data)
    {
        return $this->db->select("SELECT id FROM " . PREFIX . "lists WHERE (slug LIKE :slug OR name LIKE :name) AND id NOT IN(:id)", array(':id' => $data['id'], ':slug' => $data['slug'], ':name' => $data['name']));
    }

    public function toggle($where)
    {
        return $this->db->raw('UPDATE ' . PREFIX . 'lists SET visible = IF(visible=1, 0, 1) WHERE id = ' . (int)$where . ' LIMIT 1');
    }
}