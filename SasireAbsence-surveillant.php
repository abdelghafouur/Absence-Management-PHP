<?php
include_once('./inc/DataBase.php');
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] !== "serveillant") {
    header('location:./login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["AjaxValider"])) {
    $_SESSION["anneeScolaire"] = $_GET["annee-Scolaire"];
    $_SESSION["annee"] = $_GET["annee"];
    $_SESSION["filiere"] = $_GET["filiere"];
    $_SESSION["groupe"] = $_GET["groupe"];

    $idgrp = $_GET["groupe"];
    $grp = $db->Select("groupe", "*", "idGroupe = $idgrp");
    $idf = $grp[0]->idFiliere;
    $listStg = $db->Select('stagiaire', "*", "idGroupe =$idgrp");

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

    <title>Saisie des absences </title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!---- Notyf JS ---->
    <link rel="stylesheet" href="./vendor/notif/css/iziToast.min.css">
    <script src="./vendor/notif/js/iziToast.min.js" type="text/javascript"></script>
    <!---- Notyf JS ---->
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Ajax -->
    <script>
        $(document).ready(function () {
            const countrow = parseInt($('#trcount').val())
            $('#buttonValider').click(function (e) {
                let countDubt = 0
                let countFin = 0
                let checkboxLength2 = $("input:checkbox:checked").length
                let errorgenral = 1
                let breaker = false
                for (i = 1; i <= countrow; i++) {
                    if (breaker) {
                        break
                    }
                    let checkboxLength = $("#tr-" + i + " input:checkbox:checked").length
                    if (checkboxLength == 1) {
                        $("#tr-" + i + " input[type=time]").each(function () {
                            let debut = 0
                            let fin = 0
                            if ($(this).hasClass("debut")) {
                                if ($(this).val() != '') {
                                    debut = 1
                                }
                            }
                            if ($(this).hasClass("fin")) {
                                if ($(this).val() != '') {
                                    fin = 1

                                }
                            }

                            if (debut !== 1 && fin !== 1) {
                                $('#tr-' + i).css({
                                    "color": "red",
                                });
                                errorgenral = 1
                                breaker = true
                                return false
                            } else {
                                $('#tr-' + i).css({
                                    "color": "green",
                                });
                                errorgenral = 0
                            }
                        })
                    } else {
                        $('#tr-' + i).css({
                            "color": "black",
                        });
                    }
                }
                if (errorgenral == 0 && $("#date").val() != "" && $("#").val() != "" && $("#module").val() != "") {
                    if (confirm("Enregistré avec succès") != true) {
                        e.preventDefault()
                    }
                } else {
                    e.preventDefault()
                    alert('vous avez oublié quelque chose, veuillez revérifier ce que vous avez saisi')
                }
            })
            // Ajax for Select Filter
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
            });
        });
    </script>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
            style="background-image:linear-gradient(#1b2f69 10%,#1b2f69 100%);">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./Accueil-serveillant.php">
                <img src="img/Ofpptlogo.png " class="w-50 p-3">
                <div class="sidebar-brand-text mx-3">OFPPT</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="./Accueil-serveillant.php">
                    <i class="fa fa-home"></i>
                    <span>Accueil</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-users"></i>
                    <span>Stagiaires</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item active" href="./modifier-stagiere.php">Liste des stagiaires</a>
                        <a class="collapse-item active" href="./modifier-Groupe.php">Changer le groupe</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa fa-window-close"></i>
                    <span>Absence</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item active" href="./Affichage-surveillant.php">Affichage</a>
                        <a class="collapse-item active" href="./SasireAbsence-surveillant.php">Saisie</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./Absence_Justifier.php">
                    <i class="fa fa-check-square"></i>
                    <span>Justification</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./note.php">
                    <i class="fa fa-calculator"></i>
                    <span>Notes</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./Deperdition.php">
                    <i class="fa fa-archive"></i>
                    <span>Déperdition</span></a>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="./ChangerPasswordSurveillant.php
