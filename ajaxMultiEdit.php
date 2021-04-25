<?php
require_once "pdo.php";
session_start();

$stmt = $pdo->prepare('UPDATE access_review SET accessdecision=:ad, comments=:com 
                        WHERE manageremail = :em AND 
                            accessdecision IS NOT NULL AND
                            id IN (' . implode(',', array_map('intval', $array)) . ') 
                            ');
                $stmt->execute(array(
                    ':ad' => $_POST['accessdecision'],
                    ':com' => $_POST['comment'],
                    ':em' => $_SESSION['email']
                    )
                );

?>