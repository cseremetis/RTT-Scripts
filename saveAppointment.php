<?php
/*Template name: Custom4*/
include 'config.php';
include 'user.php';
get_header();

session_start();
$sub = $_POST['sub'];
$date = $_POST['date'];

if($_SESSION['tutor']) {
    $user = new User($_SESSION['code'], $pdo);
    $user->setAppointment(TRUE, $date, $sub);
}
elseif(isset($_SESSION['code'])){
    $user = new User($_SESSION['code'], $pdo);
    $user->setAppointment(FALSE, $date, $sub);
}
?>
<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		</main>
	</div>
<?php  
        get_sidebar();
        get_footer();?>