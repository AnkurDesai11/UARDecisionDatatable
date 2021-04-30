
<?php
require_once "pdo.php";
session_start();

$rows = array();

if( $_GET['decision'] == 1 ){    
    
    $stmt = $pdo->prepare("SELECT id, applicationname, employeeid, employeename, rolename, accessdecision, comments
                         FROM access_review where ( manageremail = :em and ( accessdecision IS NULL or accessdecision = '' ) )");
    $stmt -> execute(array(":em" => $_SESSION['email']));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //print_r($rows);
}
else{
    
    $stmt = $pdo->prepare("SELECT id, applicationname, employeeid, employeename, rolename, accessdecision, comments
                         FROM access_review where ( manageremail = :em and ( accessdecision IS NOT NULL or accessdecision != '' ) ) ");
    $stmt -> execute(array(":em" => $_SESSION['email']));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

}


//console.log(json_encode($rows, JSON_NUMERIC_CHECK));
echo json_encode($rows, JSON_NUMERIC_CHECK);

?>