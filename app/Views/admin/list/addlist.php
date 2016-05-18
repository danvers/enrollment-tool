<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 29.11.2015
 * Time: 16:04
 *
 * @author Dan Verständig - dan@pixelspace.org
 */
use Helpers\Assets;
use Helpers\Form;
use Helpers\Hooks;
use Helpers\MyFormElements;
use Helpers\Url;

$error_fields = array();
if (isset($data['form_errors'])) {
    foreach ($data['form_errors'] as $error) {
        if (!in_array($error['field'], $error_fields))
            $error_fields[] = $error['field'];
    }
}
//initialise hooks
$hooks = Hooks::get();

Assets::js(array(
    '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js',
    Url::templatePath('admin') . '/js/bootstrap-datetimepicker.js',
    Url::templatePath('admin') . 'js/tinymce/langs/de.js',
    Url::templatePath('admin') . 'js/tinymce/tinymce.min.js'
));
$hooks->run('js');
Assets::css(array(
    '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
    Url::templatePath('admin') . 'css/style.css',
    Url::templatePath('admin') . 'css/bootstrap-datetimepicker.css'
));

//hook for plugging in css
$hooks->run('css');
?>

<ul class="breadcrumb">
    <li><a href='<?php echo DIR; ?>admin'><?php echo \Core\Language::show('admin', 'Breadcrumb'); ?></a> <span
            class="divider"></span></li>
    <li><a href='<?php echo DIR; ?>admin/list'><?php echo \Core\Language::show('admin_list', 'Breadcrumb'); ?></a> <span
            class="divider"></span></li>
    <li><?php echo \Core\Language::show('admin_list_add', 'Breadcrumb'); ?></li>
</ul>

<div class="page-header">
    <h1><?php echo \Core\Language::show('add_course', 'admin/Listing'); ?></h1>
</div>

<?php
echo \Core\Error::display($data['error']);
echo Form::open(array('method' => 'post', 'class' => 'form-horizontal'));
?>

<?php
$params = array(
    'title' => \Core\Language::show('label_course', 'admin/Listing'),
    'placeholder' => \Core\Language::show('ph_course', 'admin/Listing'),
    'name' => 'name',
    'id' => 'name',
    'error' => (in_array('name', $error_fields)) ? true : false,
    'value' => isset($_POST['name']) ? $_POST['name'] : '',
    'type' => 'input');
echo MyFormElements::drawWrapper($params, 'input', 10);
?>
<?php
$status = '';
if ((isset($_POST) && sizeof($_POST) > 0)) {
    if (in_array('dozent', $error_fields)) {
        $status = 'has-error';
    } else {
        $status = 'has-success';
    }
}
?>
<div class="form-group <?php echo $status; ?>">
    <label for="dozent"
           class="col-sm-2 control-label"><?php echo \Core\Language::show('label_lecturer', 'admin/Listing'); ?></label>
    <div class="col-sm-4">
        <?php
        $params = array(
            'title' => \Core\Language::show('label_lecturer', 'admin/Listing'),
            'name' => 'dozent',
            'id' => 'dozent',
            'placeholder' => \Core\Language::show('ph_lecturer', 'admin/Listing'),
            'error' => (in_array('dozent', $error_fields) && (isset($_POST) && sizeof($_POST) > 0)) ? true : false,
            'value' => isset($_POST['dozent_url']) ? $_POST['dozent'] : '',
            'class' => 'form-control',
            'type' => 'text');
        echo Form::input($params);
        ?>
    </div>
    <?php
    $status = '';
    if ((isset($_POST) && sizeof($_POST) > 0)) {
        if (in_array('dozent_url', $error_fields)) {
            $status = 'has-error';
        }
    }
    ?>
    <div class="col-sm-6 <?php echo $status; ?>">
        <?php
        $params = array(
            'name' => 'dozent_url',
            'id' => 'dozent_url',
            'placeholder' => \Core\Language::show('ph_weblink', 'admin/Listing'),
            'value' => isset($_POST['dozent_url']) ? $_POST['dozent_url'] : '',
            'class' => 'form-control',
            'type' => 'text');
        echo Form::input($params);
        ?>
    </div>
</div>
<?php

$params = array(
    'title' => \Core\Language::show('label_limit', 'admin/Listing'),
    'name' => 'max_limit',
    'id' => 'max_limit',
    'min' => 0,
    'error' => (in_array('max_limit', $error_fields)) ? true : false,
    'value' => isset($_POST['max_limit']) ? $_POST['max_limit'] : '',
    'type' => 'number');
echo MyFormElements::drawWrapper($params, "input", 2);

