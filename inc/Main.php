<?php
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] !== "superAdmin") {
    header('location:./login.php');
}
// requier db and class :
include_once('./DataBase.php');
include_once('./XLSXReader.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES) && !empty($_POST)) {
    // geting Post data
    $file = $_FILES['file']['tmp_name'];
    $table = $_POST['table'];
    $fname = $_FILES['file']['name'];
    $tmp = explode('.', $fname);
    $file_extension = end($tmp);
    $ext = ['xlsx', 'xls', 'XLSX', 'XLS'];
    if (!in_array($file_extension, $ext)) {
        header("location:../Importer" . $table . ".php?msg=Le fichier n'est pas un fichier excel&status=error");
    } else {
        $anneeScolaire = "";
        if (!empty($_POST["annee-Scolaire"])) {
            $anneeScolaire = $_POST["annee-Scolaire"];
        }
        // repetitve sql query ;
        function getIdGrp($name, $idfilier)
        {
            global $db;
            $idgrp = $db->Select('groupe', "idGroupe", "nomGroupe = '$name' and idFiliere = $idfilier")[0]->idGroupe;
            return $idgrp;
        }

        // Module Function
        function insertModule($row)
        {
            global $db;
            global $fname;
            // featch the id based on name;
            $namef = '"' . $row[1] . '"';
            $nameM = $row[0];
            $idf = $db->Select("filiere", "idFiliere", "nomFiliere = $namef")[0]->idFiliere;
            // check if Module allready exist
            $checkresult = $db->Select("module", "*", "nomModule = '$nameM' and idFiliere = $idf");
            if (empty($checkresult)) {
                if ((count($row) === 2)) {
                    // insert int table
                    $sql = $db->Insert("module", ['nomModule', 'idFiliere'], [$nameM, $idf]);
                    $msg = "Opération terminé avec succès&status=done";
                    return $msg;
                } else {
                    $msg = "Le fichier " . $fname . " ne respect pas le fichier exemplaire&status=error";
                    return $msg;
                }

            }

        }


        // Formateur Function
        function insertFormateur($row)
        {
            global $db;
            global $table;
            global $fname;
            // check if Formateur allready exist
            $matricule = $row[0];
            $checkresult = $db->Select('formateur', "*", "Matricule = '$matricule'");
            if (empty($checkresult)) {
                if ((count($row) === 3)) {
                    // insert int table
                    $sql = $db->Insert('formateur', ["Matricule", "nomFormateur", "prenomFormateur"], $row);
                    $msg = "Opération terminé avec succès&status=done";
                    return $msg;
                } else {
                    $msg = "Le fichier " . $fname . " ne respect pas le fichier exemplaire&status=error";
                    return $msg;
                }

            }
        }
        // Stagiaire Function
        function insertStagiaire($row)
        {
            pprint("-------------");
            global $db;
            global $anneeScolaire;
            global $fname;
            if (!empty($anneeScolaire) && (count($row) === 6)) {
                pprint($row);
                // check if Stagiaire allready exist
                $checkresult = $db->Select('stagiaire', "*", "CEF = '$row[0]'");
                if (empty($checkresult)) {
                    // Get Annee id 
                    $anneeID = $db->Select('annee', "idAnnee", "nomAnnee ='$row[3]' and idAnneeScolaire = $anneeScolaire")[0]->idAnnee;
                    if ($anneeID) {
                        // Get filiere id 
                        $filiername = '"' . $row[4] . '"';
                        $filierID = $db->Select('filiere', "idFiliere", "nomFiliere =$filiername ")[0]->idFiliere;
                        if ($filierID) {
                            // check if group exists if it does not create it
                            $idgrp = getIdGrp($row[5], $filierID);
                            if (!$idgrp) {
                                $sql = $db->Insert("groupe", ["nomGroupe", "idFiliere"], [$row[5], $filierID]);
                            }
                            // insert Stagiaire 
                            $values = [$row[0], $row[1], $row[2], $idgrp];
                            pprint($values);
                            $sql = $db->Insert("stagiaire", ["CEF", "nomStagiaire", "prenomStagiaire", "idGroupe"], $values);
                            pprint($sql);
                            $msg = "Opération terminé avec succès&status=done";
                            return $msg;
                        }

                    }
                }
            } else {
                $msg = "Le fichier " . $fname . " ne respect pas le fichier exemplaire&status=error";
                return $msg;
            }
        }

        // Main Function 
        function insterinto($data, $table)
        {
            global $conn;
            array_shift($data);
            pprint($table);
            echo "<hr>";
            pprint($data);
            echo "<hr>";
            $funcName = "insert" . "$table";
            foreach ($data as $arr) {
                $msg = $funcName($arr);
            }
            if (empty($msg)) {
                header("location:../Importer" . $table . ".php?msg=Le contenu du fichier a déjà existé&status=done");
            } else {
                header("location:../Importer" . $table . ".php?msg=" . $msg);
            }

        }

        // geting data from the xlxs file
        $xlsx = new XLSXReader($file);
        $sheetNames = $xlsx->getSheetNames();
        foreach ($sheetNames as $sheetName) {
            $sheet = $xlsx->getSheet($sheetName);
            $data = $sheet->getData();
            insterinto($data, $table);
        }


    }

} else {
    header('location:../login.php');
}