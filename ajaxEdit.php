<?php
require_once "pdo.php";
session_start();

$count = -1;

if( $_POST['dif'] == "ad"){
    $stmt = $pdo->prepare('UPDATE access_review SET accessdecision=:ad 
                        WHERE id = :id 
                            ');
                $stmt->execute(array(
                    ':ad' => $_POST['val'],
                    ':id' => $_POST['id'],
                    )
                );
                $count = $stmt->rowCount();
}
else{
    $stmt = $pdo->prepare('UPDATE access_review SET comments=:com 
                        WHERE accessdecision IS NOT NULL AND id = :id 
                            ');
                $stmt->execute(array(
                    ':com' => $_POST['val'],
                    ':id' => $_POST['id'],
                    )
                );
                $count = $stmt->rowCount();
}

if( $_POST['dif'] == "ad" && $count == 1 ){
    echo 1;//("Access Decision updated for ");
}
else if( $_POST['dif'] == "com" && $count == 1 ){
    echo 2;//("Comments updated for ");
}
else if( $_POST['dif'] == "com" && $count == 0 ){
    echo 0;//("Update Access Decision before updating Comments for ");
}
else{
    echo -1;
}
?>