
<?php
require_once "pdo.php";
session_start();

$rows = array();

if( $_GET['decision'] == 1 ){    
    
    $stmt = $pdo->prepare("SELECT id, applicationname, employeeid, employeename, rolename, accessdecision, comments
                         FROM access_review where ( manageremail = :em and accessdecision IS NULL ) ");
    $stmt -> execute(array(":em" => $_SESSION['email']));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //print_r($rows);
}
else{
    
    $stmt = $pdo->prepare("SELECT id, applicationname, employeeid, employeename, rolename, accessdecision, comments
                         FROM access_review where ( manageremail = :em and accessdecision IS NOT NULL ) ");
    $stmt -> execute(array(":em" => $_SESSION['email']));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

//$result = array();
//
//foreach ( $rows as $row ){
//
//   $id = $row['id'];
//    $applicationname = $row['applicationname'];
//    $employeeid = $row['employeeid'];
//    $employeename = $row['employeename'];
//    $role = $row['role'];
//    $accessdecision = $row['accessdecision'];
//    $comments = $row['comments'];
//
//    $result[] = array(
//                    "id" => $id,
//                    "applicationname" => $applicationname,
//                    "employeeid" => $employeeid,
//                    "employeename" => $employeename,
//                    "role" => $role,
//                    "accessdecision" => $accessdecision,
//                    "comments" => $comments,
//                );
//
//}

//console.log(json_encode($rows, JSON_NUMERIC_CHECK));
echo json_encode($rows, JSON_NUMERIC_CHECK);

?>