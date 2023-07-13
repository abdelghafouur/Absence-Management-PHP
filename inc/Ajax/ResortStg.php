<?php
include_once("../DataBase.php");
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['CEF'])) {
    $CEF = $_GET["CEF"];
    $sql = $db->Delete('deleted_stagiaire', "CEF = $CEF");
    ?>
    <script>
        iziToast.success({
            title: 'OK',
            message: "L'opération réussi avec succès",
        });
        setTimeout(() => {
            location.reload();
        }, 1000);
    </script>;
    <?php
} else {
    header('location:../../Accueil-serveillant.php');
}
?>