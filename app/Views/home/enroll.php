<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 02.12.2015
 * Time: 16:35
 *
 * @author Dan Verständig - dan@pixelspace.org
 */
use Core\Language;
use Helpers\Form;
use Helpers\MyFormElements;
use Helpers\Session;

$error_fields = array();
if (isset($data['form_errors'])) {
    foreach ($data['form_errors'] as $error) {
        if (!in_array($error['field'], $error_fields))
            $error_fields[] = $error['field'];
    }
}
?>

<div class="page-header">
    <h1><?php echo $data['title'] ?></h1>
</div>
<?php
if (\Helpers\Session::get('message')) {
    ?>
    <div class="alert alert-danger">
        <?php echo \Helpers\Session::pull('message'); ?>
    </div>
    <?php
}
?>
<?php
echo \Core\Error::display($data['error']);
?>

<div>
    <?php
    echo Form::open(array('method' => 'post', 'class' => 'form-horizontal'));

    $param_email = '';
    if (isset($_POST['email'])) {
        $param_email = $_POST['email'];
    } elseif (Session::get('stored_data', 'email')) {
        $param_email = Session::get('stored_data', 'email');
    }
    $params = array(
        'title' => Language::show('field_email', 'Enroll'),
        'name' => 'email',
        'id' => 'email',
        'placeholder' => Language::show('field_email', 'Enroll'),
        'error' => (in_array('email', $error_fields)) ? true : false,
        'value' => $param_email,
        'type' => 'email');
    echo MyFormElements::drawWrapper($params);


    $param_firstname = '';
    if (isset($_POST['firstname'])) {
        $param_firstname = $_POST['firstname'];
    } elseif (Session::get('stored_data', 'firstname')) {
        $param_firstname = Session::get('stored_data', 'firstname');
    }
    $params = array(
        'title' => Language::show('field_firstname', 'Enroll'),
        'name' => 'firstname',
        'id' => 'firstname',
        'placeholder' => Language::show('field_firstname', 'Enroll'),
        'error' => (in_array('firstname', $error_fields)) ? true : false,
        'value' => $param_firstname,
        'type' => 'text');
    echo MyFormElements::drawWrapper($params);

    $param_lastname = '';
    if (isset($_POST['lastname'])) {
        $param_lastname = $_POST['lastname'];
    } elseif (Session::get('stored_data', 'lastname')) {
        $param_lastname = Session::get('stored_data', 'lastname');
    }
    $params = array(
        'title' => Language::show('field_lastname', 'Enroll'),
        'name' => 'lastname',
        'id' => 'lastname',
        'placeholder' => Language::show('field_lastname', 'Enroll'),
        'error' => (in_array('lastname', $error_fields)) ? true : false,
        'value' => $param_lastname,
        'type' => 'text');
    echo MyFormElements::drawWrapper($params);

    $param_matrikel = '';
    if (isset($_POST['matrikel'])) {
        $param_matrikel = $_POST['matrikel'];
    } elseif (Session::get('stored_data', 'matrikel')) {
        $param_matrikel = Session::get('stored_data', 'matrikel');
    }
    $params = array(
        'title' => Language::show('field_matr', 'Enroll'),
        'name' => 'matrikel',
        'id' => 'matrikel',
        'placeholder' => Language::show('field_matr', 'Enroll'),
        'error' => (in_array('matrikel', $error_fields)) ? true : false,
        'value' => $param_matrikel,
        'min' => '0',
        'type' => 'number');
    echo MyFormElements::drawWrapper($params);

    $param_study = '';
    if (isset($_POST['studiengang'])) {
        $param_study = $_POST['studiengang'];
    } elseif (Session::get('stored_data', 'study')) {
        $param_study = Session::get('stored_data', 'study');
    }


    if (empty($data['study'])) {
        $study_insert = $data['study_data'];
    } else {
        $study_insert = array();
        $study_allowed = explode('|', $data['study']);
        foreach ($study_allowed as $item => $key) {
            if (array_key_exists($key, $data['study_data'])) {
                $study_insert[$key] = $data['study_data'][$key];
            }
        }
    }

    $params = array(
        'title' => Language::show('field_study', 'Enroll'),
        'name' => 'studiengang',
        'id' => 'studiengang',
        'class' => 'form-control',
        'error' => (in_array('studiengang', $error_fields)) ? true : false,
        'value' => $param_study,
        'data' => $study_insert
    );
    echo MyFormElements::drawWrapper($params, 'select');
    $sem = array();
    for ($i = 1; $i <= 9; $i++) {
        $sem[$i] = $i;
    }


    $param_sem = '';
    if (isset($_POST['semester'])) {
        $param_sem = $_POST['semester'];
    } elseif (Session::get('stored_data', 'semester')) {
        $param_sem = Session::get('stored_data', 'semester');
    }
    $sem[10] = Language::show('other_semester', 'Enroll');
    $params = array(
        'title' => Language::show('field_term', 'Enroll'),
        'name' => 'semester',
        'id' => 'semester',
        'class' => 'form-control',
        'error' => (in_array('semester', $error_fields)) ? true : false,
        'value' => $param_sem,
        'data' => $sem
    );
    echo MyFormElements::drawWrapper($params, 'select');

    if ($data['active_lists'] > 1) {

        $params = array(
            $cb_data => array(
                'label' => '<abbr title="' . Language::show('abbr_session', 'Enroll') . '">' . Language::show('hint_session', 'Enroll') . ' </abbr>',
                'name' => 'store_data_session',
                'id' => 1,
                'value' => true
            )
        );
        if (isset($_POST['store_data_session']) || Session::get('stored_data')) {
            $params[$cb_cata]['checked'] = true;
        }
        ?>
        <div class="form-group ">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <?php
                echo MyFormElements::checkbox($params);
                ?>
            </div>
        </div>
        <?php
    }
    ?>
    <hr/>

    <a href="<?php echo DIR; ?><?php echo $data['slug']; ?>" class="btn btn-default btn-m"
       role="button"><?php echo Language::show('back', 'Home'); ?></a>
    <?php
    echo Form::hidden(array('value' => '', 'name' => 'id'));
    echo Form::submit(array('name' => 'submit', 'class' => 'btn btn-success', 'value' => Language::show('sign', 'Home')));
    echo Form::close();
    ?>
</div>