<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 20.05.2016
 * Time: 23:35
 *
 * @author Dan Verständig - dan@pixelspace.org
 */
use Helpers\Assets;
use Helpers\Form;
use Helpers\Hooks;
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
    <li><?php echo $data['title']; ?></li>
</ul>

<div class="page-header">
    <h1><?php echo $data['title'] ?></h1>
</div>

<?php
echo \Core\Error::display($data['error']);
echo Form::open(array('method' => 'post', 'class' => 'form-horizontal'));

$params = array(
    'title' => \Core\Language::show('label_description', 'admin/Listing'),
    'name' => 'home_text',
    'id' => 'home_text',
    'error' => (in_array('description', $error_fields)) ? true : false,
    'value' => $data['settings']['home_message'],
    'rows' => 10);
?>
<div class="settings">
    <div class="form-group">
        <label class="control-label"><?php echo \Core\Language::show('label_description', 'admin/Admin'); ?></label>
        <br/><br/>
        <?php
        echo Form::textBox($params);
        ?>
    </div>
</div>
<a href="<?php echo DIR; ?>admin/user" class="btn btn-danger btn-m active"
   role="button"><?php echo \Core\Language::show('cancel', 'admin/Users'); ?></a>
<?php
echo Form::submit(array('name' => 'submit', 'class' => 'btn btn-primary', 'value' => \Core\Language::show('button_update', 'admin/Users')));
echo Form::close();
?>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea',
        language: '<?php echo LANGUAGE_CODE;?>',
        height: 250,
        plugins: [
            "advlist autolink autosave link lists charmap print preview hr anchor",
            "searchreplace wordcount visualblocks visualchars  fullscreen insertdatetime nonbreaking",
            "table contextmenu directionality emoticons textcolor paste colorpicker textpattern"
        ],
        toolbar1: "alignleft aligncenter alignright | bullist numlist outdent indent | undo redo | link unlink anchor"
    });
</script>
