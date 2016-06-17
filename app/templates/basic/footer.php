<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 05.12.2015
 * Time: 00:09
 *
 * @author Dan Verständig - dan@pixelspace.org
 */

use Helpers\Hooks;

$hooks = Hooks::get();
?>
</div>
<footer class="footer">
    <div class="container">
        <p class="text-muted text-right">Made with
            <a href="http://http://novaframework.com/php-framework">Nova Framework</a> and
            <a href="http://getbootstrap.com/">Bootstrap</a> by
            <a href="https://pixelspace.org">pixelspace.org</a></p>
    </div>
</footer>
<?php
$hooks->run('footer');
?>
</body>
</html>
