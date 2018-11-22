<?php
    if (isset($_COOKIE['username'])) {
        unset($_COOKIE['username']);
        setcookie('username', '', time() - 3600, '/'); // empty value and old timestamp
        unset($_COOKIE['access_token']);
        setcookie('access_token', '', time() - 3600, '/'); // empty value and old timestamp
        unset($_COOKIE['id']);
        setcookie('id', '', time() - 3600, '/'); // empty value and old timestamp
    }
    header('Location: login.php');
?>