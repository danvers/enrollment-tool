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
<div class="container content">
    <div class="row">
        <div class="col-md-12">

            <h1><?php echo Core\Language::show('title', 'Error'); ?></h1>
            <hr/>
            <?php echo sprintf(Core\Language::show('error_text', 'Error'), DIR); ?>

        </div>
    </div>
</div>
