<?php
include_once("../DataBase.php");
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['CEF'])) {
    $cef = Validate($_GET['CEF']);
    $comptetype = 'stagiaire';
    $hashed_password = password_hash($cef, PASSWORD_DEFAULT);
    $insert = $db->Insert('compte', [], [$cef, $hashed_password, $comptetype]);
    echo "
    <script>
        iziToast.success({
            title: 'OK',
            message: 'le responsable a été bien Ajouter!',
        });
    </script>
    ";
    exit();
}