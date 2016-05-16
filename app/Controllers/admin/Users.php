<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 28.11.2015
 * Time: 23:12
 */

namespace controllers\admin;

use Core\View;
use Helpers\Gump;
use Helpers\Session;
use Helpers\Url;

class Users extends \Core\Controller
{
    private $model, $gump;

    public function __construct()
    {
        if (!Session::get('loggedin')) {
            Url::redirect('admin/login');
        }
        parent::__construct();

        $this->language->load('admin/Users');
        $this->gump = new GUMP();
        $this->model = new \Models\admin\Users();
    }

    public function index()
    {
        $data['title'] = $this->language->get('title_overview');
        $data['users'] = $this->model->get();

        View::renderTemplate('header', $data);
        View::render('admin/user', $data);
        View::renderTemplate('footer', $data);
    }

    public function add()
    {
        $data['title'] = $this->language->get('button_add');

        if (isset($_POST['submit'])) {

            $_POST = $this->gump->sanitize($_POST);

            $this->gump->validation_rules(array(
                'username' => 'required|alpha_numeric|min_len,3',
                'password' => 'required|alpha_numeric|min_len,3',
                'email' => 'required|valid_email'
            ));

            $this->gump->filter_rules(array(
                'username' => 'trim|sanitize_string',
                'password' => 'trim',
                'email' => 'trim|sanitize_email'
            ));
            $validated_data = $this->gump->run($_POST);

            if ($validated_data === false) {
                $data['form_errors'] = $this->gump->errors();
                $data['error'] = $this->gump->get_readable_errors();
            } else {

                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];

                $postdata = array(
                    'username' => $username,
                    'password' => \Helpers\Password::make($password),
                    'email' => $email,
                    'addedDate' => date('Y-m-d H:i:s', time())
                );
                $this->model->insert($postdata);

                Session::set('message', $this->language->get('user_add_success'));
                Url::redirect('admin/user');

            }

        }
        View::renderTemplate('header', $data);
        View::render('admin/user/adduser', $data);
        View::renderTemplate('footer', $data);

    }

    public function edit($id)
    {
        $data['title'] = $this->language->get('title_edit');
        $data['row'] = $this->model->get($id);

        if (isset($_POST['submit'])) {

            $_POST = $this->gump->sanitize($_POST);

            $this->gump->validation_rules(array(
                'username' => 'required|alpha_numeric|min_len,3',
                'password' => 'required|min_len,8',
                'email' => 'required|valid_email'
            ));

            $this->gump->filter_rules(array(
                'username' => 'trim|sanitize_string',
                'password' => 'trim',
                'email' => 'trim|sanitize_email'
            ));
            $validated_data = $this->gump->run($_POST);

            if ($validated_data === false) {
                $data['form_errors'] = $this->gump->errors();
                $data['error'] = $this->gump->get_readable_errors();
            } else {

                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];

                $postdata = array(
                    'username' => $username,
                    'password' => \Helpers\Password::make($password),
                    'email' => $email
                );
                $where = array('memberID' => $id);
                $this->model->update($postdata, $where);

                Session::set('message', $this->language->get('user_edit_success'));
                Url::redirect('admin/user');

            }

        }
        View::renderTemplate('header', $data);
        View::render('admin/user/edituser', $data);
        View::renderTemplate('footer', $data);
    }

    public function delete($id)
    {
        $data['title'] = $this->language->get('title_delete');
        $data['row'] = $this->model->get($id);
        if (\Helpers\Session::get('user') == $id) {
            Url::redirect('admin/user');
        }
        if (isset($_POST['submit'])) {
            $this->model->delete(array('memberID' => $id));
            Session::set('message', $this->language->get('user_delete_success'));
            Url::redirect('admin/user');
        }
        View::renderTemplate('header', $data);
        View::render('admin/user/deleteuser', $data);
        View::renderTemplate('footer', $data);
    }
}