<?php
/*Template name: save_updates*/
session_start();
include 'config.php';
include 'user.php';

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$grade = $_POST['grade'];
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$opass = filter_input(INPUT_POST, 'opass', FILTER_DEFAULT);
$npass = filter_input(INPUT_POST, 'npass', FILTER_DEFAULT);

$user = new User($_SESSION['code'], $pdo);
$user->updateInfo($fname, $lname, $email, $grade);
if ($opass != "" && $npass != ""){
    $user->changePass($opass, $npass);
}
header('Location: ../realtimeportal');
?>