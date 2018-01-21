<?php
    /*Template name: Logout*/
    session_start();
    session_destroy();
    header('Location: ../login');
?>