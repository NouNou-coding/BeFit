<?php
require 'config.php';
session_unset();
session_destroy();
header("Location: http://localhost/befit/index.php");
exit();
?>