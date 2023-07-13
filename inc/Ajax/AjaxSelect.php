<?php
include_once("../DataBase.php");
session_start();
// if (empty($_SESSION) or $_SESSION['compteType'] != "stagiaire" or $_SESSION['compteType'] != 'directrice' or $_SESSION['compteType'] != 'serveillant' or $_SESSION['compteType'] != 'superAdmin') {
//     header('location:./login.php');
//     exit();
// }
?>
<?php
if (isset($_GET['annescolID']) && !empty($_GET['annescolID'])) {
    $annescolID = $_GET['annescolID'];
    $req = $db->Select("annee", "*", "idAnneeScolaire = $annescolID");
    echo '<option disabled  selected >Année</option>';
    foreach ($req as $key => $value) {
        ?>
        <option value="<?= $value->idAnnee ?>">
            <?= $value->nomAnnee ?>
        </option>
        <?php
    }
}
if (isset($_GET['anneeID']) && !empty($_GET['anneeID'])) {
    $anneeID = $_GET['anneeID'];
    $req = $db->Select("filiere", "*", "idAnnee = $anneeID");
    echo '<option disabled  selected >Filière</option>';
    foreach ($req as $key => $value) {
        ?>
        <option value="<?= $value->idFiliere ?>">
            <?= $value->nomFiliere ?>
        </option>
        <?php
    }
}
if (isset($_GET['filiereID']) && !empty($_GET['filiereID'])) {
    $filiereID = $_GET['filiereID'];
    $req = $db->Select("groupe", "*", "idFiliere = $filiereID");
    echo '<option disabled  selected >Groupe</option>';
    foreach ($req as $key => $value) {
        ?>
        <option value="<?= $value->idGroupe ?>">
            <?= $value->nomGroupe ?>
        </option>
        <?php
    }
}
?>