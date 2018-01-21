
<?php 
 /* Template name: Realtimeportal*/
 require_once 'config.php';
 require_once 'user.php';
 session_start();
 get_header();
 $name = $_SESSION['name'];?>
<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">
<?php if ($_SESSION['admin']) :
        $stmt = $pdo->query('SELECT * FROM clients');
        echo "<h2>Users:</h2>";
        foreach($stmt as $row) {
            if ($row['admin'] == 0 && $row['tutor'] == 0){
                echo $row['fname'] . "\n";
            }
        }
        echo "<h2>Tutors:</h2>";
        foreach($stmt as $row) {
            if ($row['tutor'] == 1){
                echo $row['fname'] . "\n";
            }
        }
?>
<?php elseif (isset($_SESSION['code'])) :?>
    <?php echo "<h1>Welcome, $name</h1>";?>
    <h2 class="text-center">Your Info:</h2>
    <?php
        $user = new User($_SESSION['code'], $pdo);
        $fullName = $user->getFname() . " " . $user->getLname();
        $grade = $user->getGrade();
        $email = $user->getEmail();
        $pemail = $user->getPemail();
        echo "<div class='one_half' style='margin-bottom: 20px;'><h3 class='info'>Name/Email:</h3> <p>$fullName</p> <p>$email</p> <p>$pemail</p></div>";
        echo "<div class='one_half'><h3 class='info'>Grade:</h3> <p style='text-align: center;'>$grade</p></div>";
        echo "<h3 class='info'>Subjects:</h3>";
        $subs = $user->getSubjects();
        foreach($subs as $s){
            $sname = $s['name'];
            echo "<p>$sname</p>";
        }
        echo "<a href='../update_client'>Change Info</a>";
    ?>
    <h2 class="text-center">Your Tutors:</h2>
    <?php 
    if(sizeof($user->getSubjects()) == 0){
        echo "<p>You must add subjects before you can connect with a tutor</p>";
    } else {
        $tutors = $user->getTutors();
       foreach($tutors as $t){
            $name = $t['name'];
            echo "<p>$name</p>";
        }
        echo "<a href='../mytutors'>Learn More About Your Tutors</a><br>";
        echo "<a href='../remove_tutor'>Find a New Tutor</a>";
    }
    ?> 
</main>
</div>
    <?php  
        get_sidebar();
        get_footer();?>
<?php else :?>
    <h1>Session Not Set</h1>
    <p><a href="../login">Login</a>
<?php endif;?>