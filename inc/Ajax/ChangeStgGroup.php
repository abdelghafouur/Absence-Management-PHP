<?php
include_once("../DataBase.php");
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] !== "serveillant") {
    header('location:./login.php');
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["cef"]) && !empty($_GET["grpid"])) {
    $cef = $_GET["cef"];
    $checkIFExists = $db->Select("stagiaire", "CEF", "CEF = '$cef'");
    pprint($checkIFExists);
    if (!empty($checkIFExists)) {
        $grpid = $_GET["grpid"];
        $sql = $db->Update('stagiaire', "idGroupe = $grpid", "CEF = $cef");
        ?>
        <script>
            iziToast.success({
                title: "OK",
                message: "Le groupe du stagiaire été bien Changer!",
            });
        </script>
        <?php
        exit();
    } else {
        ?>
        <script>
            iziToast.warning({
                title: "Attention",
                message: "Le cef du stagiaire n'exist pas!",
            });
        </script>
        <?php
        exit();
    }
} else {
    // header('location:../../modifier-Groupe.php');

}