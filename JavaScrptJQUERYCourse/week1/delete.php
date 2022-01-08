<?php
require_once "DBcredt.php";
session_start();

if (!isset($_SESSION['login'])) {
        die("ACCESS DENIED");
    } else {
        $stmt = $DBh->prepare('SELECT profile_id, first_name, last_name
                               FROM Profile
                               WHERE profile_id = :profile_id');
        $stmt->execute(array(':profile_id' => $_GET['profile_id']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row == false) {
            $_SESSION['error'] = "Could not load profile";
            header("Location: index.php");
            return ;
        }

        if (isset($_POST['delete'])) {
            $stmt = $DBh->prepare('DELETE
                                   FROM Profile
                                   WHERE profile_id = :profile_id');
            $stmt->execute(array(':profile_id' => $_GET["profile_id"]));

            $_SESSION['success'] = "Profile deleted";
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
   <title>Ahmed Mohamed Abbas d9f1f4dc</title>
</head>

    <body class="container">
            <p> <h1>Deleting Profile</h1> </p>
            <p>First Name: <?= htmlentities($row['first_name']) ?></p>
            <p>Second Name: <?= htmlentities($row['last_name']) ?></p>

            <form method="post">
            <input type="submit" value="Delete" name="delete">
            <a href="index.php">Cancel</a>
            </form>

    </body>

 </html>
