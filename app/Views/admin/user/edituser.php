<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 02.12.2015
 * Time: 16:35
 *
 * @author Dan Verständig - dan@pixelspace.org
 */
use Helpers\Form;
use Helpers\MyFormElements;

$error_fields = array();
if (isset($data['form_errors'])) {
    foreach ($data['form_errors'] as $error) {
        if (!in_array($error['field'], $error_fields))
            $error_fields[] = $error['field'];
    }
}
?>
    <ul class="breadcrumb">
        <li><a href='<?php echo DIR; ?>admin'><?php echo \Core\Language::show('admin', 'Breadcrumb'); ?></a> <span
                class="divider"></span></li>
        <li><a href='<?php echo DIR; ?>admin/user'><?php echo \Core\Language::show('admin_users', 'Breadcrumb'); ?></a>
            <span class="divider"></span></li>
        <li><?php echo $data['title']; ?></li>
    </ul>

    <div class="page-header">
        <h1><?php echo $data['title'] ?></h1>
    </div>

<?php
echo \Core\Error::display($data['error']);
echo Form::open(array('method' => 'post', 'class' => 'form-horizontal'));

$params = array(
    'title' => \Core\Language::show('label_username', 'admin/Users'),
    'name' => 'username',
    'id' => 'username',
    'error' => (in_array('username', $error_fields)) ? true : false,
    'value' => $data['row'][0]->username,
    'type' => 'input');
echo MyFormElements::drawWrapper($params);

$params = array(
    'title' => \Core\Language::show('label_userpass', 'admin/Users'),
    'name' => 'password',
    'id' => 'password',
    'error' => (in_array('password', $error_fields)) ? true : false,
    'value' => '',
    'type' => 'password');
echo MyFormElements::drawWrapper($params);

$params = array(
    'title' => \Core\Language::show('label_usermail', 'admin/Users'),
    'name' => 'email',
    'id' => 'email',
    'error' => (in_array('email', $error_fields)) ? true : false,
    'value' => $data['row'][0]->email,
    'type' => 'email');
echo MyFormElements::drawWrapper($params);
?>
    <a href="<?php echo DIR; ?>admin/user" class="btn btn-danger btn-m active"
       role="button"><?php echo \Core\Language::show('cancel', 'admin/Users'); ?></a>
<?php
echo Form::submit(array('name' => 'submit', 'class' => 'btn btn-primary', 'value' => \Core\Language::show('button_update', 'admin/Users')));
echo Form::close();
?>