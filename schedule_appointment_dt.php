<?php
    /*Template name: Custom3*/
    session_start();
    include 'user.php';
    include 'config.php';
    $sub = $_POST['subject'];
    get_header();
    if($_SESSION['tutor']) :
    ?>
<?php $today = date('Y-m-d H:i:s');
 ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <form name="datetime" action="../saveAppointment" method="post">
        <h3>Subject:</h3><br>
        <br>
        <?php echo "<input type='text' name = 'sub' value='$sub' readonly='readonly'>";?><br>
        <h3>Date and Time:</h3>
        <input type="datetime-local" id="date" name="date" min="<?php $today ?>" style="margin-bottom: 30px;">
        <br>
        <input type="submit" value="Schedule Your Session">
    </main>
</div>
<?php
    elseif(isset($_SESSION['code'])) :
?>
    <?php
        $sql = "SELECT * FROM tutor_subjects WHERE name = ? AND client_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sub, 0]);
        $vsubs = [];
        while($row = $stmt->fetch()){
            array_push($vsubs, $row);
        }
        if (sizeof($vsubs) == 0) :
    ?>
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <h3>Oops! It looks like there are no available spots for this subject! Check back later for more openings or call our help desk at 201-995-7868 to schedule an urgent session</h3>
        <a href="../schedule_appointment_sub">Pick a different subject</a>
        </main>
        </div>
    <?php else :?>
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <form name="datetime" action="../saveAppointment" method="post">
        <h3>Subject:</h3><br>
        <br>
        <?php echo "<input type='text' name = 'sub' value='$sub' readonly='readonly'>";?><br>
        <h3>Date and Time:</h3>
        <input type="datetime-local" id="date" name="date" list="thesedates" style="margin-bottom: 30px;">
        <datalist id="thesedates">
            <?php
                foreach ($vsubs as $subs) {
                    $date = $subs['date'];
                    echo "<option>$date</option>";
                }
            ?>
        </datalist>
        <br>
        <input type="submit" value="Schedule Your Session">
        </form>
        </main>
        </div>
    <?php endif;?>
<?php endif;?>
<?php  
        get_sidebar();
        get_footer();?>
