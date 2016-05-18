<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 02.12.2015
 * Time: 16:35
 *
 * @author Dan Verständig - dan@pixelspace.org
 */
?>
<ul class="breadcrumb">
    <li><a href='<?php echo DIR; ?>admin'><?php echo \Core\Language::show('admin', 'Breadcrumb'); ?></a> <span
            class="divider"></span></li>
    <li><?php echo $data['title']; ?></li>
</ul>

<div class="add-button pull-right">
    <p><a href='<?php echo DIR; ?>admin/list/add'
          class='btn btn-success'><?php echo \Core\Language::show('add_course', 'admin/Listing'); ?></a></p>
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

if ($data['list_info']) {
    ?>
    <table class='table table-striped table-hover responsive table-borderless' data-toggle="table">
        <thead>
        <tr>
            <th data-field="seminar"
                data-sortable="true"><?php echo \Core\Language::show('th_title', 'admin/Listing'); ?></th>
            <th data-field="lehrkraft"
                data-sortable="true"><?php echo \Core\Language::show('th_lecturer', 'admin/Listing'); ?></th>
            <th class="text-center"
                data-sortable="true"><?php echo \Core\Language::show('th_entries', 'admin/Listing'); ?></th>
            <th class="text-right"><?php echo \Core\Language::show('th_action', 'admin/Listing'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data['list_info'] as $row) {
            ?>
            <tr>
                <td><a href="<?php echo DIR; ?><?php echo $row->slug; ?>/"><?php
                        if ($row->visible == 0) {
                            echo '<em class="text-muted">' . $row->name . '</em>';
                        } else {
                            echo $row->name;
                        }
                        ?></a></td>
                <td><?php echo $row->dozent; ?></td>
                <td class="text-center"><?php echo $row->entries; ?></td>
                <td class="text-right">
                    <a title="Kurs <?php echo ($row->visible == 0) ? 'sichtbar machen' : 'verbergen'; ?>"
                       class="btn btn-xs btn-default"
                       href="<?php echo DIR; ?>admin/list/toggle/<?php echo $row->id; ?>">
                        <span
                            class="glyphicon glyphicon-eye-<?php echo ($row->visible == 1) ? 'open' : 'close'; ?>"></span>
                    </a>
                    <a title="Kurs bearbeiten" class="btn btn-xs btn-default"
                       href="<?php echo DIR; ?>admin/list/edit/<?php echo $row->id; ?>"><span
                            class="glyphicon glyphicon-edit"></span></a>
                    <a title="Anmeldungen bearbeiten"
                       class="<?php echo ($row->entries == 0) ? 'disabled ' : ''; ?>btn btn-xs btn-default"
                       href="<?php echo DIR; ?>admin/list/entries/<?php echo $row->id; ?>"><span
                            class="glyphicon glyphicon-list-alt"></span></a>
                    <a title="Einträge exportieren"
                       class="<?php echo ($row->entries == 0) ? 'disabled ' : ''; ?>btn btn-xs btn-primary"
                       href="<?php echo DIR; ?>admin/list/export/<?php echo $row->id; ?>"><span
                            class="glyphicon glyphicon-export"></span></a>
                    <a title="Kurs und Einträge löschen" class="btn btn-xs btn-danger"
                       href="<?php echo DIR; ?>admin/list/delete/<?php echo $row->id; ?>"><span
                            class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <hr/>
    <div class="add-button pull-right">
        <p><a href='<?php echo DIR; ?>admin/list/add'
              class='btn btn-success'><?php echo \Core\Language::show('add_course', 'admin/Listing'); ?></a></p>
    </div>

    <?php
} else {
    ?>
    <div class="alert alert-info"><?php echo \Core\Language::show('text_no_lists', 'admin/Listing'); ?></div>
    <?php
}
?>


            