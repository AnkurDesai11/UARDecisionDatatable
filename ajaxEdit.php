<?php
require_once "pdo.php";
session_start();

if( $_POST['dif'] == "ad"){
    $stmt = $pdo->prepare('UPDATE access_review SET accessdecision=:ad 
                        WHERE manageremail = :em AND 
                            id = :id 
                            ');
                $stmt->execute(array(
                    ':ad' => $_POST['val'],
                    ':id' => $_POST['id'],
                    ':em' => $_SESSION['email']
                    )
                );
}
else{
    $stmt = $pdo->prepare('UPDATE access_review SET comments=:com 
                        WHERE manageremail = :em AND 
                            id = :id 
                            ');
                $stmt->execute(array(
                    ':com' => $_POST['val'],
                    ':id' => $_POST['id'],
                    ':em' => $_SESSION['email']
                    )
                );
}

?>