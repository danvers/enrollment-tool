<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 28.11.2015
 * Time: 21:44
 *
 * @author Dan Verständig - dan@pixelspace.org
 */

namespace Controllers\admin;

use Core\Language;
use Core\View;
use Helpers\Url;
use Models\admin\Auth;
use Models\Enrollment;


class Admin extends \Core\Controller
{

    private $enrollments, $auth;

    public function __construct()
    {
        $this->auth = new Auth();
        if (!$this->auth->logged_in()) {
            Url::redirect('admin/login');
        }
        $this->enrollments = new Enrollment();
    }

    public function index()
    {

        $data['title'] = Language::show('title_overview', 'admin/Admin');
        $data['list_info'] = $this->enrollments->getLists(false, true);

        View::renderTemplate('header', $data);
        View::render('admin/admin', $data);
        View::renderTemplate('footer', $data);
    }

    public function settings()
    {
        $data['settings']['home_message'] = Language::show('home_message', 'Home');

        if (isset($_POST['submit'])) {

            $file = SMVC . 'app/language/' . LANGUAGE_CODE . '/Home.php';

            file_put_contents($file, implode('',
                array_map(function ($data) {
                    /**
                     * some custom input validation due to critical file writing procedure
                     * lazy but working :)
                     */
                    $message = preg_replace("/\r|\n/", "", $_POST['home_text']);
                    $message = preg_replace("/'/", "\"", $message);
                    if (!strlen($message)) {
                        $message = ' ';
                    }
                    return stristr($data, 'home_message') ? "\t" . "'home_message' => '" . $message . "',\n" : $data;
                }, file($file))
            ));
            $data['settings']['home_message'] = Language::show('home_message', 'Home');
        }

        $data['title'] = Language::show('title_settings', 'admin/Admin');
        $data['list_info'] = $this->enrollments->getLists(false, true);

        View::renderTemplate('header', $data);
        View::render('admin/settings', $data);
        View::renderTemplate('footer', $data);
    }
}