<?php
include_once("../DataBase.php");
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["idAbsence"])) {
        $idAbsence = $_POST["idAbsence"];
        $delete = $db->Delete('absence', "idAbsence = $idAbsence");
        ?>
        <script>
            iziToast.success({
                title: 'OK',
                message: "L'opération réussi avec succès",
            });
            setTimeout(() => {

                location.reload();
            }, 900);
        </script>;
        <?php
    } else {
        ?>
        <script>
            iziToast.warning({
                title: 'Attention',
                message: "L'opération n'a pas réussi",
            });
            location.reload();
        </script>;
        <?php
    }
} else {
    header('location:../../login.php');
}
?>