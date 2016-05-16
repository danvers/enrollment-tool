<?php
use Helpers\Assets;
use Helpers\Hooks;
use Helpers\Url;

//initialise hooks
$hooks = Hooks::get();
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>

    <!-- Site meta -->
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $data['title'] . ' - ' . SITETITLE; //SITETITLE defined in app/core/config.php ?></title>

    <!-- CSS -->
    <?php
    Assets::css(array(
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
        Url::templatePath('admin') . 'css/login.css',
    ));

    //hook for plugging in css
    $hooks->run('css');
    ?>

</head>
<body>

<div class="container">
