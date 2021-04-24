<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['email']) && isset($_POST['pass']) ) {

    $stmt = $pdo->prepare('SELECT user_id, name FROM users
            WHERE email = :em AND password = :pw');
    $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $_POST['pass']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //var_dump($row);
    if ( $row === FALSE ) {
        $_SESSION['error'] = "Invalid Email and Password combination";
        error_log("Login failed as password is incorrect for ".$_POST['email']);
        header("Location: index.php");
        return;
    } else { 
        $_SESSION['success'] = "Login success";
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        error_log("Login successful");
        header("Location: enter.php");
        return;
    }
    //}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>User Access Review</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
    if( isset($_SESSION['error']) ){
        echo("<p style='color:red'>".$_SESSION['error']."</p>\n");
        unset($_SESSION['error']);
    }
    if( isset($_SESSION['success']) ){
        echo("<p style='color:green'>".$_SESSION['success']."</p>\n");
        unset($_SESSION['success']);
    }
?>
<form method="post">
<label for="email">Email</label>
<input type="text" size="40" name="email" id="email"><br>
<label for="id_1723">Password</label>
<input type="password" size="40" name="pass" id="id_1723"><br>
<p><input type="submit", value="Log In"/> 
<!--<a href="<?php //echo($_SERVER['PHP_SELF']);?>">Refresh</a>
<a href="index.php">Start Page</a></p>-->
</form>
<!--<script>
function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('id_1723').value;
        console.log("Validating addr = "+ addr +" pw = "+pw);
        if (addr == null || addr == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if( addr.indexOf('@') == -1 ){
            alert("Invalid Email address-No @ sign");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>-->
</div>
</body>
</html>