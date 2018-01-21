<?php
         /*Template Name: Create_User*/
         include 'user.php';
         include 'config.php';

         //secure page
         $secure = TRUE;

         //collect data
         $fname = $_POST['fname'];
         $lname = $_POST['lname'];
         $grade = $_POST['grade'];
         $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
         $pemail = filter_input(INPUT_POST, 'pemail', FILTER_SANITIZE_EMAIL);
         $num = filter_input(INPUT_POST, 'pNumber', FILTER_DEFAULT);
         $pass1 = filter_input(INPUT_POST, 'password1', FILTER_DEFAULT);
         $pass2 = filter_input(INPUT_POST, 'password2', FILTER_DEFAULT);

         if($pass1 != $pass2) {
             die("passwords must match, <a href='../sign-up-now'>try again</a>");
         }

         $pass = password_hash($pass1, PASSWORD_DEFAULT);
         $conf = password_hash(date('Y-m-d H:i:s').$email, PASSWORD_DEFAULT);

         if(!isset($pass)) {
             die("could not hash password");
         }

         //check for repeats
         $stmt = $pdo->query('SELECT email FROM users');
         foreach($stmt as $row){
             if ($email == $row['email']) {
                 die("The email you entered is already taken. <a href='./sign-up-now'>Try again</a>");
             }
         }

         //create client
         try{
            $sql = "INSERT INTO users (fname, lname, email, parent_email, password, confirm_code, grade, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$fname, $lname, $email, $pemail, $pass, $conf, $grade, $num]);
            echo "<h2>Successfully registered user</h2>";
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

        //begin session
        session_start();
        $_SESSION['name'] = $fname;
        $_SESSION['code'] = $conf;

        //redirect to tutor match.com
        header('Location: ../select-subject');
?>