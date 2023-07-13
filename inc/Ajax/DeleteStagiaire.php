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
    $query = $db->Query("CALL Delete_Stagiaire_From_Group($CEF)");
    echo "
    <script>
        iziToast.success({
            title: 'OK',
            message: 'le Stagiaires a été bien Supprimer!',
        });
        setTimeout(() => {
            location.reload();
          }, 1500)
    </script>
    ";
    exit();
}