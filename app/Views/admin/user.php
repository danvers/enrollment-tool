<ul class="breadcrumb">
    <li><a href='<?php echo DIR; ?>admin'><?php echo \Core\Language::show('admin', 'Breadcrumb'); ?></a> <span
            class="divider"></span></li>
    <li><a href='<?php echo DIR; ?>admin/user'><?php echo \Core\Language::show('admin_users', 'Breadcrumb'); ?></a>
        <span class="divider"></span></li>
</ul>

<div class="add-button pull-right">
    <p><a href='<?php echo DIR; ?>admin/user/add'
          class='btn btn-success'><?php echo \Core\Language::show('button_add', 'admin/Users'); ?></a></p>
</div>
<div class="page-header">
    <h1>
        <?php echo $data['title']; ?>
    </h1>
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
<table class='table table-striped table-hover responsive'>
    <thead>
    <tr>
        <th><?php echo \Core\Language::show('label_username', 'admin/Users'); ?></th>
        <th><?php echo \Core\Language::show('th_email', 'admin/Listing'); ?></th>
        <th class="text-right"><?php echo \Core\Language::show('th_action', 'admin/Listing'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($data['users']) {
        foreach ($data['users'] as $row) {
            ?>
            <tr>
                <td><?php echo $row->username; ?></td>
                <td><?php echo $row->email; ?></td>
                <td class="text-right">
                    <a title="<?php echo Core\Language::show('hint_edit_entry', 'admin/Listing'); ?>"
                       class="btn btn-xs btn-primary"
                       href="<?php echo DIR; ?>admin/user/edit/<?php echo $row->memberID; ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <?php
                    if (sizeof($data['users']) <= 1 || \Helpers\Session::get('user') == $row->memberID) {
                        ?>
                        <a class="btn btn-xs btn-danger" aria-disabled="disabled" disabled="disabled" href="#">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a title="<?php echo Core\Language::show('hint_delete_entry', 'admin/Listing'); ?>"
                           class="btn btn-xs btn-danger"
                           href="<?php echo DIR; ?>admin/user/delete/<?php echo $row->memberID; ?>">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
