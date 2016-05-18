<?php

use Helpers\Hooks;

//initialise hooks
$hooks = Hooks::get();
?>
</div>
<?php
//hook for plugging in code into the footer
$hooks->run('footer');
?>

</body>
</html>