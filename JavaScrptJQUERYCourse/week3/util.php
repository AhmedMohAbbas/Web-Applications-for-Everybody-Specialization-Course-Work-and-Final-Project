<?php


function validatePos() {
  for($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['year'.$i]) ) continue;
    if ( ! isset($_POST['desc'.$i]) ) continue;

    $year = $_POST['year'.$i];
    $desc = $_POST['desc'.$i];

    if ( strlen($year) == 0 || strlen($desc) == 0 ) {
      return "All fields are required";
    }

    if ( ! is_numeric($year) ) {
      return "Year must be numeric";
    }
  }
  return true;
}




function flashs(){
    if (isset($_SESSION['error'])) {
        echo('<p class="warn">'.$_SESSION['error']."</p>");
        unset($_SESSION['error']);
    }

    if ( isset($_SESSION["success"]) ) {
        echo('<p class="msga">'.$_SESSION["success"]."</p>");
        unset($_SESSION["success"]);
    }
}


function ValidatingInput(){
    if( strlen($_POST['first_name']) == 0 || strlen($_POST['last_name']) == 0 || strlen($_POST['email']) == 0 || strlen($_POST['headline']) == 0 || strlen($_POST['summary']) == 0 ){
        return 'All fields are required';
    }


    if(strpos($_POST['email'], '@') === false){
        return 'Email address must contain @';
    }

    return true;
}
