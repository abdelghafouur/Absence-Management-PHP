<?php
include_once("../DataBase.php");
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $cef = $_GET['cef'];
    $CheckIfExiste = $db->Select("stagiaire", "CEF", "CEF = '$cef'");
    if (empty($CheckIfExiste)) {
        $ReqINSERT = $db->Insert(
            "stagiaire",
            ["CEF", "nomStagiaire", "prenomStagiaire", "idGroupe"]
            ,
            [$_GET['cef'], $_GET['nom'], $_GET['prenom'], $_SESSION["groupe"]]
        );
        echo "
        <script>
            iziToast.success({
                title: 'OK',
                message: 'Le stagiaire été bien Ajouter!',
            });
        </script>
        ";
        exit();

    } else {

        echo "
        <script>
            iziToast.warning({
                title: 'Attention',
                message: 'Le stagiaire déja exist!',
            });
        </script>
        ";
        exit();
    }

}