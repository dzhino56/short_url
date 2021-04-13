<?php

session_start();
require_once '../classes/Shortener.php';

$s = new Shortener();

if (isset($_POST['url'])) {
    $url = $_POST['url'];

    if($code = $s->makeCode($url)) {
        $_SESSION['feedback'] = "Generated! Your short URL is: <a href=\"http://shorturl/{$code}\">http://shorturl/{$code}</a>";
    }
    else {
        $_SESSION['feedback'] = $code;
    }
}

header('Location: ../index.php');