<?php

include_once "config.inc.php";
include_once "ez_sql_core.php";
include_once "ez_sql_postgresql.php";

$db = new ezSQL_postgresql($dbuser,$dbpassword,$dbname,$dbserver,$dbport);



?>
