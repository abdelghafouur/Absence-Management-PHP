<?php
include_once("../DataBase.php");

session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}


// fetch all "stagiare" cef
$res = $db->Select('stagiaire', 'CEF');
// jestufier
foreach ($res as $key => $value) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sent-verf']) && isset($_POST['check-btn-' . $value->CEF]) && !empty($_POST['justif-' . $value->CEF])) {
        pprint($_POST['idAbs-' . $value->CEF]);
        pprint($_POST['justif-' . $value->CEF]);
        $idabs = $_POST['idAbs-' . $value->CEF];
        $motif = $_POST['justif-' . $value->CEF];
        $query = $db->Insert('justifierabsence', ['idAbsence', 'Justifie_motif'], [$idabs, $motif]);
        $previsepage = $_SERVER['HTTP_REFERER'];
        header("location:$previsepage");
    }
}