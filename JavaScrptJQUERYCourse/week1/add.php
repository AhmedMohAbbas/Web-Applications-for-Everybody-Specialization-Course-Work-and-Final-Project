<?php
session_start();
require_once "DBcredt.php";

if (!isset($_SESSION['login'])) {
        die("ACCESS DENIED");
    } else if (isset($_POST['cancel'])) {
        header('Location: index.php');
        return ;
    } else {
        if (isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['email']) and isset($_POST['headline']) and isset($_POST['summary'])) {
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $headline = $_POST['headline'];
            $summary = $_POST['summary'];

            if ($firstName == "" or $lastName == "" or $email == "" or $headline == "" or $summary == "") {
                $_SESSION['error'] = "All fields are required";
                header("Location: add.php");
                return ;
            } else {
                if (strpos($email, '@') == false) {
                    $_SESSION['error'] = "Email address must contain @";
                    header("Location: add.php");
                    return ;
                } else {
                    $stmt = $DBh->prepare('INSERT INTO Profile
                                        (user_id, first_name, last_name, email, headline, summary) VALUES (:userId, :firstName, :lastName, :email, :headline, :summary)');
                    $stmt->execute(array(':userId' => $_SESSION['user_id'],
                                         ':firstName' => $firstName,
                                         ':lastName' => $lastName,
                                         ':email' => $email,
                                         ':headline' => $headline,
                                         ':summary' => $summary)
                                        );

                    $_SESSION['success'] = "Profile added.";
                    header("Location: index.php");
                    return ;
                }
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
   <?php require_once "bootstrap2.php"; ?>
   <title>Ahmed Mohamed Abbas</title>
</head>


<body class="container">

   <header>
       <h1>
           Adding Profile for
                <?php
                    echo htmlentities($_SESSION['name']);
                ?>
        </h1>

       <?php
           if (isset($_SESSION['error'])) {
               echo('<p class="warn">'.$_SESSION['error']."</p>");
               unset($_SESSION['error']);
           }
       ?>
   </header>

   <main>
       <form method="post">
                <p>First Name:
                    <input type="text" name="first_name" size="60"/>
                </p>

                <p>Last Name:
                    <input type="text" name="last_name" size="60"/>
                </p>

                <p>
                    Email:
                    <input type="text" name="email" size="30"/>
                </p>

                <p>
                    Headline:<br/>
                    <input type="text" name="headline" size="80"/>
                </p>

                <p>
                    Summary:<br/>
                    <textarea name="summary" rows="8" cols="80"></textarea>
                <p>
                    <input type="submit" value="Add">
                    <input type="submit" name="cancel" value="Cancel">
                </p>
            </form>
   </main>

</body>

</html>
