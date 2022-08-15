<?php

    session_start();

    unset($_SESSION['exp_manager']);

    header('location: ../');
    exit;

?>