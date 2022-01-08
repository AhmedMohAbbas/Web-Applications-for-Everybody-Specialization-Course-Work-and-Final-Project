<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ahmed Mohamed Abbas 59b6b458</title>
</head>

<body>
	<header>
		<h1>Welcome to my Guessing game</h1>
	</header>
	<main>
		<?php
        if ( ! isset($_GET['guess']) ) {
            echo("Missing guess parameter");
        } else if ( strlen($_GET['guess']) < 1 ) {
            echo("Your guess is too short");
        } else if ( ! is_numeric($_GET['guess']) ) {
            echo("Your guess is not a number");
        } else if ( $_GET['guess'] < 38 ) {
            echo("Your guess is too low");
        } else if ( $_GET['guess'] > 38 ) {
            echo("Your guess is too high");
        } else {
            echo("Congratulations - You are right");
        }
        ?>
	</main>
	<footer></footer>

</body>


</html>
