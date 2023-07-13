<?php
include_once('../DataBase.php');
session_start();
if (empty($_SESSION) || (($_SESSION['compteType'] != "stagiaire") || ($_SESSION['compteType'] != "serveillant"))) {
    // header('location:./../../login.php');
}
?>
<?php
$idgrp = $_SESSION['idgrp'];
// fetch all "stagiare" id's
$req = $db->Select("stagiaire", "CEF", "idGroupe = $idgrp");
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["valider"])) {
    // get data
    $date = $_GET['date'];
    $module = $_GET['module'];
    $formateur = $_GET['formateur'];
    foreach ($req as $key => $value) {
        $cef = $value->CEF;
        $error = 1;
        $type = "";
        if (!empty($_GET['absence-' . $cef])) {
            $type = 'absence';
            $error = 0;
        }
        if (!empty($_GET['retard-' . $cef])) {
            $type = 'retard';
            $error = 0;
        }
        if ($error == 0) {
            // select for get id of annee + filire + anneescolaire
            $tables = "annee a, filiere f, anneescolaire ann, groupe g ,stagiaire s";
            $cols = "a.idAnnee , f.idFiliere, ann.idAnneeScolaire";
            $where = "s.idGroupe = g.idGroupe and g.idFiliere = f.idFiliere and f.idAnnee = a.idAnnee and ann.idAnneeScolaire = a.idAnneeScolaire AND s.CEF = $cef";
            $ids = $db->Select($tables, $cols, $where);
            //variables
            $idfilire = $ids[0]->idFiliere;
            $idannee = $ids[0]->idAnnee;
            $idscolaire = $ids[0]->idAnneeScolaire;
            $timeDebut = $_GET['debut-' . $cef];
            $timeFin = $_GET['Fin-' . $cef];
            // insert int absence table
            $cols = ["dateAbsence", "heureDebutAbsence", "heureFinAbsence", "moduleAbsence", "matricule", "type", "idAnnee", "idFiliere", "idGroupe", "idAnneeScolaire", "CEF"];
            $values = [$date, $timeDebut, $timeFin, $module, $formateur, $type, $idannee, $idfilire, $idgrp, $idscolaire, $cef];
            $inster = $db->Insert("absence", $cols, $values);
            if ($_SESSION['compteType'] == "stagiaire") {
                header('location:../../Responsable.php?success=les absence et bien enregistré');

            } elseif ($_SESSION['compteType'] == "serveillant") {
                header('location:../../SasireAbsence-surveillant.php?success=les absence et bien enregistré');
            }
        }
    }



} else {
    header('location:../../responsable.php?error=veuillez vérifier les informations saisies');
}
?>