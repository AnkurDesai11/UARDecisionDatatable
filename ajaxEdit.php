<?php
require_once "pdo.php";
session_start();

if( $_POST['flagtest'] == "ad"){
    $stmt = $pdo->prepare('UPDATE access_review SET accessdecision=:ad 
                        WHERE manageremail = :em AND 
                            id = :id 
                            ');
                $stmt->execute(array(
                    ':ad' => $_POST['accessdecision'],
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
                    ':com' => $_POST['comments'],
                    ':id' => $_POST['id'],
                    ':em' => $_SESSION['email']
                    )
                );
}

?>