<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 05.12.2015
 * Time: 00:09
 *
 * @author Dan Verständig - dan@pixelspace.org
 */

use Helpers\Assets;
use Helpers\Hooks;
use Helpers\Session;
use Helpers\Url;

$hooks = Hooks::get();
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    $hooks->run('meta');
    ?>

    <title><?php echo $data['title'] . ' - ' . SITETITLE; ?></title>

    <?php
    Assets::css(array(
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css',
        Url::templatePath() . 'css/style.css',
        Url::templatePath() . 'css/bootstrap-multiselect.css',
        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css'
    ));
    $hooks->run('css');

    Assets::js(array(
        '//code.jquery.com/jquery-2.1.1.min.js',
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js',
        '//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js',
        '//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js',
        Url::templatePath() . 'js/bootstrap-multiselect.js'
    ));
    $hooks->run('js');
    ?>
</head>
<body>
<?php
$hooks->run('afterBody');
$listclass = '';
$userclass = '';
$homeclass = '';
$setclass = '';
if (isset($_GET) && sizeof($_GET) > 0) {
    foreach ($_GET as $v => $k) {
        if (strpos($v, 'admin/user') === 0) {
            $userclass = 'class="active"';
            $listclass = '';
        } elseif (strpos($v, 'admin/settings') === 0) {
            $setclass = 'class="active"';
            $listclass = '';
        } elseif (strpos($v, 'admin/list') === 0 || isset($_GET['admin'])) {
            $userclass = '';
            $listclass = 'class="active"';
        } elseif (strpos($v, 'admin') === false) {
            $homeclass = 'class="active"';
        }

    }
} else {
    $homeclass = 'class="active"';
}
?>
<div class="container wrapper">
    <?php
    if (Session::get('loggedin')) {
        ?>
        <div class="bs">
            <nav role="navigation" class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li <?php echo $homeclass; ?>><a
                                href="<?php echo DIR; ?>"><?php echo \Core\Language::show('nav_home', 'admin/Admin'); ?></a>
                        </li>
                        <li <?php echo $listclass; ?>><a
                                href="<?php echo DIR; ?>admin/list/"><?php echo \Core\Language::show('nav_lists', 'admin/Admin'); ?></a>
                        </li>
                        <li <?php echo $userclass; ?>><a
                                href="<?php echo DIR; ?>admin/user/"><?php echo \Core\Language::show('nav_users', 'admin/Admin'); ?></a>
                        </li>

                        <li <?php echo $setclass; ?>><a
                                href="<?php echo DIR; ?>admin/settings/"><?php echo \Core\Language::show('nav_settings', 'admin/Admin'); ?>

                            </a></li>

                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo DIR; ?>admin/logout"><span class="glyphicon glyphicon-log-out"></span>
                                <?php echo \Core\Language::show('nav_logout', 'admin/Admin'); ?></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <?php
    }
    ?>
