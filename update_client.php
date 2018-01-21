<?php
    /* Template name: update_user*/
    session_start();
    get_header();
    include 'config.php';
    include 'user.php';
    if (isset($_SESSION['code'])):
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php $user = new User($_SESSION['code'], $pdo);?>
        <form action="../save_updates" method="post" onsubmit="updated()">
            <?php
                $fname = $user->getFname();
                $lname = $user->getLname();
                $grade = $user->getGrade();
                $email = $user->getEmail();
                $gradeOptions = array('freshman', 'sophomore', 'junior', 'senior', 'college');
                $subs = $user->getSubjects();
                echo "<div class='one_half' style='margin-bottom: 20px;'><h3>First Name:  </h3><input type='text' name='fname' value='$fname'><br>";
                echo "<h3>Last Name:  </h3><input type='text' name='lname' value='$lname'><br></div>";
                echo "<div class='one_half'><h3>Email:  </h3><input type='text' name='email' value='$email'><br>";
            ?>
            <h3>Grade:</h3>
            <select name="grade">
                <?php
                    foreach($gradeOptions as $g){
                        if($grade == $g){
                            echo "<option value='$g' selected='true'>$g</option>";
                        } else {
                            echo "<option value='$g'>$g</option>";
                        }
                    }
                ?>
            </select><br>
            </div>
            <h3 class="info">Subjects:</h3>
            <?php 
                foreach($subs as $sub){
                    $subName = $sub['name'];
                    echo "<p>$subName</p>";
                }
            ?>
            <a href="../remove_subject">Remove Subject</a><br>
            <a href="../add_subject">Add Subject</a><br>
            <h3>Change Password:</h3>
            <br><label style="margin-right: 10px;">Old Password: </label><input name="opass" type="password">
            <br><label style="margin-right: 10px;">New Password: </label><input name="npass" style="margin-top: 20px;" type="password">
            <br><input style="margin-top: 40px;" type="submit" value="Change Info">
        </form>
    </main>
</div>
<?php  
        get_sidebar();
        get_footer();?>
<?php else :?>
<?php endif;?>>