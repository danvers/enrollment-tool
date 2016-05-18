<?php
/**
 * Created by PhpStorm.
 * User: dan
 * @author Dan Verständig - dan@pixelspace.org
 * Date: 05.12.2015
 * Time: 00:09
 */

namespace models;

class Enrollment extends \Core\Model
{

    public function getLists($showAll = false, $order = false)
    {
        $show = null;

        if ($showAll) {
            /*
             * Mysql Server = UTC
             * Application timezone = Europe/Berlin +01:00
             */
            //$show = 'WHERE visible = 1';
            $show = 'WHERE visible = 1 AND (start_date IS NULL OR start_date <= NOW() + INTERVAL 1 HOUR AND (end_date IS NULL OR end_date >= NOW() + INTERVAL 1 HOUR ) )';
        }
        return $this->db->select("SELECT course.*, COUNT(etc.entry_id) as entries FROM " . PREFIX . "lists course
                                    LEFT JOIN " . PREFIX . "entries_to_courses etc ON (course.id = etc.course_id)
                                    " . $show . " GROUP BY id ORDER BY slug ASC");
    }

    public function getEntries($id)
    {
        return $this->db->select("SELECT * FROM " . PREFIX . "entries e LEFT JOIN " . PREFIX . "entries_to_courses etc ON e.id = etc.entry_id WHERE etc.course_id = :id GROUP by e.id ORDER BY e.lastname, e.firstname ASC", array(':id' => $id));
    }

    public function getId($title)
    {
        $data = $this->db->select("SELECT *, UNIX_TIMESTAMP(start_date) sd, UNIX_TIMESTAMP(end_date) ed FROM " . PREFIX . "lists WHERE slug LIKE :title LIMIT 1", array(':title' => $title));

        if (is_object($data[0])) {
            return $data[0];
        }
        return false;
    }

    public function insert($data)
    {
        $check = $this->db->select("SELECT id FROM " . PREFIX . "entries
                                    WHERE matrikel = :matrikel
                                    AND email = :email
                                    AND lastname = :lastname
                                    AND firstname = :firstname
                                    AND study = :study
                                    LIMIT 1",
            array(
                ':email' => $data['email'],
                ':firstname' => $data['firstname'],
                ':lastname' => $data['lastname'],
                ':matrikel' => $data['matrikel'],
                ':study' => $data['study']
            )
        );
        $list_id = $data['list_id'];
        unset($data['list_id']);

        if (!is_object($check[0])) {

            $id = $this->db->insert(PREFIX . "entries", $data);
            $mapping = array(
                'entry_id' => $id,
                'course_id' => $list_id
            );

            $this->db->insert(PREFIX . "entries_to_courses", $mapping);
            return true;
        } else {
            $check_mapping = $this->db->select("SELECT entry_id FROM " . PREFIX . "entries_to_courses WHERE entry_id = :entry_id AND course_id = :course_id LIMIT 1",
                array(
                    ':entry_id' => $check[0]->id,
                    ':course_id' => $list_id
                )
            );
            if (is_object($check_mapping[0])) {
                return false;
            } else {
                $mapping = array(
                    'entry_id' => $check[0]->id,
                    'course_id' => $list_id
                );
                $this->db->insert(PREFIX . "entries_to_courses", $mapping);

            }
            return true;
        }
        return false;
    }

    public function update($data, $where)
    {
        $this->db->update(PREFIX . "entries", $data, $where);
    }
}