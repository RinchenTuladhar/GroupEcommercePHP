<?php
if (session_status () == PHP_SESSION_NONE) {
    session_start ();
}
require_once ('db/functions.php');

$db = new Functions ();

?>