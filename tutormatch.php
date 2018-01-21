<?php
/*Template name: Tutormatch*/
include 'config.php';
include 'user.php';
session_start();
get_header();

$sub = $_POST['subject'];
$user = new User($_SESSION['code'], $pdo);
$tutors = $user->searchTutors($sub);
$_SESSION['sub'] = $sub;

if(sizeof($tutors) == 0){
    echo "<h3>Whoa! Looks like there are no available tutors for that subject! Check back soon for new updates or <a href='../contact'>contact us</a> to see if we can find you a match sooner</h3>";
    echo "<a href='select-subject'>Find a different subject</a>";
} 

foreach($tutors as $tutor) :
?>
<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">
    <hr style="margin-top: 20px; border-width: 10px; border-color: black;">
    <h1 style="margin-top: 30px;"><?php echo $tutor['name'];?></h1>
    <div class="tutor_info">
        <p><?php echo $tutor['bio'];?></p>
        <h5><?php echo $tutor['days'];?></h5>
    </div>
    <form action="../bond" method="post">
        <?php $id = $tutor['id'];
        echo "<input name='id' type='text' value='$id'  style='visibility: hidden;'  readonly='true'>";?>
        <div style="text-align: center;"><input type="Submit" value="Choose Tutor"></div>
    </form>
    <a onclick="check()">Skip This Step</a>
<?php endforeach;?>
</main>
</div>