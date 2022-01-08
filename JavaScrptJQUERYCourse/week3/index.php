<?php
session_start();
require_once "DBcredt.php";
require_once "util.php";
$stmt = $DBh->query("SELECT profile_id, first_name, last_name, email, headline, summary FROM Profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <h2>Ahmed Abbas's Resume Registry</h2>

            <?php
                if (! isset($_SESSION['login'])) {
                    echo '<p><a href="login.php">Please log in</a></p><p>Attempt to go to<a href="add.php"> add data</a> without logging in - it should fail with an error message.</p>';

                    if ( $rows != false) {
                        echo "<table border='1'>
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Headline</th>
                                    </tr>
                                    </thead>";

                        foreach ($rows as $row) {
                            echo "<tr><td>";
                            $full_profile_name = $row['first_name'] . " " . $row['last_name'];
                            echo('<a href="view.php?profile_id=' . $row['profile_id'] . '">' . htmlentities($full_profile_name) . '</a>');
                            echo("</td><td>");
                            echo(htmlentities($row['headline']));
                            echo("</td></tr>\n");
                        }
                        echo "</table>";
                    }

                    exit();
                }
            ?>

<?php
    flashs();
?>

            <p>
                <a href="logout.php">Logout</a>
            </p>

            <?php
                if ( $rows != false) {

                    echo "<table border='1'>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Headline</th>
                                    <th>Action</th>
                                </tr>
                                </thead>";

                    foreach ($rows as $row) {
                        echo "<tr><td>";
                        $full_profile_name = $row['first_name'] . " " . $row['last_name'];
                        echo('<a href="view.php?profile_id=' . $row['profile_id'] . '">' . htmlentities($full_profile_name) . '</a>');
                        echo("</td><td>");
                        echo(htmlentities($row['headline']));
                        echo("</td><td>");
                        echo('<a href="edit.php?profile_id=' . $row['profile_id'] . '">Edit</a> / ');
                        echo('<a href="delete.php?profile_id=' . $row['profile_id'] . '">Delete</a>');
                        echo("</td></tr>\n");
                    }
                    echo "</table>";
                }
            ?>

            <p>
                <a href="add.php">Add New Entry</a>
            </p>

    </body>


</html>
