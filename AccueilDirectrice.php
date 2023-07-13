<?php
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "directrice") {
    header('location:./login.php');
    exit();
}
include_once('./inc/DataBase.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["valider"])) {

    // get group name
    $idgrp = $_GET['groupe'];
    $grpName = $db->Select("groupe", 'nomGroupe', "idGroupe =$idgrp")[0]->nomGroupe;
    // get groupe Stg
    $idfil = $_GET["filiere"];
    $idanne = $_GET["annee"];
    $idanneS = $_GET["annee-Scolaire"];
    $table = "stagiaire";
    $cols = "CEF ,nomStagiaire,prenomStagiaire";
    $where = "idGroupe in 
    (select idGroupe from groupe where idGroupe= $idgrp and idFiliere in ( select idFiliere from filiere where 
    idFiliere= $idfil and idAnnee in 
    (select idAnnee from annee where idAnnee= $idanne and idAnneeScolaire in 
    (select idAnneeScolaire from anneescolaire where idAnneeScolaire= $idanneS)
    )))";
    $req = $db->Select($table, $cols, $where);

}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Accueil Directrice</title>
    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Ajax -->
    <script>
        $(document).ready(function () {
            $('#année-scolaire').on('change', function () {
                var annescolID = $(this).val();
                if (annescolID) {
                    $.get(
                        './inc/Ajax/AjaxSelect.php',
                        { annescolID: annescolID },
                        function (data) {
                            $('#année').html(data);
                        }
                    );
                }
            })
            $('#année').on('change', function () {
                var anneeID = $(this).val();
                if (anneeID) {
                    $.get(
                        './inc/Ajax/AjaxSelect.php',
                        { anneeID: anneeID },
                        function (data) {
                            $('#filiére').html(data);
                        }
                    );
                }
            })
            $('#filiére').on('change', function () {
                var filiereID = $(this).val();
                if (filiereID) {
                    $.get(
                        './inc/Ajax/AjaxSelect.php',
                        { filiereID: filiereID },
                        function (data) {
                            $('#groupe').html(data);
                        }
                    );
                }
            })
        });
    </script>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Sidebar Toggler (Sidebar) -->
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand topbar  mb-5 static-top shadow" style="background-color: #1b2f69;">
                    <dt class="mr-auto ml-md-3 my-2 my-md-0 mw-100" style="color:white">Accueil Directrice</dt>
                    <div class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <i
                                    class="fas fa-user fa-lg fa-fw mr-2 text-gray-400"></i></span>

                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="./DrictPass.php">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Modifier Mot de passe
                            </a>

                            <div class="dropdown-divider"></div>
                            <a href="./logout.php" class="dropdown-item"><i
                                    class="fas mr-1 fa-sign-out-alt fa-md fa-fw text-gray-400"
                                    style="color:white"></i>Logout</a>
                        </div>
                    </div>

                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <form method="GET">
                        <div class="row align-items-center justify-content-center">
                            <!-- Select Année Scolaire-->
                            <?php
                            $anneescolaire = $db->Select("anneescolaire");
                            ?>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="col">
                                    <select id="année-scolaire" name="annee-Scolaire" class="form-select"
                                        aria-label="Default select example" style=" 
                                    color: gray;
                                    border-radius: 7px;
                                    font-size: 16px;
                                    outline: none;
                                    border-left: .25rem solid #3453af!important" required>
                                        <option value="" selected disabled>Année scolaire</option>
                                        <?php
                                        if (!empty($anneescolaire)) {
                                            foreach ($anneescolaire as $key => $value) {
                                                ?>
                                                <option value="<?= $value->idAnneeScolaire ?>">
                                                    <?= $value->nomAnneeScolaire ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Select Année -->
                            <div class="col-xl-2 col-md-6 mb-4">
                                <div class="col">
                                    <select id="année" name="annee" class="form-select"
                                        aria-label="Default select example" style=" 
                                    color: gray;
                                    border-radius: 7px;
                                    font-size: 16px;
                                    outline: none;
                                    border-left: .25rem solid #3453af!important" required></select>
                                </div>
                            </div>
                            <!-- Select Filière -->
                            <div class="col-xl-2 col-md-6 mb-4">
                                <div class="col">
                                    <select id="filiére" name="filiere" class="form-select"
                                        aria-label="Default select example" style=" 
                                    color: gray;
                                    border-radius: 7px;
                                    font-size: 16px;
                                    outline: none;
                                    border-left: .25rem solid #3453af!important" required></select>
                                </div>
                            </div>
                            <!-- Select Groupe -->
                            <div class="col-xl-2 col-md-6 mb-4">
                                <div class="col">
                                    <select id="groupe" name="groupe" class="form-select"
                                        aria-label="Default select example" style="
                                    color: gray;
                                    border-radius: 7px;
                                    font-size: 16px;
                                    outline: none;
                                    border-left: .25rem solid #3453af!important" required></select>
                                </div>
                            </div>
                            <!-- Button Valider -->
                            <div class="col-xl-2 col-md-6 mb-4">
                                <button class="btn btn" type="submit" name="valider" id="valider"
                                    style="background-color: #1b2f69;color:white"><i class="fas fa-check"></i>
                                    Valider</button>
                            </div>
                        </div>
                    </form>
                    <!-- Début Table -->
                    <?php if (empty($req)) {
                        echo "<div class='vh-100 text-center mt-5 fs-2'> Veuillez sélectionner un groupe</div>";
                    } else { ?>
                        <div class="card shadow mt-5 mb-5" id="noteTable">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary" style="text-align:center">Liste du groupe
                                    <?= $grpName ?>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%"
                                        cellspacing="0" style="text-align:center">

                                        <thead class="table-light">
                                            <tr>
                                                <th>CEF</th>
                                                <th>Nom</th>
                                                <th>Prénom</th>
                                                <th>Nombre d'absence</th>
                                                <th>Nombre de retard</th>
                                                <th>Note </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            foreach ($req as $key => $value) {
                                                // count absence
                                                $countAbs = $db->Select("absence", "count(idAbsence) as NombreAbsence", "CEF = $value->CEF and type='absence'")[0]->NombreAbsence;
                                                // count retard
                                                $countRet = $db->Select("absence", "count(idAbsence) as NombreAbsence", "CEF = $value->CEF and type='retard'")[0]->NombreAbsence;
                                                // Note
                                                $note = $db->Select("note", "Note", "CEF  = $value->CEF")[0]->Note;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $value->CEF ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->nomStagiaire ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->prenomStagiaire ?>
                                                    </td>
                                                    <td>
                                                        <?= $countAbs ?>
                                                    </td>
                                                    <td>
                                                        <?= $countRet ?>
                                                    </td>

                                                    <td>
                                                        <?= $note ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!--Fermeture div class table responsive-->
                            </div> <!--Fermeture div class card-body-->
                        </div> <!--card shadow-->
                        <!-- Fin Table -->
                        <?php
                    }
                    ?>
                    <button type="button" class="btn btn-success float-left  mb-5"
                        onclick="printJS('noteTable', 'html')">
                        imprimer le tableau
                    </button>
                </div> <!-- Fermeture div class container-fluid-->
            </div> <!--Fermeture div class content-->
        </div> <!--Fermeture div content-wrapper -->
    </div> <!--Fermeture div id=wrapper-->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>