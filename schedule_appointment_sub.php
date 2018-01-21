<?php
    /*Template name: Custom2*/
    session_start();
    include 'user.php';
    include 'config.php';
?>
<?php if(isset($_SESSION['code'])) :?>
     <?php get_header();?>
    <div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
    <h1>Schedule a Session</h1>
    <form action="../schedule_appointment_dt" method="post">
        <h3>Subject:</h3>
        <select name="subject" onclick="calSwitch()">
        <?php
            $user = new User($_SESSION['code'], $pdo); 
            $subs = $user->getSubjects();
            foreach($subs as $sub){
                echo "<option value='$sub'>$sub</option>";
            }
        ?>
        </select><br><br>
        <input type="submit" value="Select date/time">
    </form>
    </div>
    </main>
<?php endif;?>
<?php  
        get_sidebar();
        get_footer();?>