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

function validateEdu(){
    for($i=1; $i<=9; $i++) {
      if ( ! isset($_POST['edu_year'.$i]) ) continue;
      if ( ! isset($_POST['institute'.$i]) ) continue;

      $year = $_POST['edu_year'.$i];
      $institute = $_POST['institute'.$i];

      if ( strlen($year) == 0 || strlen($institute) == 0 ) {
        return "All fields are required";
      }

      if ( ! is_numeric($year) ) {
        return "Year must be numeric";
      }
    }
    return true;
}

function addPositions($profile_id){
    global $DBh;
    $rank = 1;
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];
        $stmt = $DBh->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES ( :pid, :rnk, :yer, :dsc)');
        $stmt->execute(array(
        ':pid' =>  $profile_id,
        ':rnk' => $rank,
        ':yer' => $year,
        ':dsc' => $desc)
        );

        $rank++;
    }
}


function addEducation($profile_id){
    global $DBh;
    $rank = 1;
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['edu_year'.$i]) ) continue;
        if ( ! isset($_POST['institute'.$i]) ) continue;
        $year = $_POST['edu_year'.$i];
        $institute = $_POST['institute'.$i];

        $institution_id = false;
        $stmt = $DBh->prepare('SELECT institution_id FROM institution WHERE name = :a');
        $stmt->execute( array(':a' => $institute) );
        $rowi = $stmt->fetch(PDO::FETCH_ASSOC);
        if( $rowi !== false ){$institution_id = $rowi['institution_id'];}

        if($institution_id === false){
            $stmt2 = $DBh->prepare('INSERT INTO institution (name) VALUES (:na)');
            $stmt2->execute(array(':na'=> $institute ));
            $institution_id = $DBh->lastInsertId();
        }

        $stmt3 = $DBh->prepare('INSERT INTO education (profile_id, rank, year, institution_id) VALUES ( :pid, :rnk, :yer, :inst)');
        $stmt3->execute(array(
        ':pid' =>  $profile_id,
        ':inst' => $institution_id,
        ':rnk' => $rank,
        ':yer' => $year)
        );

        $rank++;
    }
}
