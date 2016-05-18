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

?>

<div class="page-header">
    <h1><?php echo $data['title'] ?></h1>
</div>
<?php
if (\Helpers\Session::get('message')) {
    ?>
    <div class="alert alert-success">
        <?php echo \Helpers\Session::pull('message'); ?>
    </div>
    <?php
}
?>
<div>
    <?php
    if ((isset($data['list']->start_date) && isset($data['list']->end_date))) {
        ?>
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($data['list']->start_date) && isset($data['list']->end_date)) {
                    echo sprintf(Language::show('text_open_1', 'Home'),
                        date('d.m.y - H:i', strtotime($data['list']->start_date)),
                        date('d.m.y - H:i', strtotime($data['list']->end_date)));
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>
    <?php
    $lehrkraft = $data['list']->dozent;
    if ($data['list']->dozent_url) {
        $lehrkraft = '<a href="' . $data['list']->dozent_url . '">' . $data['list']->dozent . '</a>';
    }
    ?>
    <div>
        <?php
        if ($data['list']->public == 1 && (substr($_SERVER['REMOTE_ADDR'], 0, 7) === '141.44.' || \Helpers\Session::get('loggedin'))) {
            ?>
            <p class="pull-right text-right">
                <strong><?php echo Language::show('th_entries', 'Home'); ?></strong> <?php echo sizeof($data['entries']); ?>
            </p>
            <?php
        }
        ?>
        <p><strong><?php echo Language::show('th_lk', 'Home'); ?></strong> <?php echo $lehrkraft; ?></p>
    </div>
    <div class="clearfix">
        <?php
        echo $data['list']->description;
        ?>
    </div>
</div>

<?php
if ($data['list']->public == 1 && (substr($_SERVER['REMOTE_ADDR'], 0, 7) === '141.44.' || \Helpers\Session::get('loggedin'))) {

    if (sizeof($data['entries']) > 0) {
        if (sizeof($data['entries']) > 10) {
            ?>
            <hr/>
            <div>
                <p>
                    <a class="btn btn-md btn-default"
                       href="<?php echo DIR; ?>"><?php echo Language::show('back', 'Home'); ?></a>
                    <a class="btn btn-md btn-success"
                       href="<?php echo DIR; ?><?php echo $data['list']->slug; ?>/enroll"><?php echo Language::show('sign', 'Home'); ?></a>
                </p>
            </div>
            <hr/>
            <?php
        }
        ?>
        <h3><?php echo Language::show('overview', 'Enroll'); ?></h3>
        <table class='table table-striped table-hover responsive'>
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th><?php
                    echo Language::show('th_name', 'Home');
                    ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($data['entries']) {
                $i = 1;
                foreach ($data['entries'] as $row) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php
                            echo $row->firstname . ' ' . $row->lastname;
                            ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
        <?php
    }
}
?>
<hr/>
<div>
    <p>
        <a class="btn btn-md btn-default" href="<?php echo DIR; ?>"><?php echo Language::show('back', 'Home'); ?></a>
        <a class="btn btn-md btn-success"
           href="<?php echo DIR; ?><?php echo $data['list']->slug; ?>/enroll"><?php echo Language::show('sign', 'Home'); ?></a>
    </p>
</div>