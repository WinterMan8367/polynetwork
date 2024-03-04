<?
    session_start();
    unset($_SESSION['user_info']);
    $_SESSION = [];
    session_destroy();
    header("Location: /login");
?>