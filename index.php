<?php

define('MAD', 1);

session_start();
require_once($_SERVER['DOCUMENT_ROOR'].'/sys/start.php');

$run = new Start();
$run->run();

?>