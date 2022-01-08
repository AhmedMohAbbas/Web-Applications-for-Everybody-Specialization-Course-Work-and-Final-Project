<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ahmed Mohamed Abbas</title>
</head>

<body>
	<header><h1>MD5 Cracker</h1></header>
	<main>
        <p>This application takes an MD5 hash of a 4-digit PIN and attempts to hash all possible 4-digit PIN combinations
        to determine the original PIN.</p>
<pre>
Debug Output:
<?php
$x = "Not found";
$show = 15;

if ( isset($_GET['md5']) ) {
    $time_pre = microtime(true);
    $thehash = $_GET['md5'];

    for($i = 0; $i < 10000; $i++){
        $y = hash('MD5', strval($i));
        if($y == $thehash){
            $x = $i;
            break;
        }
        if ( $show > 0 ) {
            print "$thehash $i\n";
            $show = $show - 1;
        }
     }


// Compute elapsed time
$time_post = microtime(true);
print "Elapsed time: ";
print $time_post-$time_pre;
print "\n";
}


?>
</pre>
        <p>The PIN is: <?= htmlentities($x); ?></p>
        			<!-- 
        			Can also work if you just put :-
        				PIN is: <?= $x ?> 
        			But we use htmlentities to prevent HTML injection.	-->
        <form>
            <input type="text" name="md5" size="50"/>
            <input type="submit" value="Crack MD5"/>
        </form>
    </main>
	<footer>
        <ul>
        <li><a href="index.php">Reset</a></li>
        <li><a href="md5.php">MD5 Encoder</a></li>
        </ul>
    </footer>

</body>


</html>
