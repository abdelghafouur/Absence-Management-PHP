<?php
include_once("../DataBase.php");
;
$anneScolaire = $_POST['anneeScolaire'];
$anne = $_POST['annee'];
$counter = $_POST['nombre'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['valider'])) {
        // addd anneeScolaire
        // check if anneeScolaire already exists
        $pdo_statement = $conn->prepare("SELECT * FROM AnneeScolaire where nomAnneeScolaire = '$anneScolaire'");
        $pdo_statement->execute();
        $result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            $sql = "INSERT INTO anneeScolaire  VALUES (null,?)";
            $pdo_statement = $conn->prepare($sql);
            $pdo_statement->bindParam(1, $_POST['anneeScolaire']);
            $pdo_statement->execute();
        }

        //   add anne
        // recuperation  idAnneeScolaire
        $pdo_statement1 = $conn->prepare("SELECT idAnneeScolaire FROM AnneeScolaire where nomAnneeScolaire = '$anneScolaire'");
        $pdo_statement1->execute();
        $result = $pdo_statement1->fetch();
        $idAnneeScolaire = $result[0];

        // check if annee already exists
        $pdo_statement = $conn->prepare("SELECT * FROM Annee where nomAnnee = '$anne' and idAnneeScolaire = '$idAnneeScolaire'");
        $pdo_statement->execute();
        $result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            $pdo_statement2 = $conn->prepare("INSERT INTO Annee  VALUES (null,?,?)");
            $pdo_statement2->bindParam(1, $_POST['annee']);
            $pdo_statement2->bindParam(2, $idAnneeScolaire);
            $pdo_statement2->execute();
        }
        // filiere
        // recuperation  idAnnee
        $pdo_statement1 = $conn->prepare("SELECT idAnnee FROM Annee where nomAnnee = '$anne' and idAnneeScolaire = '$idAnneeScolaire'");
        $pdo_statement1->execute();
        $result = $pdo_statement1->fetch();
        $idAnnee = $result[0];
        for ($i = 1; $i <= $counter; $i++) {
            pprint($_POST);
            $pdo_statement3 = $conn->prepare("INSERT INTO filiere  VALUES (null,?,?)");
            $pdo_statement3->bindParam(1, $_POST['filiere-' . $i]);
            $pdo_statement3->bindParam(2, $idAnnee);
            $pdo_statement3->execute();
        }

    }
    header("location:../creation.php");

}


?>