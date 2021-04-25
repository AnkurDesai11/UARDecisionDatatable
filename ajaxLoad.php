<?php
require_once "pdo.php";
session_start();

if( $_GET['decision'] == 1 ){    
    $stmt = $pdo->prepare("SELECT id, applicationname, employeeid, employeename, accessdecision, comments
                         FROM access_review where ( manageremail = :em and accessdecision = :ad ) ");
    $stmt -> execute(array(":xyz" => $_SESSION['email'], ":ad" => '' ));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else{
    $stmt = $pdo->prepare("SELECT id, applicationname, employeeid, employeename, accessdecision, comments
                         FROM access_review where ( manageremail = :em and accessdecision != :ad ) ");
    $stmt -> execute(array(":xyz" => $_SESSION['email'], ":ad" => '' ));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo(json_encode($rows));

?>