<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 02.12.2015
 * Time: 16:35
 */
use Helpers\Assets;
use Helpers\Hooks;
use Helpers\Url;

$hooks = Hooks::get();

Assets::js(array(
    '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js',
    Url::templatePath('admin') . '/js/bootstrap-datetimepicker.js',
    Url::templatePath('admin') . 'js/tinymce/langs/de.js',
    Url::templatePath('admin') . 'js/tinymce/tinymce.min.js'
));
$hooks->run('js');
Assets::css(array(
        '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css'
    )
);
$hooks->run('css');
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $.fn.editable.defaults.mode = 'popup';
        $('.xedit').editable({
                source: [
                    <?php
                    $study_js_string = "";
                    foreach ($data['study_data'] as $item => $key) {
                        $study_js_string .= '{value: "' . $item . '", text: "' . $key . '"},' . "\n\t\t";
                    }
                    $study_js_string = substr($study_js_string, 0, strlen(($study_js_string)) - 1);
                    echo $study_js_string;
                    ?>
                ]
            }
        );
        $(document).on('click', '.editable-submit', function () {
            var x = $(this).closest('td').children('span').attr('id');
            var y = $('.input-sm').val();
            var z = $(this).closest('td').children('span');
            var f = $(this).closest('td').children('span').attr('name');
            $.ajax({
                url: '<?php echo DIR;?>admin/list/entries/ajax',
                data: 'id=' + x + '&name=' + f + '&data=' + y,
                type: 'GET',
                success: function (s) {
                    if (s == 'status') {
                        $(z).html(y);
                    }
                    if (s == 'error') {
                        alert('<?php echo \Core\Language::show('ajax_no_update', 'admin/Listing');?>');
                    }
                },
                error: function (e) {
                    alert('<?php echo \Core\Language::show('ajax_no_update', 'admin/Listing');?>');
                }
            });
        });
    });
</script>
<ul class="breadcrumb">
    <li><a href='<?php echo DIR; ?>admin'><?php echo \Core\Language::show('admin', 'Breadcrumb'); ?></a> <span
            class="divider"></span></li>
    <li><a href='<?php echo DIR; ?>admin/list'><?php echo \Core\Language::show('admin_list', 'Breadcrumb'); ?></a> <span
            class="divider"></span></li>
    <li><?php echo $data['title']; ?></li>
</ul>
<div class="add-button pull-right">
    <p>
        <a href='<?php echo DIR . $data['course']->slug; ?>/enroll/'
           class='btn btn-success'><?php echo \Core\Language::show('button_add_entry', 'admin/Listing'); ?></a>
        <a href='<?php echo DIR; ?>admin/list/export/<?php echo $data['course']->id; ?>'
           class='btn btn-primary'><?php echo \Core\Language::show('button_export_list', 'admin/Listing'); ?></a>
    </p>
</div>

<div class="page-header">
    <h1><?php echo $data['title'] ?></h1>
</div>
<?php
if ((\Helpers\Session::get('message'))) {
    ?>
    <div class="alert alert-success">
        <?php echo \Helpers\Session::pull('message'); ?>
    </div>
    <?php
}
?>
<?php
if (sizeof($data['entries']) > 0) {
    ?>
    <table class="table table-striped table-hover dataTable" data-provides="rowlink" id="datatable">
        <thead>
        <tr>
            <th colspan="2"><?php echo \Core\Language::show('th_name', 'admin/Listing'); ?></th>
            <th><?php echo \Core\Language::show('th_email', 'admin/Listing'); ?></th>
            <th><?php echo \Core\Language::show('th_id', 'admin/Listing'); ?></th>
            <th><?php echo \Core\Language::show('th_study', 'admin/Listing'); ?></th>
            <th class="text-center"><?php echo \Core\Language::show('th_semester', 'admin/Listing'); ?></th>
            <th class="text-center"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data['entries'] as $entry) {
            ?>
            <tr>
                <td>
                    <span class="xedit" name="firstname" id="<?php echo $entry->id; ?>">
                        <?php echo $entry->firstname; ?>
                    </span>
                </td>
                <td>
                    <span class="xedit" name="lastname" id="<?php echo $entry->id; ?>">
                        <?php echo $entry->lastname; ?>
                    </span>
                </td>
                <td>
                    <span class="xedit" name="email" id="<?php echo $entry->id; ?>">
                        <?php echo $entry->email; ?>
                    </span>
                </td>
                <td>
                    <span class="xedit" name="matrikel" id="<?php echo $entry->id; ?>">
                        <?php echo $entry->matrikel; ?>
                    </span>
                </td>
                <td>
                    <span data-type="select" name="study" class="xedit study" id="<?php echo $entry->id; ?>">
                        <?php echo $data['study_data'][$entry->study]; ?>
                    </span>
                </td>
                <td class="text-center">
                    <span class="xedit" name="semester" id="<?php echo $entry->id; ?>">
                        <?php echo $entry->semester; ?>
                    </span>
                </td>
                <td>
                    <span name="created">
                        <?php echo date('j.n.y H:i', strtotime($entry->created)); ?>
                    </span>
                </td>
                <td class="text-center">
                    <a title="<?php echo \Core\Language::show('hint_delete_entry', 'admin/Listing'); ?>"
                       class="btn btn-xs btn-danger"
                       href="<?php echo DIR . 'admin/list/entries/' . $data["id"] . '/delete/' . $entry->id; ?>">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}
?>
<hr/>
<a href="<?php echo DIR; ?>admin/list" class="btn btn-default btn-m"
   role="button"><?php echo \Core\Language::show('button_back', 'admin/Listing'); ?></a>
<div class="add-button pull-right">
    <p>
        <a href='<?php echo DIR . $data['course']->slug; ?>/enroll/'
           class='btn btn-success'><?php echo \Core\Language::show('button_add_entry', 'admin/Listing'); ?></a>
        <a href='<?php echo DIR; ?>admin/list/export/<?php echo $data['course']->id; ?>'
           class='btn btn-primary'><?php echo \Core\Language::show('button_export_list', 'admin/Listing'); ?></a>
    </p>
</div>