<?php
include_once("../DataBase.php");
;
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "stagiaire") {
    header('location:./../login.php');
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["search"])) {
        $data = $_GET['search'];
        $sql = "SELECT * FROM formateur WHERE (nomFormateur LIKE '%" . $data . "%') OR (prenomFormateur LIKE '%" . $data . "%')  ";
        $pdo_statement = $conn->prepare($sql);
        $pdo_statement->execute();
        $resultfinale = $pdo_statement->fetchALL();
        var_dump($resultfinale);
        if (!empty($resultfinale)) {
            foreach ($resultfinale as $row) {
                echo "<option value=" . $row['Matricule'] . ">" . $row['nomFormateur'] . ' ' . $row['prenomFormateur'] . "</option>";
            }
        } else {
            echo "<option value='Nothing Found' selected >Nothing Found</option>";
        }
    }
}
?>