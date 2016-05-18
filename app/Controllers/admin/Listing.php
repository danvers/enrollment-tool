<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 29.11.2015
 * Time: 15:19
 *
 * @author Dan Verständig - dan@pixelspace.org
 */

namespace controllers\admin;

use Core\Language;
use Core\View;
use Helpers\ExportDataExcel;
use Helpers\Gump;
use Helpers\Session;
use Helpers\Url;
use Models\admin\Auth;

class Listing extends \Core\Controller
{
    protected $study_data;
    private $model, $entries, $gump, $auth;

    public function __construct()
    {

        parent::__construct();
        $this->language->load('admin/Listing');

        $this->auth = new Auth();
        if (!$this->auth->logged_in()) {
            Url::redirect('admin/login');
        }
        $this->model = new \Models\admin\Listing();
        $this->entries = new \Models\admin\Entries();

        $this->study_data = Language::show('study_data', 'Enroll');
    }

    public function add()
    {

        $data['title'] = $this->language->get('add_course');
        $data['study_data'] = $this->study_data;

        if (isset($_POST['submit'])) {

            $description = $_POST['description'];

            $this->gump = new GUMP();
            $_POST = $this->gump->sanitize($_POST);
            $this->gump->validation_rules(array(
                'name' => 'required|min_len,3',
                'dozent' => 'required|min_len,3',
                'dozent_url' => 'valid_url',
                'max_limit' => 'numeric',
                'start_date' => 'date',
                'end_date' => 'date'
            ));

            $this->gump->filter_rules(array(
                'name' => 'trim|sanitize_string',
                'dozent' => 'trim|sanitize_string',
                'dozent_url' => 'trim|sanitize_string',
                'description' => 'sanitize_string'
            ));
            if (isset($_POST['start_date']) && strlen($_POST['start_date'])) {
                $_POST['start_date'] = date('Y-m-d H:i:00', strtotime($_POST['start_date']));
            } else {
                $_POST['start_date'] = NULL;
            }

            if (isset($_POST['end_date']) && strlen($_POST['end_date'])) {
                $_POST['end_date'] = date('Y-m-d H:i:00', strtotime($_POST['end_date']));
            } else {
                $_POST['end_date'] = NULL;
            }
            $validated_data = $this->gump->run($_POST);

            if ($validated_data === false) {
                $data['form_errors'] = $this->gump->errors();
                $data['error'] = $this->gump->get_readable_errors();
            } else {
                $postdata = array(
                    'name' => $_POST['name'],
                    'dozent' => $_POST['dozent'],
                    'dozent_url' => $_POST['dozent_url'],
                    'max_limit' => intval($_POST['max_limit']) ? $_POST['max_limit'] : 0,
                    'slug' => Url::generateSafeSlug($_POST['name']),
                    'visible' => isset($_POST['visible']) ? 1 : 0,
                    'public' => isset($_POST['public']) ? 1 : 0,
                    'study' => isset($_POST['study']) ? implode('|', $_POST['study']) : '',
                    'description' => $description
                );
                if (isset($_POST['start_date']))
                    $postdata['start_date'] = $_POST['start_date'];
                if (isset($_POST['start_date']))
                    $postdata['end_date'] = $_POST['end_date'];

                if (sizeof($this->model->check($postdata)) > 0) {
                    $data['form_errors'][] = array('field' => 'name');
                    $data['error'][] = Language::show('course_duplicate', 'Listing');
                } else {
                    $this->model->insert($postdata);
                    Session::set('message', sprintf($this->language->get('course_add_success'), $_POST['name']));
                    Url::redirect('admin/');
                }
            }
        }
        View::renderTemplate('header', $data);
        View::render('admin/list/addlist', $data);
        View::renderTemplate('footer', $data);
    }

