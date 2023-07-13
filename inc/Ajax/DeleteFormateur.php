<?php
include_once("../DataBase.php");
session_start();
if (empty($_SESSION) or ($_SESSION['compteType'] != "superAdmin")) {
    header('location:./login.php');
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["matricule"])) {

    $matricule = $_GET["matricule"];
    $sql = $db->Delete("formateur", "Matricule = '$matricule'");

    ?>
    <script>
        iziToast.success({
            title: "OK",
            message: "Le formateur a été bien Supprimer!",
        });
        setTimeout(() => {
            location.reload()
        }, 2000);
    </script>
    <?php
    exit();
}