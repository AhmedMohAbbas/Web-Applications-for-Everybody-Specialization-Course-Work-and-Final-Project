<?php
if(! isset($_GET["name"]) || strlen($_GET["name"]) < 1){
    echo '<a href="login.php">login page</a><br>';
    die("Name parameter missing, Please sign in....");
}

if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return false;
}

$names = array('Rock', 'Paper', 'Scissors');
$human = isset($_POST["human"]) ? $_POST["human"]+0 : -1;
$computer = rand(0,2);
#
function check($x, $y){
        if ( $x == $y ) {
            return "Tie";
        } else if (($x == 0 && $y == 2) || ($x == 1 && $y == 0) || ($x == 2 && $y == 1) ) {
            return "You Win";
        } else{
            return "You Lose";
        }
        return false;
}

$result = check($human, $computer);

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
        <h1>Rock Paper Scissors</h1>
        <?php
            if ( isset($_GET['name']) ) {
                echo "<p>Welcome: ";
                echo htmlentities($_GET['name']);
                echo "</p>\n";
            }
        ?>
    </header>

 	<main>
        <form method="post">
            <select name="human">
            <option value="-1">Select</option>
            <option value="0">Rock</option>
            <option value="1">Paper</option>
            <option value="2">Scissors</option>
            <option value="3">Test</option>
            </select>
            <input type="submit" name="Play" value="Play">
            <input type="submit" name="logout" value="Logout">
        </form>
<pre>
<?php
if ( $human == -1 ) {
    print "Please select a strategy and press Play.\n";
} else if ( $human == 3 ) {
    for($c=0;$c<3;$c++) {
        for($h=0;$h<3;$h++) {
            $r = check($h, $c);
            print "Human=$names[$h] Computer=$names[$c] Result=$r\n";
        }
    }
} else {
    print "Your Play=$names[$human] Computer Play=$names[$computer] Result=$result\n";
}
?>
</pre>


    </main>

 	<footer>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

 </body>

 </html>
