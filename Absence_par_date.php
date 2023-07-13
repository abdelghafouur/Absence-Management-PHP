<?php
include_once('./inc/DataBase.php');
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] !== "serveillant") {
    header('location:./login.php');
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //get date 
    $dateAbsence = $_GET["date-sent"];
    // get the type
    $type = "";
    if (isset($_GET['absence'])) {
        $type = 'absence';
    }
    if (isset($_GET['retard'])) {
        $type = 'retard';
    }
    // sql query 
    $table = "absence a ,groupe g ,stagiaire s ,formateur f";
    $columns = "a.CEF ,s.nomStagiaire,s.prenomStagiaire,concat(f.nomFormateur,' ',f.PrenomFormateur) as fullname ,a.type,a.heureDebutAbsence,a.heureFinAbsence,a.idAbsence,moduleAbsence,g.nomGroupe";
    $where = "s.CEF=a.CEF and a.matricule=f.matricule and a.idGroupe=g.idGroupe and a.dateAbsence= '$dateAbsence' and a.type= '$type' and a.justifier = 'no' ";
    $absByDate = $db->Select($table, $columns, $where);
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
    <title>Absence</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .btn-primary {
            width: 20%;
            position: relative;
            left: 80%;
        }
    </style>
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!---- Notyf JS ---->
    <link rel="stylesheet" href="./vendor/notif/css/iziToast.min.css">
    <script src="./vendor/notif/js/iziToast.min.js" type="text/javascript"></script>
    <!---- Notyf JS ---->
    <!-- Ajax -->
    <script>
        $(document).ready(function () {
            $("#back_btn").click(function (ev) {
                ev.preventDefault()
                window.history.back();
            });
            let errorgenral = 1
            const countrow = parseInt($('#trcount').val())
            $('#validee').click(function (ev) {
                alert(countrow)
                for (i = 0; i <= countrow; i++) {
                    let checkboxLength = $("#tr-" + i + " input:checkbox:checked").length
                    if (checkboxLength == 1) {
                        if ($("#tr-" + i + " input[type=text]").val() == "") {
                            $('#tr-' + i).css({
                                "color": "red",
                            });
                            errorgenral = 1
                        } else {
                            errorgenral = 0
                            $('#tr-' + i).css({
                                "color": "green",
                            });
                        }
                    } else {
                        $('#tr-' + i).css({
                            "color": "black",
                        });
                    }
                }
                if (errorgenral == 0) {
                    iziToast.success({
                        // position: 'top-end',
                        title: 'OK',
                        message: 'Enregistré avec succès',
                    })
                } else {
                    ev.preventDefault()
                    iziToast.error({
                        title: 'Attention...',
                        message: 'vous avez oublié quelque chose, veuillez revérifier ce que vous avez saisi!',
                    });
                }
            })
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
        <!-- Begin Page Content -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-5 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h4 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">Liste des
                        <?= $type ?>s
                    </h4>
                    <a href="./logout.php" id="Déconnexion">
                        <i class="fas fa-sign-out-alt fa-lg fa-fw mr-2 text-gray-700" aria-hidden="true"></i>
                    </a>
                </nav>
                <!-- Table -->
                <div class="card shadow mt-5 m-3">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Le :
                            <?= $dateAbsence ?>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php
                            if (empty($absByDate)) {
                                ?>
                                <H1>Aucune absence ou retard ce jour</H1>
                                <button class="btn btn-success float-left  mb-5" id="back_btn">Retourner</button>
                                <?php
                            } else {
                                ?>
                                <form method="POST" action="./inc/Ajax/JestufierAbs.php">
                                    <table class="table table-bordered table-hover" width="100%" cellspacing="0"
                                        style="text-align:center;">
                                        <thead class="table-light">
                                            <tr>
                                                <th>CEF</th>
                                                <th>Nom</th>
                                                <th>Prénom</th>
                                                <th>Type</th>
                                                <th>Formateur</th>
                                                <th>Groupe</th>
                                                <th>Module</th>
                                                <th>Heure début</th>
                                                <th>Heure fin</th>
                                                <th>Justifier</th>
                                                <th>Nature de justification</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $c = 0;
                                            foreach ($absByDate as $key => $value) {
                                                ?>
                                                <tr id="tr-<?= $c++ ?>">
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
                                                        <?= $value->type ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->fullname ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->nomGroupe ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->moduleAbsence ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->heureDebutAbsence ?>
                                                    </td>
                                                    <td>
                                                        <?= $value->heureFinAbsence ?>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" class="btn1" name="check-btn-<?= $value->CEF ?>"
                                                            id="justifier" value="justifier" onclick="Enable(this)">
                                                    </td>
                                                    <td>
                                                        <input disabled type="text" name="justif-<?= $value->CEF ?>"
                                                            id="justification" name="justification" class="commentaire">
                                                    </td>
                                                    <input type="hidden" name="idAbs-<?= $value->CEF ?>"
                                                        value="<?= $value->idAbsence ?>" />
                                                </tr>
                                            </tbody>
                                            <?php

                                            }
                                            ?>

                                        <tfoot>
                                        </tfoot>
                                        <input type="hidden" id="trcount" value="<?= $c ?>" />
                                    </table>
                                    <input class="btn btn-success float-left  mb-5" type="submit" value="valider"
                                        id="validee" class='button' name="sent-verf" />
                                </form>
                                <?php

                            }
                            ?>
                        </div> <!-- table-responsive -->

                    </div>
                </div>
                <!-- content -->
            </div>
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto fs-6">
                        <span>© Copyright | WFS205 |2022</span>
                    </div>
                </div>
            </footer> <!-- content wrapper -->
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        </div> <!--End wrapper -->
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
        <!-- Page level plugins -->
        <script>
            let Commentaire = document.getElementsByClassName("commentaire");
            let btn = document.getElementsByClassName("btn1");
            let nombre1 = btn.length;
            let nombre2 = Commentaire.length;
            function Enable() {
                for (i = 0; i < nombre1; i++) {
                    if (btn[i].checked == true) {
                        Commentaire[i].removeAttribute("disabled");
                        // Commentaire[i].style.backgroundColor = 'rgb(232, 236, 239)';
                    } else {
                        btn.disabled = "true";
                        Commentaire[i].setAttribute("disabled", "");
                        Commentaire[i].value = "";
                        // Commentaire[i].style.backgroundColor = 'rgb(140, 138, 138)';
                    }
                }
            }
        </script>
</body>

</html>