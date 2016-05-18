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
}