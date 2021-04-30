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

    <h1> Edit your Decisions for User Access Review here </h1>
    <p> Please edit your previously entered decision and comments if necessary for the accounts of users assigned to you for the review
        Refresh the page periodically to ensure that updated decisions are recorded
    </p> 
    <div style="display:inline-block;" >
        <a href='logout.php' >Logout</a>
        <a href="editDecision.php" style="margin-left:50px;">Refresh Page</a> 
        <a href="enterDecision.php" style="margin-left:50px;">Enter Decisions</a>
        <div style="margin-left:75px;display:inline-block;">Single Update Status: </div>
        <div id="single_message" ></div> 
    </div>
    <!--<a href="home.php">Home Page</a> <br />-->
    <div id="container" style="margin-top: 10px; max-height:360px; overflow:auto;"></div>
    
    <div style="display:inline-block;  margin-top:20px; width:auto;">
        Access Decision: 
        <select id="multi_decision">
            <option value="" selected="selected" hidden="hidden">Enter Decision</option>
            <option value="Keep">Keep</option>
            <option value="Revoke">Revoke</option>
            <option value="Delete">Delete</option>
            <option value="Not Aware">Not Aware</option>
        </select>
        <button id="submit_button" style="margin-left:40px;">Update for all shown Accounts</button>
        <div style="margin-left:30px;display:inline-block;">Multiple Update Status: </div>
        <div id="multi_message" ></div>
    </div>
    <p>Comment:
        <input id="multi_comments" type="text" size="60" placeholder="Enter Comment"></p>
    <script type="text/javascript">

        //var idArray = new Array();

        var table = new Tabulator("#container", {
            //maxHeight:"100%",
            ajaxURL:"ajaxLoad.php?decision=2",
            layout: "fitColumns",
            placeholder:"Please enter decisions and comments before you can edit them",
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
                var app = cell.getData()['applicationname'];
                var eid = cell.getData()['employeeid'];
                var role = cell.getData()['rolename'];
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
                    type: 'post',
                    success: function(message) {

                        if( message == 0 ){
                            $('#single_message').css({ 'color': 'red',
                                    'display' : 'inline-block',
                                    'margin-left' : '30px',
                                    'width' : 'auto'});
                            $('#single_message').text("Update Access Decision before updating Comments for ID "+eid+" role "+role+" in application "+app);
                            $('#single_message').fadeIn('fast', function(){
                                $('#single_message').delay(5000).fadeOut(); 
                            });
                        }
                        else if( message == 1 ){
                            $('#single_message').css({ 'color': 'green',
                                    'display' : 'inline-block',
                                    'margin-left' : '30px',
                                    'width' : 'auto'});
                            $('#single_message').text("Access Decision updated for  ID "+eid+" role "+role+" in application "+app);
                            $('#single_message').fadeIn('fast', function(){
                                $('#single_message').delay(5000).fadeOut(); 
                            });
                        }
                        else if( message == 2 ){
                            $('#single_message').css({ 'color': 'green',
                                    'display' : 'inline-block',
                                    'margin-left' : '30px',
                                    'width' : 'auto'});
                            $('#single_message').text("Comments updated for ID "+eid+" role "+role+" in application "+app);
                            $('#single_message').fadeIn('fast', function(){
                                $('#single_message').delay(5000).fadeOut(); 
                            });
                        }
                        else{
                            $('#single_message').css({ 'color': 'red',
                                    'display' : 'inline-block',
                                    'margin-left' : '30px',
                                    'width' : 'auto'});
                            $('#single_message').text("Server Error for ID "+eid+" role "+role+" in application "+app);
                            $('#single_message').fadeIn('fast', function(){
                                $('#single_message').delay(5000).fadeOut(); 
                            });
                        }

                    }

                })
            },

        });

        $("#submit_button").click(function(){

            if( $("#multi_decision").val()=='' ){
                $('#multi_message').css({ 'color': 'red',
                                    'display' : 'inline-block',
                                    'margin-left' : '20px',
                                    'width' : 'auto'});
                $('#multi_message').text("Decision is required");
                $('#multi_message').fadeIn('fast', function(){
                    $('#multi_message').delay(5000).fadeOut(); 
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
                        type: 'post',
                        success: function(message) {
                            $('#multi_message').css({ 'color': 'green',
                                    'display' : 'inline-block',
                                    'margin-left' : '20px',
                                    'width' : 'auto'});
                            $('#multi_message').text(message);
                            $('#multi_message').fadeIn('fast', function(){
                                $('#multi_message').delay(5000).fadeOut(); 
                            });
                        },
                        
                });

                
                $("#multi_decision").val('');
                $("#multi_comments").val('');

                
            }

        });

    </script>
</body>
</html>