if (isset($_POST['start_date'])) {
    $start_formatted = date('d.m.Y H:i', strtotime($_POST['start_date']));
    $start_formatted_js = date('Y, m, d, h, i', strtotime($_POST['start_date']));
} else {
    $start_formatted = '';
    $start_formatted_js = '';
}
if (isset($_POST['end_date'])) {
    $end_formatted = date('d.m.Y H:i', strtotime($_POST['end_date']));
    $end_formatted_js = date('Y, m, d, h, i', strtotime($_POST['end_date']));
} else {
    $end_formatted = '';
    $end_formatted_js = '';
}
if (in_array('start_date', $error_fields)) {
    $error = 'has-error';
} elseif ((isset($_POST) && sizeof($_POST) > 0) && (!in_array('start_date', $error_fields))) {
    $error = 'has-success';
}
?>
<div class="form-group <?php echo $error; ?>">
    <label for="start_date"
           class="col-sm-2 control-label"><?php echo \Core\Language::show('label_start', 'admin/Listing'); ?></label>
    <div class="col-sm-4">
        <div class="input-group date" id="dtpstart">
            <input type='text' id='start_date' name='start_date' class='form-input text form-control form-control'
                   value="<?php echo $start_formatted; ?>"/>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
    <?php
    if (in_array('end_date', $error_fields)) {
        $error = 'has-error';
    } elseif ((isset($_POST) && sizeof($_POST) > 0) && (!in_array('end_date', $error_fields))) {
        $error = 'has-success';
    }
    ?>
    <div class="<?php echo $error; ?>">
        <label for="end_date"
               class="col-sm-2 control-label"><?php echo \Core\Language::show('label_end', 'admin/Listing'); ?></label>
        <div class="col-sm-4">
            <div class="input-group date" id="dtpend">
                <input type='text' id='end_date' name='end_date' class='form-input text form-control form-control'
                       value="<?php echo $end_formatted; ?>"/>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>
</div>
<div class="form-group <?php echo $status; ?>">
    <label for="dozent"
           class="col-sm-2 control-label"><?php echo \Core\Language::show('label_study', 'admin/Listing'); ?></label>

    <div class="col-xs-5">
        <select class="form-control multiselect" name="study[]" multiple>
            <?php
            foreach ($data['study_data'] as $item => $key) {
                ?>
                <option value="<?php echo $item; ?>"><?php echo $key; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>

<?php
$params = array(
    'title' => \Core\Language::show('label_description', 'admin/Listing'),
    'name' => 'description',
    'id' => 'description',
    'error' => (in_array('description', $error_fields)) ? true : false,
    'value' => isset($_POST['description']) ? $_POST['description'] : '',
    'rows' => 10);
echo MyFormElements::drawWrapper($params, 'textarea', 10);

$params = array(
    $cb_data => array(
        'label' => \Core\Language::show('label_public_course', 'admin/Listing'),
        'name' => 'visible[]',
        'id' => 1
    )
);
if (isset($_POST['visible'])) {
    $params[$cb_data]['checked'] = true;
}
?>
<div class="form-group">
    <label style="vertical-align: middle" for="max" class="col-sm-2 control-label"></label>
    <div class="col-sm-3">
        <?php
        echo MyFormElements::checkbox($params);
        ?>
    </div>
    <?php
    $params = array(
        $cb_data => array(
            'label' => \Core\Language::show('label_public_list', 'admin/Listing'),
            'name' => 'public[]',
            'id' => 1
        )
    );
    if (!isset($_POST['public'])) {
        $params[$cb_cata]['checked'] = true;
    }
    ?>
    <div class="col-sm-4">
        <?php
        echo MyFormElements::checkbox($params);
        ?>
    </div>
</div>

<hr/>
<div class="form-group my-form-buttons">
    <a href="<?php echo DIR; ?>admin/list" class="btn btn-danger btn-m active"
       role="button"><?php echo \Core\Language::show('cancel', 'admin/Listing'); ?></a>
    <?php
    echo Form::submit(array('name' => 'submit', 'class' => 'btn btn-primary', 'value' => \Core\Language::show('add_course', 'admin/Listing')));
    ?>
</div>
<?php
echo Form::close();
?>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea',
        language: 'de',
        height: 150,
        plugins: [
            "autolink autosave link lists charmap print preview hr anchor",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
            "table contextmenu directionality emoticons textcolor paste colorpicker textpattern"
        ],
        toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | undo redo | link unlink anchor code"
    });

    $(document).ready(function () {
        $('#dtpstart').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            locale: 'de',
            <?php if(isset($_POST['start_date'])){
            ?>
            defaultDate: new Date(<?php echo $start_formatted_js;?>)
            <?php
            }
            ?>
        });
        $('#dtpend').datetimepicker({
            locale: 'de',
            <?php if(isset($_POST['end_date'])){
            ?>
            defaultDate: new Date(<?php echo $end_formatted_js;?>),
            <?php
            }
            ?>
            useCurrent: false //Important! See issue #1075
        });
        $("#dtpstart").on("dp.change", function (e) {
            $('#dtpend').data("DateTimePicker").minDate(e.date);
        });
        $("#dtpend").on("dp.change", function (e) {
            $('#dtpstart').data("DateTimePicker").maxDate(e.date);
        });

        $('.multiselect').multiselect({
            numberDisplayed: 3,
            nSelectedText: '<?php echo \Core\Language::show('selected', 'admin/Listing');?>',
            selectAllText: '<?php echo \Core\Language::show('select_all', 'admin/Listing');?>',
            includeSelectAllOption: true,
            buttonText: function (options, select) {
                if (options.length == 0) {
                    return 'keine Auswahl getroffen';
                }
                else {
                    if (options.length > this.numberDisplayed) {
                        return options.length + ' ' + this.nSelectedText;
                    }
                    else {
                        var selected = '';
                        options.each(function () {
                            var label = ($(this).attr('label') !== undefined) ? $(this).attr('label') : $(this).html();
                            selected += label + ', ';
                        });
                        return selected.substr(0, selected.length - 2);
                    }
                }
            }
        });
    });
</script>