<?php
session_start();
require_once "DBcredt.php";
require_once "util.php";

if (!isset($_SESSION['login'])) {
        die("ACCESS DENIED");
}

if (isset($_POST['cancel'])) {
        header('Location: index.php');
        return ;
}

if (isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['email']) and isset($_POST['headline']) and isset($_POST['summary'])) {
    //Validating incoming data
    $msg = ValidatingInput();
    if( is_string($msg) ){
        $_SESSION['error'] = $msg;
        header("Location: add.php");
        return ;
    }

    // Validating any position data that could be present "if any are anyways"
    $msg = validatePos();
    if( is_string($msg) ){
        $_SESSION['error'] = $msg;
        header("Location: add.php");
        return ;
    }




    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $headline = $_POST['headline'];
    $summary = $_POST['summary'];

    $stmt = $DBh->prepare('INSERT INTO Profile
    (user_id, first_name, last_name, email, headline, summary) VALUES (:userId, :firstName, :lastName, :email, :headline, :summary)');
    $stmt->execute(array(':userId' => $_SESSION['user_id'],
    ':firstName' => $firstName,
    ':lastName' => $lastName,
    ':email' => $email,
    ':headline' => $headline,
    ':summary' => $summary)
    );

    $profile_id = $DBh->lastInsertId();
    $rank = 1;

    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];

        $stmt = $DBh->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES ( :pid, :rnk, :yer, :dsc)');

        $stmt->execute(array(
        ':pid' => $profile_id,
        ':rnk' => $rank,
        ':yer' => $year,
        ':dsc' => $desc)
        );

        $rank++;
    }



    $_SESSION['success'] = "Profile added.";
    header("Location: index.php");
    return ;

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
            flashs();
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
                </p>

                <p>
                    Position: <input type="submit" id="addPos" value="+">
                    <div id="Position_fields"></div>
                </p>


                <p>
                    <input type="submit" value="Add">
                    <input type="submit" name="cancel" value="Cancel">
                </p>
            </form>
   </main>
   <script>

        countPos = 0;
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

</body>

</html>
