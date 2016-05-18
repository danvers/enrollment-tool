<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 02.12.2015
 * Time: 16:35
 *
 * @author Dan Verständig - dan@pixelspace.org
 */
if (isset($error)) {
    ?>
    <div class="error login">
        <?php echo \Core\Error::display($error); ?>
    </div>
    <?php
}
?>
<div class="login well">
    <div class="panel-body">
        <form name="form" id="form" class="form-horizontal" action="" method="post">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="username" type="text" class="form-control" name="username" value=""
                       placeholder="<?php echo \Core\Language::show('label_username', 'admin/Users'); ?>">
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="password" type="password" class="form-control" name="password"
                       placeholder="<?php echo \Core\Language::show('label_userpass', 'admin/Users'); ?>">
            </div>
            <div class="form-group">
                <div class="col-sm-12 controls">
                    <div class="pull-left">
                        <input type="submit" name="submit" class="btn btn-primary pull-left"
                               value="<?php echo $data['button_login']; ?>"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

