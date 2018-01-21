<?php
    /*Template name: mytutors*/
    include 'config.php';
    include 'user.php';
    session_start();
    get_header();
    
    if (!isset($_SESSION['code'])){
        header('Location: ../login');
    }

    $user = new User($_SESSION['code'], $pdo);
    $tutors = $user->getTutors();
?>
<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">
    <?php foreach ($tutors as $t){
        echo "<h3 class='info'>" . $t['name'] . "</h3>";
        echo "<p>" . $t['bio'] . "</p>";
        echo "<p>Available Days: " . $t['days'] . "</p>";
        echo "<p>Email: " . $t['email'] . "</p>";
        echo "<p>Phone Number: " . $t['phone_number'] . "</p>";
        echo "<hr>";
    }?>
</main>
</div>
<?php  
        get_sidebar();
        get_footer();?>