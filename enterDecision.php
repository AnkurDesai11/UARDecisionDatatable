<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['email'] ) ) { 
    die('ACCESS DENIED');
    error_log("ACCESS DENIED-Not logged in");
}

?>

<!DOCTYPE html>

<head>
    
    <title>User Access Review</title>
    <link href="tabulator-master/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="tabulator-master/dist/js/tabulator.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="jquery-3.6.0.min"><\/script>')</script>

</head>
<body>

    <div id="datatable" ></div>
    
    <script type="text/javascript">

        var idArray = new Array();

    
    
        var table = new Tabulator("#datatable", {
            height: 500,
            //data: tabledata,
            placeholder:"No Data Set",
            layout: "fitColumns",
            columns: [
                
                {title: "Application Name", field: "applicationname", sorter: "string", width: 150, headerFilter: "input"}, 
                {title: "Employee ID",field: "employeeid",sorter: "string",hozAlign: "left",headerFilter: "input",},
                {title: "Employee Name",field: "employeename",sorter: "string",hozAlign: "center",}, 
                {title: "Profile/Access Level/Role",field: "role",sorter: "string",hozAlign: "center",headerFilter: "input",},
                {title: "Access Decision",field: "accessdecision",hozAlign: "center",editor: "select",editorParams: {"keep": "Keep","revoke": "Revoke","notaware": "Not Aware","delete": "Delete"}},
                {title: "Comments",field: "comments",hozAlign: "center",editor: "input",},
                
            ],
            cellEdited: function (cell) {
            // This callback is called any time a cell is edited.
            var datax = cell.getData();
            var mynotes = datax.mynotes;
            var ffsv = datax.ffsv;
            var orgid = datax.orgid;
            var fields = cell.getField();
            $.ajax({

                url: 'ajaxEdit.php',
                data: { 'orgid': orgid, 'mynotes': mynotes, 'ffsv': ffsv, 'fieldn': fields },
                type: 'post'

                })
            },

            dataFiltered:function(filters, rows){
                //filters - array of filters currently applied
                //rows - array of row components that pass the filters

            },

        });

        $(document).ready(function() {
            table.setData("ajaxLoad.php?decision=1");
        });

    <script>
</body>


</html>

