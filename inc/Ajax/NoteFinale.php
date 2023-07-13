<?php
include_once("../DataBase.php");
;
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['cef']) && !empty($_GET['Comportement'])) {
    $cef = $_GET['cef'];
    $Comportement = (int) $_GET['Comportement'];
    $update = $db->Update('note', "note = note+ $Comportement,comportement =  $Comportement", "CEF = $cef");
}