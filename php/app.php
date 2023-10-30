<?php

use Model\ActiveRecord;
use Dotenv\Dotenv;

include  "./../vendor/autoload.php";

$dotenv = Dotenv::CreateImmutable(__DIR__);
$dotenv->safeLoad();

include "database.php";
include "funciones.php";

$db = database();
$db->set_charset("utf8");
ActiveRecord::setDB($db);

?>