<?php
require_once "pdo.php";
session_start();

$stmt = $pdo->prepare('UPDATE access_review SET accessdecision=:ad, comments=:com 
                        WHERE accessdecision IS NOT NULL AND
                            id IN (' . implode(',', array_map('intval', $array)) . ') 
                            ');
                $stmt->execute(array(
                    ':ad' => $_POST['accessdecision'],
                    ':com' => $_POST['comment'],
                    )
                );

?>