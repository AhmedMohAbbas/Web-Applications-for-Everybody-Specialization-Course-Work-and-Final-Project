<?php
require_once "DBcredt.php";
session_start();

if (!isset($_SESSION['login'])) {
        die("ACCESS DENIED");
    } else {
        $stmt = $DBh->prepare('SELECT *
                               FROM Profile
                               WHERE profile_id = :profile_id');
        $stmt->execute(array(':profile_id' => $_GET['profile_id']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row == false) {
            $_SESSION['error'] = "Could not load profile";
            header("Location: index.php");
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
                    header("Location: edit.php?profile_id=" . $_GET['profile_id']);
                    return ;
                } else {
                    if (strpos($email, '@') == false) {
                        $_SESSION['error'] = "Email address must contain @";
                        header("Location: edit.php?profile_id=" . $_GET['profile_id']);
                        return ;
                    } else {
                        $stmt = $DBh->prepare('UPDATE Profile
                                               SET first_name = :firstName, last_name = :lastName, email = :email, headline = :headline, summary = :summary
                                               WHERE profile_id = :profile_id');
                        $stmt->execute(array(':firstName' => $firstName,
                                            ':lastName' => $lastName,
                                            ':email' => $email,
                                            ':headline' => $headline,
                                            ':summary' => $summary,
                                            'profile_id' => $_GET['profile_id'])
                                        );

                        header("Location: index.php");
                        return ;
                    }
                }
            }
        }

        $stmt_retrieve = $DBh->prepare('SELECT users.name
                                        FROM users, Profile
                                        WHERE Profile.profile_id = :profile_id AND
                                              Profile.user_id = users.user_id');
        $stmt_retrieve->execute(array(':profile_id' => $_GET['profile_id']));
        $row_retrieve = $stmt_retrieve->fetch(PDO::FETCH_ASSOC);
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
	<header><h1>Editing Profile for user: <?= htmlentities($row_retrieve['name'])?>
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
            <label for="101">First Name:</label>
             <input type="text" name="first_name" size="60" id="101" value = "<?= htmlentities($row['first_name'])?>"> <br>
            <label for="202">Last Name:</label>
            <input type="text" name="last_name" size="60" id="202" value = "<?= htmlentities($row['last_name'])?>"> <br>
            <label for="203">Email:</label>
            <input type="text" name="email" size="30" id="203" value = "<?= htmlentities($row['email'])?>"> <br>
            <label for="204">Headline:</label>
            <input type="text" name="headline" size="80" id="204" value="<?= htmlentities($row['headline'])?>"> <br>
            <label for="205">Summary:</label>
            <textarea id="205" name="summary" rows="8" cols="80"><?= htmlentities($row['summary'])?></textarea> <br>
            <input type="submit" value="Save">
            <a href="index.php">Cancel</a>
        </form>
    </main>
	<footer></footer>

</body>


</html>
