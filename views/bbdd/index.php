<?php
require 'views/comun.php';

HTMLHead("bbddstyle");
HTMLHeader();
echo $this->mensaje;
require_once 'views/bbdd.php';
HTMLFooter();
?>
