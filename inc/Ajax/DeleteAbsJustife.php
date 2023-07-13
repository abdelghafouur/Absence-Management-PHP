<?php
include_once("../DataBase.php");
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["idabs"])) {
    $idabs = $_POST["idabs"];
    $sql = $db->Delete("justifierabsence", "idAbsence = $idabs");
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
    header('location:../../login.php');
}
?>