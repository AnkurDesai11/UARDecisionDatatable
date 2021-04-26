<?php
require_once "pdo.php";
session_start();

if( $_POST['dif'] == "ad"){
    $stmt = $pdo->prepare('UPDATE access_review SET accessdecision=:ad 
                        WHERE  id = :id 
                            ');
                $stmt->execute(array(
                    ':ad' => $_POST['val'],
                    ':id' => $_POST['id'],
                    )
                );
}
else{
    $stmt = $pdo->prepare('UPDATE access_review SET comments=:com 
                        WHERE id = :id 
                            ');
                $stmt->execute(array(
                    ':com' => $_POST['val'],
                    ':id' => $_POST['id'],
                    )
                );
}

?>