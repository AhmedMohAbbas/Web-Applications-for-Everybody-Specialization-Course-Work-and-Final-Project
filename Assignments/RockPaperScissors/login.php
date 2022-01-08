<?php
if( isset($_POST["cancel"]) ) {
    header("location: index.php");
    return false;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
$failure = false;

if( isset($_POST["who"]) && isset($_POST["pass"])){
    if( strlen($_POST["who"]) < 1 || strlen($_POST["pass"]) < 1 ){
        $failure = "User name and password are required";
    }else{
        $x = hash('md5', $salt.$_POST["pass"]);
        if($x == $stored_hash){
            header("location: game.php?name=".urlencode($_POST["who"]));
            return;
        }else{
            $failure = "Incorrect password";
        }
    }
}


 ?>



 <!DOCTYPE html>
 <html lang="en">


 <head>
 	<meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <?php require_once "bootstrap.php"; ?>
 	<title>Ahmed Mohamed Abbas d9f1f4dc</title>
 </head>


 <body class="container">

 	<header>
        <h1>Please Log In</h1>
        <?php
            if ($failure !== false) {
                echo('<p class="warn">'.htmlentities($failure)."</p>");
            }
        ?>
    </header>

 	<main>
        <form method="POST">
        <label for="nam">User Name</label>
        <input type="text" name="who" id="nam"><br/>
        <label for="id_1723">Password</label>
        <input type="text" name="pass" id="id_1723"><br/>
        <input type="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
</form>
    </main>

 	<footer>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

 </body>

 </html>
