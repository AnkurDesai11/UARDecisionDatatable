
<?php
require_once "pdo.php";
session_start();

if( $_GET['decision'] == 1 ){    
    $stmt = $pdo->prepare("SELECT id, applicationname, employeeid, employeename, accessdecision, comments
                         FROM access_review where ( manageremail = :em and accessdecision IS NULL ) ");
    $stmt -> execute(array(":em" => $_SESSION['email']));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else{
    $stmt = $pdo->prepare("SELECT id, applicationname, employeeid, employeename, accessdecision, comments
                         FROM access_review where ( manageremail = :em and accessdecision IS NOT NULL ) ");
    $stmt -> execute(array(":em" => $_SESSION['email']));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//console.log($rows);
echo(json_encode($rows));

?>