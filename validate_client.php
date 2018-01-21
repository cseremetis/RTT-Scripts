<?php
    /*Template name: Custom*/
    require_once 'config.php';

    //gather data
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    
    $sql = "SELECT * FROM clients WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user['admin'] == 1 && password_verify($password, $user['password'])){
       session_start();
       $_SESSION['name'] = $user['fname'];
       $_SESSION['code'] = $user['confirm_code'];
       $_SESSION['admin'] = TRUE;
       header('Location: ../realtimeportal');
    }
    elseif ($user['tutor'] == 1 && password_verify($password, $user['password'])){
       session_start();
       $_SESSION['name'] = $user['fname'];
       $_SESSION['code'] = $user['confirm_code'];
       $_SESSION['tutor'] = TRUE;
       header('Location: ../realtimeportal');
    }
    elseif (isset($user['fname']) && password_verify($password, $user['password'])){
       session_start();
       $_SESSION['name'] = $user['fname'];
       $_SESSION['code'] = $user['confirm_code'];
       echo('login successful');
       header('Location: ../realtimeportal');
    } else {
       header('Location: ../login');
    }
?>
