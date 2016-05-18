<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 27.11.2015
 * Time: 22:51
 *
 * @author Dan Verständig - dan@pixelspace.org
 */

namespace Controllers;

use Core\Controller;
use Core\Language;
use Core\View;
use Helpers\Gump;
use Helpers\Session;
use Helpers\Url;

class Enrollment extends Controller
{

    protected $study_data;
    private $enrollments, $url, $gump;

    public function __construct()
    {
        parent::__construct();
        $this->language->load('Home');
        $this->enrollments = new \Models\Enrollment();
        $this->url = new Url();
        $this->gump = new GUMP();
        $this->study_data = Language::show('study_data', 'Enroll');
    }

    public function index()
    {
        $data['title'] = $this->language->get('home_text');
        $data['home_message'] = $this->language->get('home_message');

        $data['list_info'] = $this->enrollments->getLists(true);

        View::renderTemplate('header', $data);
        View::render('home/home', $data);
        View::renderTemplate('footer', $data);
    }

    public function course($title)
    {
        $list = $this->enrollments->getId($title);

        if ((!empty($list->start_date) && $list->sd > (time() + date('Z'))) || (!empty($list->end_date) && $list->ed < (time() + date('Z')))) {

            $invalid_time = true;
        }
        if (empty($list)) {
            Url::redirect();
        } elseif (!Session::get('loggedin') && ($list->visible == 0 || $invalid_time)) {

            Session::set('e_message', sprintf($this->language->get('list_not_active'), $list->name));
            Url::redirect();

        }

        $data['title'] = $list->name;
        $data['list'] = $list;

        $data['entries'] = $this->enrollments->getEntries($list->id);

        View::renderTemplate('header', $data);
        View::render('home/course', $data);
        View::renderTemplate('footer', $data);
    }

    public function enroll($title)
    {


        $list = $this->enrollments->getId($title);

        $invalid_time = false;

        if ((!empty($list->start_date) && $list->sd > (time() + date('Z'))) || (!empty($list->end_date) && $list->ed < (time() + date('Z')))) {

            $invalid_time = true;
        }
        if (empty($list)) {
            Url::redirect();
        } elseif (!Session::get('loggedin') && ($list->visible == 0 || $invalid_time)) {
            Session::set('e_message', sprintf($this->language->get('list_not_active'), $list->name));
            Url::redirect();
        }
        $sum = $this->enrollments->getLists(true);
        $data['active_lists'] = (int)sizeof($sum);

        $data['study_data'] = $this->study_data;

        $data['title'] = $this->language->get('enroll_title') . ' ' . $list->name;
        $data['slug'] = $list->slug;
        $data['study'] = $list->study;

        if (isset($_POST['submit'])) {

            $_POST = $this->gump->sanitize($_POST);

            $this->gump->validation_rules(array(
                'firstname' => 'required|alpha_numeric',
                'lastname' => 'required|alpha_numeric',
                'email' => 'required|valid_email',
                'matrikel' => 'required|integer',
                'studiengang' => 'required|alpha_numeric',
                'semester' => 'required|numeric',
            ));

            $this->gump->filter_rules(array(
                'firstname' => 'trim|sanitize_string',
                'lastname' => 'trim',
                'email' => 'trim|sanitize_email',
                'matrikel' => 'trim',
                'studiengang' => 'trim'
            ));
            $validated_data = $this->gump->run($_POST);

            if ($validated_data === false) {
                $data['form_errors'] = $this->gump->errors();
                $data['error'] = $this->gump->get_readable_errors();
            } else {
                $insert = array(
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => $_POST['email'],
                    'matrikel' => $_POST['matrikel'],
                    'study' => $_POST['studiengang'],
                    'list_id' => $list->id,
                    'created' => date('Y-m-d H:i:s', time()),
                    'semester' => $_POST['semester']
                );
                if ($this->enrollments->insert($insert)) {

                    if (isset($_POST['store_data_session'])) {
                        $store_data = array(
                            'firstname' => $_POST['firstname'],
                            'lastname' => $_POST['lastname'],
                            'email' => $_POST['email'],
                            'matrikel' => $_POST['matrikel'],
                            'study' => $_POST['studiengang'],
                            'semester' => $_POST['semester']
                        );
                        Session::set('stored_data', $store_data);
                    } else {
                        Session::destroy('stored_data');
                    }

                    Session::set('message', Language::show('enroll_success', 'Messages'));
                    Url::redirect('course/');
                } else {
                    if (isset($_POST['store_data_session'])) {
                        $store_data = array(
                            'firstname' => $_POST['firstname'],
                            'lastname' => $_POST['lastname'],
                            'email' => $_POST['email'],
                            'matrikel' => $_POST['matrikel'],
                            'study' => $_POST['studiengang'],
                            'semester' => $_POST['semester']
                        );
                        Session::set('stored_data', $store_data);
                    } else {
                        Session::destroy('stored_data');
                    }
                    Session::set('message', Language::show('enroll_duplicate', 'Messages'));
                    Url::redirect($data['slug'] . '/enroll/');
                }
            }
        }
        View::renderTemplate('header', $data);
        View::render('home/enroll', $data);
        View::renderTemplate('footer', $data);
    }
}