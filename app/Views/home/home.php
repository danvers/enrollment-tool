<?php
use Core\Language;

?>
    <div class="page-header">
        <h1><?php echo $data['title'] ?></h1>
    </div>

<?php

if ((Helpers\Session::get('message'))) {
    ?>
    <div class="alert alert-success">
        <?php echo Helpers\Session::pull('message'); ?>
    </div>
    <?php
} elseif ((Helpers\Session::get('e_message'))) {
    ?>
    <div class="alert alert-danger">
        <?php echo Helpers\Session::pull('e_message'); ?>
    </div>
    <?php
}
?>
    <p><?php echo $data['home_message'] ?></p>

<?php
if (sizeof($data['list_info']) > 0) {
    ?>
    <table class='table table-striped table-hover responsive table-borderless' data-toggle="table">
    <thead>
    <tr>
        <th data-field="title" data-sortable="true"><?php echo Language::show('th_title', 'Home'); ?></th>
        <th class="text-center" data-sortable="true"><?php echo Language::show('th_lk', 'Home'); ?></th>
        <th class="text-center" data-sortable="true"><?php echo Language::show('th_open', 'Home'); ?></th>
    </tr>
    </thead>
    <?php
    ?>
    <tbody>
    <?php
    foreach ($data['list_info'] as $list) {
        ?>
        <tr>
            <td>
                <a href="<?php echo DIR; ?><?php echo $list->slug; ?>/"> <?php echo $list->name; ?> </a>
            </td>
            <td><?php echo $list->dozent; ?></td>
            <td><?php
                if ($list->end_date) {
                    $time = strtotime($list->end_date);
                    echo date('d.m.y - H:i', $time) . ' ' . Language::show('time', 'Home');
                } else {
                    echo Language::show('no_end', 'Home');
                }
                ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    </table><?php
} else {
    ?>
    <p class="alert alert-info"><?php echo Language::show('no_entries', 'Home'); ?></p>
    <?php
}
?>