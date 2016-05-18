<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 02.12.2015
 * Time: 00:21
 *
 * @author Dan Verständig - dan@pixelspace.org
 */
use Helpers\Form;

?>
    <ul class="breadcrumb">
        <li><a href='<?php echo DIR; ?>admin'><?php echo \Core\Language::show('admin', 'Breadcrumb'); ?></a> <span
                class="divider"></span></li>
        <li><a href='<?php echo DIR; ?>admin/list'><?php echo \Core\Language::show('admin_list', 'Breadcrumb'); ?></a>
            <span class="divider"></span></li>
        <li><?php echo $data['title']; ?></li>
    </ul>

    <div class="page-header">
        <h1><?php echo \Core\Language::show('del_course', 'admin/Listing'); ?></h1>
    </div>

<?php echo \Core\Error::display($data['error']); ?>

    <p><?php echo sprintf(\Core\Language::show('del_course_question', 'admin/Listing'), $data['row'][0]->name); ?></p>
    <div class="alert alert-warning">
        <?php echo \Core\Language::show('del_course_message', 'admin/Listing'); ?>
    </div>
<?php
echo Form::open(array('method' => 'post', 'class' => 'form-horizontal'));
?>
    <a href="<?php echo DIR; ?>admin/list" class="btn btn-danger btn-m active"
       role="button"><?php echo \Core\Language::show('cancel_button', 'admin/Listing'); ?></a>
<?php
echo Form::hidden(array('name' => 'id', 'value' => $data['row'][0]->memberID));
echo Form::submit(array('name' => 'submit', 'class' => 'btn btn-primary', 'value' => \Core\Language::show('submit_button', 'admin/Listing')));
echo Form::close();
?>