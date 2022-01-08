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

    // Validating Education data "basically the same as position"
    $msg = validateEdu();
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

    addPositions($profile_id);
    addEducation($profile_id);




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
   <?php require_once "BootstrapJquery.php"; ?>
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
                    Education: <input type="submit" id="addEdu" value="+">
                    <div id="Education_fields">
                    </div>
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
        countScl = 0;
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

            $('#addEdu').click(function(event){
                event.preventDefault();
                if (countScl >= 9){
                    alert('Max of 9 Education-intries exceeded')
                    return;
                }
                countScl++;
                window.console && console.log('Adding Education '+ countScl);

                var source = $('#edu-template').html();
                $('#Education_fields').append( source.replace( /@COUNT@/g, countScl) );

                $('.school').autocomplete({source: "school.php"});
            });

            $('.school').autocomplete({source: "school.php"});

        });
   </script>

   <script id="edu-template" type="text">
       <div id='education@COUNT@'>
       <p>Year: <input type="text" name="edu_year@COUNT@" value="" />
       <input type="button" value="-"
           onclick="$('#education@COUNT@').remove();return false;"></p>
       <p>School: <input type="text" size="80" name="institute@COUNT@" class="school" value="">
       </p>
       </div>
   </script>

</body>

</html>
