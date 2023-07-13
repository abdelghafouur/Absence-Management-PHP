<?php
include_once("../DataBase.php");
;
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" || !empty($_GET["date"])) {
    $date = $_GET["date"];
    $absence = 'absence';
    $retard = 'retard';
    // nbrAbs CureDate
    $nbrAbs = $db->Query("SELECT Get_CountAbs_Date('$date','$absence') AS nbr")[0]->nbr;
    // nbrRet CureDate
    $nbrRet = $db->Query("SELECT Get_CountAbs_Date('$date','$retard') AS nbr")[0]->nbr;
    $json = array('abs' => $nbrAbs, 'ret' => $nbrRet);
    $json_data = json_encode($json);
    echo $json_data;

} else {
    echo "<script>
        alert('access denied');
        window.location.href='../../Affichage-surveillant.php';
        </script>";
}
?>