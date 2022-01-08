<?php
session_start();
if(! isset($_SESSION['email']) || strlen($_SESSION['email']) < 1){
    echo '<a href="login.php">login page</a><br>';
    die("Not logged in");
}


require_once "DBcredt.php";

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
           <?= htmlentities($_SESSION['email'])?>
       </h1>
       <?php
           if(isset($_SESSION['success'])){
               echo('<p class="msga">'.$_SESSION['success']."</p>");
               unset($_SESSION['success']);
           }
       ?>
   </header>

   <main>

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
       <p>
               <a href="add.php">Add New</a> |
               <a href="logout.php">Logout</a>
       </p>
   </footer>

   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>