">
                    <i class="fa fa-lock"></i>
                    <span>Changer le mot de passe</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-5 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h4 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">Saisie des absences</h4>

                    <a href="./logout.php" id="Déconnexion">
                        <i class="fas fa-sign-out-alt fa-lg fa-fw mr-2 text-gray-700" aria-hidden="true"></i>
                    </a>
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
                                <button class="btn btn" type="submit" name="AjaxValider" id="AjaxValider"
                                    style="background-color: #1b2f69;color:white"><i class="fas fa-check"></i>
                                    Valider</button>
                            </div>
                        </div>
                    </form>
                    <!--End of form-->
                    <!-- Table -->
                    <?php
                    if (!isset($_GET["AjaxValider"])) {
                        ?>
                        <h1 class="text-center mt-5"><span>&#8593;</span> - Veuillez sélectionner un groupe -
                            <span>&#8593;</span>
                        </h1>
                        <?php
                    } else {
                        ?>
                        <form action="./inc/Ajax/InsertAbsenceRespo.php" method="GET" id="form">
                            <div class="card shadow mt-5">
                                <div class="card-header py-3">
                                    <div class="row align-items-center justify-content-center" class="selects">
                                        <div class=" col-md-6 ">
                                            <h6 class=" font-weight-bold text-primary " id="bienvenue">Groupe WFS 205</h6>
                                        </div>
                                        <!-- Date-->
                                        <div class="col-xl-2 col-md-6 ">
                                            <div class="col">
                                                <input type="date" class="form-select border-left-primary"
                                                    aria-label="Default select example"
                                                    style="color: gray;border-radius: 7px;font-size: 16px;outline: none;border-left: .25rem solid #3453af!important;"
                                                    name="date" id="Date" required>

                                            </div>
                                        </div>
                                        <!-- Formateur -->
                                        <div class="col-xl-2 col-md-6 ">
                                            <div class="col">
                                                <select class="form-select border-left-primary"
                                                    aria-label="Default select example"
                                                    style="color: gray;border-radius: 7px;font-size: 16px;outline: none;border-left: .25rem solid #3453af!important;"
                                                    id="Formateur" name="formateur" required>
                                                    <option value="" disabled selected>Formateur</option>
                                                    <?php
                                                    $formateur = $db->Select("formateur");
                                                    if (isset($formateur)) {
                                                        foreach ($formateur as $key => $value) {
                                                            ?>
                                                            <option value=<?= $value->Matricule ?>>
                                                                <?= $value->nomFormateur . ' ' . $value->prenomFormateur ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Module -->
                                        <div class="col-xl-2 col-md-6 ">
                                            <div class="col">
                                                <select class="form-select" aria-label="Default select example"
                                                    style="color: gray;border-radius: 7px;font-size: 16px;outline: none;border-left: .25rem solid #3453af!important;"
                                                    id="Module" name="module" required>
                                                    <option value="" disabled selected>Module</option>
                                                    <?php
                                                    $module = $db->Select("module", '*', "idFiliere = $idf");
                                                    if (isset($module)) {
                                                        foreach ($module as $key => $value) {
                                                            ?>
                                                            <option value=<?= $value->idModule ?>>
                                                                <?= $value->nomModule ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable" width="100%"
                                            cellspacing="0" style="text-align:center">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Prénom</th>
                                                    <th>Absence</th>
                                                    <th>Retard</th>
                                                    <th>Heure début</th>
                                                    <th>Heure fin</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                if (!empty($listStg)) {
                                                    $c = 1;
                                                    foreach ($listStg as $key => $value) {
                                                        $cef = $value->CEF;
                                                        $_SESSION['idgrp'] = $value->idGroupe
                                                            ?>
                                                        <tr id="tr-<?= $c++ ?>">
                                                            <td>
                                                                <?= $value->nomStagiaire ?>
                                                            </td>
                                                            <td>
                                                                <?= $value->prenomStagiaire ?>
                                                            </td>
                                                            <td><input type="checkbox" name="absence-<?= $cef ?>" id="btnAb"
                                                                    value="absence" /></td>
                                                            <td><input type="checkbox" name="retard-<?= $cef ?>" id="btnRet"
                                                                    value="retard" /></td>
                                                            <td><input type="time" class="debut" name="debut-<?= $cef ?>" min="8:30"
                                                                    max="18:30"></td>
                                                            <td> <input type="time" class="fin" name="Fin-<?= $cef ?>" min="8:30"
                                                                    max="18:30"></td>
                                                        </tr>

                                                        <?php

                                                    }
                                                }
                                                ?>
                                                <input type="hidden" id="trcount" value="<?= $c ?>" />
                                            </tbody>
                                        </table>
                                        <!-- Button Valider -->
                                        <div class="col-xl-2 col-md-6 mb-4 float-right ">
                                            <button class="btn btn" type="submit" value="Valider" name="valider"
                                                id="buttonValider" style="background-color: #1b2f69;color:white"><i
                                                    class="fas fa-check"></i>
                                                Valider</button>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        <?php } ?>
                        <from />
                </div>
            </div>
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto fs-6">
                        <span>© Copyright | WFS205 |2022</span>
                    </div>
                </div>
            </footer>

        </div>
        <!-- content wrapper -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>
    <!--End wrapper -->
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <?php
    if (!empty($_GET['success'])) {
        ?>
        <script>
            iziToast.success({
                title: 'OK',
                message: 'les absence et bien enregistré!',
            })
        </script>
        <?php
    } elseif (!empty($_GET['error'])) {
        ?>
        <script>
            iziToast.error({
                title: 'Attention...',
                message: 'veuillez vérifier les informations saisies!',
            });
        </script>
        <?php
    }
    ?>

</body>

</html>