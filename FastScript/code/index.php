<?php
error_reporting(E_ALL);
require_once('Loader.php');

//Loader handles all loading and working
//Work. It takes an array from Load and makes working html from it
$L = new Loader();
$L->Load('FastScripts/FastScript1');
echo $L->Work();

?>
