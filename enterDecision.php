<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION["name"]) ) { 
    die('ACCESS DENIED');
    error_log("ACCESS DENIED-Not logged in");
}

