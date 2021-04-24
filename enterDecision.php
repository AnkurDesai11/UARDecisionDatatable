<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['email'] = $_POST['email']) ) { 
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
    <script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
    </script>
    <script>
        window.jQuery || document.write('<script src="jquery-3.6.0.min"><\/script>'))
    </script>

</head>
<body>

    <div id="datatable"></div>

</body>

<script type="text/javascript">

    var table = new Tabulator("#players", {
            height: 220,
            data: tabledata,
            layout: "fitColumns",
            columns: [
                
                {
                    title: "Application Name",
                    field: "applicationname",
                    sorter: "string",
                    width: 150,
                    headerFilter: "input"
                }, 
                
                {
                    title: "Employee ID",
                    field: "employeeid",
                    sorter: "string",
                    hozAlign: "left",
                    headerFilter: "input",
                },

                {
                    title: "Employee Name",
                    field: "employeename",
                    sorter: "string",
                    hozAlign: "center",
                }, 
                
                {
                    title: "Profile/Access Level/Role",
                    field: "role",
                    sorter: "string",
                    hozAlign: "center",
                    headerFilter: "input",
                },

                {
                    title: "Access Decision",
                    field: "accessdecision",
                    hozAlign: "center",
                    editor: "select",
                    editorParams: {
                        "keep": "Keep",
                        "revoke": "Revoke",
                        "notaware": "Not Aware",
                        "delete": "Delete"
                    }
                },

                {
                    title: "Comments",
                    field: "comments",
                    hozAlign: "center",
                    editor: "input",
                },
                
            ],



<script>