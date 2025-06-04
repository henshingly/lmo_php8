<?php

header('Location: //' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/lmo.php?' . urldecode($_SERVER['QUERY_STRING']));
exit;

?>