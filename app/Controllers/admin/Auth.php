<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 28.11.2015
 * Time: 21:45
 *
 * @author Dan Verständig - dan@pixelspace.org
 */

namespace Controllers\admin;


use Core\Language;
use Core\View;
use Helpers\Password;
use Helpers\Session;
use Helpers\Url;

class Auth extends \Core\Controller
{
    public function login()
    {
        if (Session::get('loggedin')) {
            Url::redirect('admin');
        }

        $model = new \Models\admin\Auth();
        $data['title'] = Language::show('title_login', 'admin/Admin');
        $data['button_login'] = Language::show('button_login', 'admin/Admin');
        if (isset($_POST['submit'])) {

            $password = $_POST['password'];
            if (Password::verify($password, $model->getHash($_POST['username'])) == 0) {
                $error[] = Language::show('login_error', 'admin/Admin');
            } else {
                $id = $model->getID($_POST['username']);
                $user_agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';

                Session::set('user', $id);
                Session::set('loggedin', true);
                Session::set('ip_address', $model->get_ip_address());
                Session::set('user_agent', $user_agent);
                Url::redirect('admin');
            }
        }

        View::renderTemplate('loginheader', $data, 'admin');
        View::render('admin/login', $data, $error);
        View::renderTemplate('loginfooter', $data, 'admin');
    }

    public function logout()
    {
        Session::destroy();
        Url::redirect('');
    }
}