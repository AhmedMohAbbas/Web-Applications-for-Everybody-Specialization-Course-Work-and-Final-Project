<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ahmed Mohamed Abbas PHP</title>
</head>


<body>
	<header>
		<h1>Ahmed Mohamed Abbas first PHP</h1>
	</header>


	<main>
		<pre>ASCII ART:

         ********
        ****  ****
       ****    ****
      **************
     ****        ****
    ****          ****
</pre>
    <p>
      <?php
        print hash('sha256', 'Ahmed Mohamed Abbas');
       ?>
    </p>

	</main>


	<footer>
		<a href="check.php">Click here to check the error setting</a>
    <br>
    <a href="fail.php">Click here to cause a traceback</a>
	</footer>

</body>


</html>
