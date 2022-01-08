<?php
    session_start();
    require_once "DBcredt.php";

    $stmt = $DBh->prepare('SELECT first_name, last_name, email, headline, summary
                        FROM Profile
                        WHERE profile_id = :profile_id');
    $stmt->execute(array(':profile_id' => $_GET['profile_id']));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row == false) {
        $_SESSION['error'] = "Could not load profile";
        header("Location: index.php");
        return ;
    }

    $stmtPos = $DBh->prepare('SELECT * FROM position WHERE profile_id = :x ORDER BY rank');
    $stmtPos->execute(array(':x' => $_GET['profile_id'] ));
    $positions = array();
    while( $rowPos = $stmtPos->fetch(PDO::FETCH_ASSOC) ){
        $positions[] = $rowPos;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php require_once "bootstrap2.php"; ?>
        <title>Ahmed Mohamed Abbas</title>
    </head>

    <body class="container">
            <h1>Profile information</h1>
            <p>
                First Name: <?php echo $row['first_name'] ?>
            </p>

            <p>
                Last Name: <?php echo $row['last_name'] ?>
            </p>

            <p>
                Email: <?php echo $row['email'] ?>
            </p>

            <p>
                Headline: <br/>
                <?php echo $row['headline'] ?>
            </p>

            <p>
                Summary:<br/>
                <?php echo $row['summary'] ?>
            </p>

            <p>Position</p>
            <ul>
                <?php
                foreach ($positions as $position) {
                    $y = htmlentities($position['year']);
                    $des = htmlentities($position['description']);
                    echo '<li>'.$y.': '.$des.'</li>';
                }
                ?>
            </ul>

            <a href="index.php">Done</a>
    </body>
</html>
