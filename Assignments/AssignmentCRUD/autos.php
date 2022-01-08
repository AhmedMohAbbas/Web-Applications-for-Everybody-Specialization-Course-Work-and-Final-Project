<?php
if(! isset($_GET["name"]) || strlen($_GET["name"]) < 1){
    echo '<a href="login.php">login page</a><br>';
    die("Name parameter missing, Please sign in....");
}

if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return false;
}

require_once "DBcredt.php";

$failmsg = false;
$sucmsg = false;

if( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ){

    if(strlen($_POST["make"]) < 1 || strlen($_POST["year"]) < 1 || strlen($_POST["mileage"]) < 1){
        $failmsg = "Make is required";
    }elseif(is_numeric($_POST["year"]) === false || is_numeric($_POST["mileage"]) === false ){
        $failmsg = "Mileage and Year must be Numeric data";
    }else{
        $sqlcmnd = $DBh->prepare('INSERT INTO autos (make,year,mileage) VALUES (:x,:y,:z)');
        $sqlcmnd->execute(array('x' => $_POST['make'], 'y' => $_POST['year'], 'z' => $_POST['mileage'] ));
        $sucmsg = "Record Inserted";
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
   <?php require_once "bootstrap1.php"; ?>
   <title>Ahmed Mohamed Abbas d9f1f4dc</title>
</head>


<body class="container">

   <header>
       <h1>
           Tracking Autos for<br>
           <?= htmlentities($_GET["name"])?>
       </h1>

       <?php
           if ($failmsg !== false) {
               echo('<p class="warn">'.$failmsg."</p>");
           }
           if($sucmsg !== false){
               echo('<p class="msga">'.$sucmsg."</p>");
           }
       ?>
   </header>

   <main>
       <form method="post">
           <label for="brand">The Make</label>
           <input type="text" name="make" id="brand"><br/>
           <label for="year">The Year</label>
           <input type="text" name="year" id="year"><br/>
           <label for="miles">The Mileage</label>
           <input type="text" name="mileage" id="miles"><br/>
           <input type="submit" value="Add">
           <input type="submit" name="logout" value="Logout">
       </form>

       <h2>Automobiles</h2>
       <?php
       $data = $DBh->query('SELECT * FROM autos ORDER BY make');
       echo "<ul>";
       while( $row = $data->fetch(PDO::FETCH_ASSOC) ){
           echo "<li>".htmlentities($row['year'])." ".htmlentities($row['make'])."/".htmlentities($row['mileage'])."</li>";
       }
       echo "<ul>";
       ?>

   </main>

   <footer>
   </footer>

   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>
