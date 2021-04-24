<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION["name"]) ) { 
    die('ACCESS DENIED');
    error_log("ACCESS DENIED-Not logged in");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Access Review</title>
    <link href="tabulator-master/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="tabulator-master/dist/js/tabulator.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.6.0.slim.js" type="text/javascript"></script>
    <script>
        window.jQuery || document.write('<script src="jquery-3.6.0.slim.min"><\/script>'))
    </script>

</head>
