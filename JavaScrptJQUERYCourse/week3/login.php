<?php
session_start();
require_once "DBcredt.php";
require_once "util.php";

if( isset($_POST["cancel"]) ) {
    session_destroy();
    header("location: index.php");
    return false;
}

if (isset($_POST['email']) and isset($_POST['pass'])) {
        $user = $_POST['email'];
        $pass = $_POST['pass'];
        $salt = "XyZzy12*_";

        $check = hash('md5', $salt.$_POST['pass']);
        $stmt = $DBh->prepare('SELECT user_id, name
                               FROM users
                               WHERE email = :em AND password = :pw');
        $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row == false) {
            $_SESSION["error"] = "Incorrect Password \n";
            error_log("Login fail " .$_POST['name']. $check);
            header("Location: login.php");
            return ;
        } else {
            error_log("Login success ".$user);
            $_SESSION["success"] = "Login success";
            $_SESSION['name'] = $row['name'];
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: index.php");
            return ;
        }
    }
?>



 <!DOCTYPE html>
 <html lang="en">


 <head>
 	<meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require_once "bootstrap2.php"; ?>
 	<title>Ahmed Mohamed Abbas</title>
 </head>


 <body class="container">

 	<header>
        <h1>Please Log In</h1>
        <?php
            flashs();
        ?>
    </header>

 	<main>
        <form method="POST">
                <label for="email">Email</label>
                <input type="text" name="email" id="email"/><br/>
                <label for="id_1723">Password</label>
                <input type="password" name="pass" id="id_1723"/><br/>
                <input type="submit" onclick="return doValidate();" value="Log In">
                <input type="submit" name = "cancel" value="Cancel">
        </form>
    </main>

 	<footer>
        <script>
                function doValidate() {
                    console.log('Validating...');
                    try {
                        addr = document.getElementById('email').value;
                        pw = document.getElementById('id_1723').value;
                        console.log("Validating addr="+addr+" pw="+pw);
                        if (addr == null || addr == "" || pw == null || pw == "") {
                            alert("Both fields must be filled out");
                            return false;
                        }
                        if ( addr.indexOf('@') == -1 ) {
                            alert("Invalid email address");
                            return false;
                        }
                        return true;
                    } catch(e) {
                        return false;
                    }
                    return false;
                }
            </script>
    </footer>

 </body>

 </html>
