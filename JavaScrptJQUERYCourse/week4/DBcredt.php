<?php

$DBh = new PDO('mysql:host=localhost;port=3306;dbname=AssignmentI',
   'Ahmed', 'DAKKA');
$DBh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
