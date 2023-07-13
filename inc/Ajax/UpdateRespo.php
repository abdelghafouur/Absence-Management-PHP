<?php
include_once("../DataBase.php");
;
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["newRespo"])) {
        $newRespo = $_POST["newRespo"];
        $oldRespo = "";
        if (isset($_POST['oldRespo'])) {
            $oldRespo = $_POST["oldRespo"];
        }
        $sql = ' CALL Update_Groupe_Respo(?, ?)';
        $pdo_statement = $conn->prepare($sql);
        $pdo_statement->bindParam(1, $oldRespo);
        $pdo_statement->bindParam(2, $newRespo);
        $pdo_statement->execute();

        ?>
        <script>
            alert("Opération terminée avec succès")
            location.reload();
        </script>;
        <?php

    } else {
        ?>
        <script>
            alert("L'opération n'a pas réussi")
            location.reload();
        </script>;
        <?php
    }
} else {
    header('location:./login.php');
}
?>