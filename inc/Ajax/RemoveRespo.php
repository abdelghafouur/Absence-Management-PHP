<?php
include_once("../DataBase.php");
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['CEF'])) {
    $cef = $_GET['CEF'];
    $comptetype = 'stagiaire';
    $query = $db->Delete('compte', "user = $cef and compteType = '$comptetype'");
    echo "
    <script>
        iziToast.warning({
            title: 'OK',
            message: 'le responsable a été bien Supprimer!',
        });
    </script>
    ";
    exit();
}