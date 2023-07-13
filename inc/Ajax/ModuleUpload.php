<?php
include_once('./db.php');
session_start();

if (isset($_POST["Submit"])) {
    function import($file)
    {
        global $conn;
        $stats = 0;
        $stats2 = 0;
        $file = fopen($file, 'r');
        $flage = 1;
        while ($row = fgetcsv($file)) {
            if ($flage == 1) {
                $flage++;
                continue;
            }
            // featch the id based on name;
            $sql = "SELECT idFiliere FROM filiere WHERE  nomFiliere = ?";
            $pdo_statement = $conn->prepare($sql);
            $pdo_statement->bindParam(1, $row[1]);
            $pdo_statement->execute();
            $result = $pdo_statement->fetch(PDO::FETCH_COLUMN);
            $row[1] = $result;
            // check if Module allready exist
            $check = "SELECT * FROM module WHERE nomModule = ? and idFiliere = ?";
            $pdo_statement = $conn->prepare($check);
            $pdo_statement->bindParam(1, $row[0]);
            $pdo_statement->bindParam(2, $row[1]);
            $pdo_statement->execute();
            $checkresult = $pdo_statement->fetch();
            if (empty($checkresult)) {
                // convert to array to str 
                $value = "'" . implode("','", $row) . "'";
                // insert int table
                $sql = "INSERT INTO module(`nomModule`,`idFiliere`) VALUES (" . $value . ")";
                $pdo_statement = $conn->prepare($sql);
                $pdo_statement->execute();
                $stats = 1;
            } elseif (!empty($checkresult)) {
                $stats2 = 1;
            }
        }
        if ($stats == 1 && $stats2 == 0) {
            echo "Succès : Importé avec succès";
        } elseif ($stats == 1 && $stats2 == 1) {
            echo " Attention :un ou plusieur Module il deja inserer , verify la list des module";
        } elseif ($stats == 0 && $stats2 == 1) {
            echo "Attention : toute les modules de ce fichier existe";
        } else {
            echo "Error : Contact technician for more information";
        }
    }
    import($_FILES['csv_file']['tmp_name']);

}