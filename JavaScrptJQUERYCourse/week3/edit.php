<?php
require_once "DBcredt.php";
require_once "util.php";
session_start();

if (!isset($_SESSION['login'])) {
        die("ACCESS DENIED");
    }

$stmt = $DBh->prepare('SELECT * FROM Profile WHERE profile_id = :profile_id');
$stmt->execute(array(':profile_id' => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row == false) {
    $_SESSION['error'] = "Could not load profile";
    header("Location: index.php");
    return ;
} else {
    if (isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['email']) and isset($_POST['headline']) and isset($_POST['summary'])) {

        $msg = ValidatingInput();
        if( is_string($msg) ){
            $_SESSION['error'] = $msg;
            header("Location: edit.php?profile_id=".$_GET['profile_id']);
            return ;
        }

        $msg = validatePos();
        if( is_string($msg) ){
            $_SESSION['error'] = $msg;
            header("Location: edit.php?profile_id=".$_GET['profile_id']);
            return ;
        }

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $headline = $_POST['headline'];
        $summary = $_POST['summary'];

        $stmt = $DBh->prepare('UPDATE Profile
                               SET first_name = :firstName, last_name = :lastName, email = :email, headline = :headline, summary = :summary
                               WHERE profile_id = :profile_id');
        $stmt->execute(array(':firstName' => $firstName,
                            ':lastName' => $lastName,
                            ':email' => $email,
                            ':headline' => $headline,
                            ':summary' => $summary,
                            'profile_id' => $_GET['profile_id']) );




        $stmt2 =  $DBh->prepare('DELETE FROM position WHERE profile_id= :profile_id');
        $stmt2->execute(array(':profile_id' => $_GET['profile_id']));

        $rank = 1;
        for($i=1; $i<=9; $i++) {
            if ( ! isset($_POST['year'.$i]) ) continue;
            if ( ! isset($_POST['desc'.$i]) ) continue;
            $year = $_POST['year'.$i];
            $desc = $_POST['desc'.$i];
            $stmt = $DBh->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES ( :pid, :rnk, :yer, :dsc)');
            $stmt->execute(array(
            ':pid' =>  $_GET['profile_id'],
            ':rnk' => $rank,
            ':yer' => $year,
            ':dsc' => $desc)
            );

            $rank++;
        }

        header("Location: index.php");
        return ;



    }

    $stmt_retrieve = $DBh->prepare('SELECT users.name
                                    FROM users, Profile
                                    WHERE Profile.profile_id = :profile_id AND
                                          Profile.user_id = users.user_id');
    $stmt_retrieve->execute(array(':profile_id' => $_GET['profile_id']));
    $row_retrieve = $stmt_retrieve->fetch(PDO::FETCH_ASSOC);


    $stmtPos = $DBh->prepare('SELECT * FROM position WHERE profile_id = :x ORDER BY rank');
    $stmtPos->execute(array(':x' => $_GET['profile_id'] ));
    $positions = array();
    while( $rowPos = $stmtPos->fetch(PDO::FETCH_ASSOC) ){
        $positions[] = $rowPos;
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
	<header><h1>Editing Profile for user: <?= htmlentities($row_retrieve['name'])?>
            </h1>
            <?php
                flashs();
            ?>
    </header>
	<main>
        <form method="post">
            <label for="101">First Name:</label>
             <input type="text" name="first_name" size="60" id="101" value = "<?= htmlentities($row['first_name'])?>"> <br>
            <label for="202">Last Name:</label>
            <input type="text" name="last_name" size="60" id="202" value = "<?= htmlentities($row['last_name'])?>"> <br>
            <label for="203">Your Email:    </label>
            <input type="text" name="email" size="30" id="203" value = "<?= htmlentities($row['email'])?>"> <br>
            <label for="204">Head line:</label>
            <input type="text" name="headline" size="80" id="204" value="<?= htmlentities($row['headline'])?>"> <br>
            <label for="205">Summary:</label><br>
            <textarea id="205" name="summary" rows="8" cols="80"><?= htmlentities($row['summary'])?></textarea> <br>
            <p>
                Position: <input type="submit" id="addPos" value="+">
                <div id="Position_fields">
                    <?php
                    $pos = 0;
                    foreach ($positions as $position) {
                        $pos++;
                        $v = htmlentities($position['description']);
                        $y = htmlentities($position['year']);
                        echo '<div id="position'.$pos.'">
                                    <p>Year: <input type="text" name="year'.$pos.'" value="'.$y.'" />
                                    <input type="button" value="-"
                                        onclick="$(\'#position'.$pos.'\').remove();return false;"></p>
                                    <textarea name="desc'.$pos.'" rows="8" cols="80">'.$v.'</textarea>
                                    </div>';
                    }
                    ?>
                </div>
            </p>
            <input type="submit" value="Save">
            <a href="index.php">Cancel</a>
        </form>
    </main>
	<footer>
        <script>

             countPos = <?= $pos ?>;
             $(document).ready(function(){
                 window.console && console.log('Document ready called');
                 $('#addPos').click(function(event){
                     event.preventDefault();
                     if (countPos >= 9){
                         alert('Max of 9 intries exceeded')
                         return;
                     }
                     countPos++;
                     window.console && console.log('Adding Position '+ countPos);
                     $('#Position_fields').append('<div id="position'+countPos+'"> \
                                 <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
                                 <input type="button" value="-" \
                                     onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
                                 <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
                                 </div>');
                     });
             });
        </script>
    </footer>

</body>


</html>
