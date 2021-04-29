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
    <h1> Enter your Decisions for User Access Review here </h1>
    <p> Please enter your decision and comments if necessary for the accounts of users assigned to you for the review
        Refresh the page periodically to ensure that updated decisions are recorded, if they are successfully updated, they will not be accessible below and will have to be modified from the Edit Decisions Page
    </p> 
    <div style="display:inline-block;" >
        <a href="enterDecision.php">Refresh Page</a> 
        <a href="editDecision.php" style="margin-left:75px;">Edit Decisions</a> 
    </div>
    <!--<a href="home.php">Home Page</a> <br />-->
    <div id="container" style="margin-top: 20px; max-height:360px; overflow:auto;"></div>
    
    <div style="display:inline-block;  margin-top:20px; width:auto;">
        Access Decision: 
        <select id="multi_decision">
            <option value="" selected="selected" hidden="hidden">Enter Decision</option>
            <option value="Keep">Keep</option>
            <option value="Revoke">Revoke</option>
            <option value="Delete">Delete</option>
            <option value="Not Aware">Not Aware</option>
        </select>
        <button id="submit_button" style="margin-left:75px;">Update for all shown Accounts</button>
        <div id="message" ></div>
    </div>
    <p>Comment:
        <input id="multi_comments" type="text" size="80" placeholder="Enter Comment"></p>
    <script type="text/javascript">

        //var idArray = new Array();

        var table = new Tabulator("#container", {
            //maxHeight:"100%",
            ajaxURL:"ajaxLoad.php?decision=1",
            layout: "fitColumns",
            placeholder:"Great! No items left for review",
            columns: [
                
                {title: "Application Name", field: "applicationname", sorter: "string", width: 150, headerFilter: "input"}, 
                {title: "Employee ID",field: "employeeid",sorter: "string",hozAlign: "left",headerFilter: "input",},
                {title: "Employee Name",field: "employeename",sorter: "string",hozAlign: "center",}, 
                {title: "Profile/Access Level/Role",field: "rolename",sorter: "string",hozAlign: "center",headerFilter: "input",},
                {title: "Access Decision",field: "accessdecision",hozAlign: "center",editor: "select",editorParams: {"Keep": "Keep","Revoke": "Revoke","Not Aware": "Not Aware","Delete": "Delete"}},
                {title: "Comments",field: "comments",hozAlign: "center",editor: "input",},
                
            ],

            cellEdited: function (cell) {
                // This callback is called any time a cell is edited.
                var val = cell.getData();
                var dif;
                if( cell.getField() == "accessdecision"){
                    dif = "ad";
                    val = val['accessdecision'];
                }
                else{
                    dif = "com";
                    val = val['comments'];
                }

                $.ajax({

                    url: 'ajaxEdit.php',
                    data: { 'dif': dif, 'val': val, 'id': cell.getRow().getIndex() },
                    type: 'post'

                })
            },

        });

        $("#submit_button").click(function(){

            if( $("#multi_decision").val()=='' ){
                $('#message').css({ 'color': 'red',
                                    'display' : 'inline-block',
                                    'margin-left' : '75px',
                                    'width' : 'auto'});
                $('#message').text("Decision is required");
                $('#message').fadeIn('slow', function(){
                    $('#message').delay(2000).fadeOut(); 
                });
            }
            else{
                var filteredIds = new Array();
                var filteredIds = table.getData('active').map(i => i.id);
                var decision = $("#multi_decision").val();
                var comments = $("#multi_comments").val();
                console.log(filteredIds);
                $.ajax({

                        url: 'ajaxMultiEdit.php',
                        data: { 'idarray': filteredIds, 'accessdecision': decision, 'comments' : comments },
                        type: 'post'

                        });
                $("#multi_decision").val('');
                $("#multi_comments").val('');

                $('#message').css({ 'color': 'green',
                                    'display' : 'inline-block',
                                    'margin-left' : '75px',
                                    'width' : 'auto'});
                $('#message').text("Decisions updated");
                $('#message').fadeIn('slow', function(){
                    $('#message').delay(2000).fadeOut(); 
                });
            }

        });
        //$(document).ready(function() {
        //
        //    $.ajax({
        //
        //        url: 'ajaxLoad.php?decision=1',
        //        //data: { 'dif': dif, 'val': val, 'id': cell.getIndex() },
        //        type: 'get',
        //        success: function(response) {
        //            console.log(response);
        //            table.setData(response);
        //        }
        //                
        //    });
        //    
        //});

    </script>
</body>
</html>




