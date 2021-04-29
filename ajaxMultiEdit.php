<?php
require_once "pdo.php";
session_start();

$stmt = $pdo->prepare('UPDATE access_review SET accessdecision=:ad, comments=:com 
                        WHERE accessdecision IS NULL AND
                            id IN (' . implode(',', $_POST['idarray']) . ') 
                            ');
                $stmt->execute(array(
                    ':ad'  => $_POST['accessdecision'],
                    ':com' => $_POST['comments'],
                    )
                );

?>