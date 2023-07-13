<?php
include_once("../DataBase.php");
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}
// global var
$userid = $_GET['userid'];

// get first  & last name
$query = $db->Select('stagiaire', '*', "CEF ='$userid'")[0];
$nom = $query->nomStagiaire;
$prenom = $query->prenomStagiaire;


// nbr abs
$nbrAbs = $db->Select('absence', 'COUNT(idAbsence) as nbrAbs', "type = 'absence' and CEF = '$userid'")[0]->nbrAbs;

// nbr reatred
$nbrRetard = $db->Select('absence', 'COUNT(idAbsence) as nbrRetard', "type = 'retard' and CEF = '$userid'")[0]->nbrRetard;


// les Absence
$absence = $db->Select('absence', 'dateAbsence,heureDebutAbsence,heureFinAbsence,moduleAbsence,matricule,justifier', "type = 'absence' and CEF = '$userid'");

// les Retared
$retard = $db->Select('absence', 'dateAbsence,heureDebutAbsence,heureFinAbsence,moduleAbsence,matricule,justifier', "type = 'retard' and CEF = '$userid'");


?>
<div>
    <h4>
        <?= $nom . ' ' . $prenom; ?>
    </h4>
</div>
<div class="separators"></div>
<!-- Les Absence -->
<div class="main">
    <div class="title">Les Absence : </div>
    <?php
    if (!empty($absence)) {
        ?>
        <div class="list">
            <ol>
                <?php
                foreach ($absence as $key => $value) {
                    ?>
                    <li>
                        <span>La Date d'absence</span> :
                        <?= $value->dateAbsence ?><br>
                        <span>Du</span> :
                        <?= $value->heureDebutAbsence ?>
                        <span> A </span>:
                        <?= $value->heureFinAbsence ?><br>
                        <span> Module absente </span>:
                        <?= $value->moduleAbsence ?><br>
                        <span> formateur </span>:
                        <?php
                        //fetch formateur
                        $Formateur = $db->Select("formateur", "concat(nomFormateur,'  ',prenomFormateur) as fullName", "Matricule='$value->matricule'")[0]->fullName;
                        echo $Formateur ?><br>
                        <span>etat </span>:
                        <?php
                        if ($value->justifier == "oui") {
                            echo "justifier";
                        } else if ($value->justifier == 'no') {
                            echo " non justifier";
                        }
                        ?>
                    </li>

                    <?php
                }
                ?>
            </ol>
            <?php
    } else {
        echo "<span class='empty-msg'>Aucune absence</span>";
    }
    ?>
    </div>
</div>
<!-- separators -->
<div class="separators"></div>
<!-- Les Retared  -->
<div class="main">
    <div class="title">Les Retared :</div>
    <?php
    if (!empty($retard)) {
        ?>
        <div class="list">

            <ol>
                <?php
                foreach ($retard as $key => $value) {
                    ?>
                    <li>
                        <span>La Date d'absence</span> :
                        <?= $value->dateAbsence ?><br>
                        <span>Du</span> :
                        <?= $value->heureDebutAbsence ?>
                        <span> A </span>:
                        <?= $value->heureFinAbsence ?><br>
                        <span> Module absente </span>:
                        <?= $value->moduleAbsence ?><br>
                        <span> formateur </span>:
                        <?php
                        //fetch formateur
                        $Formateur = $db->Select("formateur", "concat(nomFormateur,'  ',prenomFormateur) as fullName", "Matricule='$value->matricule'")[0]->fullName;
                        echo $Formateur ?><br>
                        <span>etat </span>:
                        <?php
                        if ($value->justifier == "oui") {
                            echo "justifier";
                        } else if ($value->justifier == 'no') {
                            echo " non justifier";
                        }
                        ?>
                    </li>

                    <?php
                }
                ?>
            </ol>
            <?php
    } else {
        echo "<span class='empty-msg'>Aucune reatred</span>";
    }
    ?>
    </div>
</div>
<!-- separators -->
<div class="separators"></div>
<!-- Justifier button -->
<?php
if (!empty($absence) || !empty($retard)) {

    echo '<div class="btn-div"><a href="./Affichage-surveillant.php?annee-Scolaire=' . $_SESSION["anneeScolaire"] . '&annee=' . $_SESSION["annee"] . '&filiere=' . $_SESSION["filiere"] . '&groupe=' . $_SESSION["groupe"] . '&AjaxValider=valider"><button class="justifier-btn">Justifier</button></a></div>';
}
?>