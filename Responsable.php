<?php
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "stagiaire") {
    header('location:./login.php');
}
include_once './inc/DataBase.php';
?>
<?php
$cef = $_SESSION['LoginUser'];
$request = $db->Select("stagiaire", "*", "CEF = $cef");
$idgrp = $request[0]->idGroupe;
$StgfullName = $request[0]->nomStagiaire . " " . $request[0]->prenomStagiaire;
$grp = $db->Select("groupe", "*", "idGroupe = $idgrp");
$idf = $grp[0]->idFiliere;
$listStg = $db->Select('stagiaire', "*", "idGroupe =$idgrp");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="./img/Ofpptlogo.png" type="image/x-icon">
    <title>Espace des responsables </title>
    <!-- Custom fonts for this template-->
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
                    <dt class="mr-auto ml-md-3 my-2 my-md-0 mw-100" style="color:white">Espace du responsable :
                        <?= $StgfullName ?>
                    </dt>
                    <!-- + le nom du responsable de grp ajouté avec le php-->
                    <div class="nav-item dropdown no-arrow mt-2">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2  d-lg-inline text-gray-600 medium"> <i
                                    class="fas fa-user fa-lg fa-fw mr-2 text-gray-400"></i></span>

                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="./RespoPass.php">
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
                    <form action="./inc/Ajax/InsertAbsenceRespo.php" method="GET" id="form">
                        <div class="row align-items-center justify-content-center">
                            <!--  Date -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="col">
                                    <input type="date" class="form-control" name="date" id="date"
                                        style=" border-left: .20rem solid #3453af!important" autocomplete="off"
                                        required>
                                </div>
                            </div>

                            <!-- Select Formateur -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="col">
                                    <select name="formateur" id="formateur" class="form-select"
                                        aria-label="Default select example" style=" 
                                        color: gray;
                                        border-radius: 7px;
                                        font-size: 16px;
                                        outline: none;
                                        border-left: .25rem solid #3453af!important" required>
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
                            <!-- Select Module -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="col">
                                    <select name="module" id="module" class="form-select"
                                        aria-label="Default select example" style=" 
                                        color: gray;
                                        border-radius: 7px;
                                        font-size: 16px;
                                        outline: none;
                                        border-left: .25rem solid #3453af!important" required>
                                        <option value="" disabled selected>Module</option>
                                        <?php
                                        $module = $db->Select("module", '*', "idFiliere =$idf");
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
                        <!-- Début Table -->
                        <div class="card shadow mt-5 mb-5">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary" style="text-align:center">Liste du groupe
                                    <?= $grp[0]->nomGroupe ?>
                                </h6>
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
                                </div> <!--Fermeture div class table responsive-->
                            </div> <!--Fermeture div class card-body-->
                        </div> <!--card shadow-->
                        <!-- Fin Table -->
                    </form>
                </div> <!-- Fermeture div class container-fluid-->
            </div> <!--Fermeture div class content-->
        </div> <!--Fermeture div content-wrapper -->
    </div> <!--Fermeture div id=wrapper-->

    <!-- Footer -->

    <footer class="sticky-footer  text-gray-700 ">
        <div class="container my-auto">
            <div class="copyright text-center my-auto fs-5">
                <span>Copyright &copy; Dev205</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->
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
    <!-- alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    if (!empty($_GET['success'])) {
        ?>
        <script>
            swal("Good job!", "les absence et bien enregistré!", "success");
        </script>
        <?php
    } elseif (!empty($_GET['error'])) {
        ?>
        <script>
            swal("Good job!", "veuillez vérifier les informations saisies!", "error");
        </script>
        <?php
    }
    ?>
</body>

</html>