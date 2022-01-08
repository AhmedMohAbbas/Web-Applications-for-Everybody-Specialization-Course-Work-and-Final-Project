<?php

if(! isset($_GET['term'])) { die('Missing required Parameters...'); }

if(! isset($_COOKIE[session_name()]) ){ die('Must be logged in...'); }
session_start();

if(! isset($_SESSION['user_id']) ){ die('ACCESS DENIED, Please log in...'); }

require_once "DBcredt.php";

header('Content-type: application/json; charset=utf-8');

$x = $_GET['term'];
error_log('Looking up typehead: '.$x);

$stmt = $DBh->prepare('SELECT name FROM institution WHERE name LIKE :y');
$stmt->execute(array(':y'=> $x."%"));

$retval = array();
while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    $retval[] = $row['name'];
}
echo( json_encode($retval) );
