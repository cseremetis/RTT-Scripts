<?php
    /*Template name: tutorTest*/
    include 'config.php';
    include 'user.php';
    session_start();
    echo $_SESSION['code'];
    $days = array('Monday');
    //echo $days[0];
    $user = new User($_SESSION['code'], $pdo);
    $tutors = $user->searchTutors($days);

    $tutors;

    foreach($tutors as $t){
        echo $t;
    }
?>