    public function edit($id)
    {


        $list = $this->model->get($id);

        if (isset($_POST['submit'])) {


            $this->gump = new GUMP();

            $description = $_POST['description'];

            $_POST = $this->gump->sanitize($_POST);

            $this->gump->validation_rules(array(
                'name' => 'required|min_len,3',
                'dozent' => 'required|min_len,3',
                'dozent_url' => 'valid_url',
                'max_limit' => 'numeric',
                'start_date' => 'date',
                'end_date' => 'date'
            ));

            $this->gump->filter_rules(array(
                'name' => 'trim|sanitize_string',
                'dozent' => 'trim|sanitize_string',
                'dozent_url' => 'trim|sanitize_string',
                'description' => 'sanitize_string'
            ));

            if (isset($_POST['start_date']) && strlen($_POST['start_date'])) {
                $_POST['start_date'] = date('Y-m-d H:i:00', strtotime($_POST['start_date']));
            } else {
                $_POST['start_date'] = NULL;
            }

            if (isset($_POST['end_date']) && strlen($_POST['end_date'])) {
                $_POST['end_date'] = date('Y-m-d H:i:00', strtotime($_POST['end_date']));
            } else {
                $_POST['end_date'] = NULL;
            }

            $validated_data = $this->gump->run($_POST);

            if ($validated_data === false) {
                $data['form_errors'] = $this->gump->errors();
                $data['error'] = $this->gump->get_readable_errors();
            } else {
                $postdata = array(
                    'id' => $id,
                    'name' => $_POST['name'],
                    'start_date' => $_POST['start_date'],
                    'end_date' => $_POST['end_date'],
                    'dozent' => $_POST['dozent'],
                    'dozent_url' => $_POST['dozent_url'],
                    'max_limit' => intval($_POST['max_limit']) ? $_POST['max_limit'] : 0,
                    'slug' => Url::generateSafeSlug($_POST['name']),
                    'visible' => isset($_POST['visible']) ? 1 : 0,
                    'public' => isset($_POST['public']) ? 1 : 0,
                    'study' => isset($_POST['study']) ? implode('|', $_POST['study']) : '',
                    'description' => $description
                );

                if (sizeof($this->model->check($postdata)) > 0) {
                    $data['form_errors'][] = array('field' => 'name');
                    $data['error'][] = $this->language->show('course_duplicate');
                } else {
                    $where = array('id' => $id);
                    $this->model->update($postdata, $where);
                    Session::set('message', sprintf($this->language->get('course_update_success'), $_POST['name']));
                    Url::redirect('admin/');
                }
            }
        }

        $data['title'] = sprintf($this->language->get('edit_x_course'), $list[0]->name);
        $data['list'] = $list;

        $data['study_data'] = $this->study_data;

        View::renderTemplate('header', $data);
        View::render('admin/list/editlist', $data);
        View::renderTemplate('footer', $data);

    }

    public function delete($id)
    {


        $data['row'] = $this->model->get($id);
        $data['title'] = sprintf($this->language->get('del_x_course'), $data['row'][0]->name);

        if (isset($_POST['submit'])) {
            $this->model->delete(array('id' => $id));
            Session::set('message', $this->language->get('course_deleted'));
            Url::redirect('admin/');
        }
        View::renderTemplate('header', $data);
        View::render('admin/list/deletelist', $data);
        View::renderTemplate('footer', $data);
    }

    public function toggle($id)
    {
        $this->model->toggle($id);
        Url::redirect('admin/list');
    }

    public function entries($id)
    {
        $data['title'] = $this->language->get('edit_entries');
        $course = $this->model->get($id);
        $data['course'] = $course[0];
        $data['entries'] = $this->entries->get($id);
        $data['id'] = $id;

        $data['study_data'] = $this->study_data;

        View::renderTemplate('header', $data);
        View::render('admin/list/entries', $data);
        View::renderTemplate('footer', $data);
    }

    public function ajax()
    {
        $request = new \Helpers\Request();

        if (!Session::get('loggedin') || !$request->isAjax()) {
            Url::redirect();
        }
        $where = array('id' => $_GET['id']);
        $data = array($_GET['name'] => $_GET['data']);
        $this->entries->update($data, $where);
    }

    public function deleteEntry($id, $ref_id)
    {
        if (!Session::get('loggedin')) {
            return false;
        }
        $this->entries->delete(array('entry_id' => $ref_id, 'course_id' => $id));
        Session::set('message', 'Eintrag gelöscht');
        Url::redirect('admin/list/entries/' . $id);
    }

    public function export($id)
    {

        $data = $this->model->get($id);
        $filename = $data[0]->slug . '.xls';
        $exporter = new ExportDataExcel('browser', $filename);
        $exporter->initialize();
        $entries = $this->entries->get($id);
        $exporter->addRow(array($data[0]->name));

        $myID = 1;
        $exporter->addRow(array(
            'ID',
            'Nachname',
            'Vorname',
            'E-Mail',
            'Matrikel',
            'Studiengang',
            'Semester',
            'Anmeldezeit'
        ));
        foreach ($entries as $row) {
            $exporter->addRow(array(
                $myID++,
                $row->lastname,
                $row->firstname,
                $row->email,
                $row->matrikel,
                $this->study_data[$row->study],
                $row->semester,
                $row->created
            ));
        }
        $exporter->finalize();
        exit();
    }
}