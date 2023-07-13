<?php
include_once('./inc/DataBase.php');
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
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

    <title>Changer le groupe</title>

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
            })
            // Ajax for Change stagiaire Groupe
            $('#valider').on('click', function (ev) {
                const grpid = $("#groupe").val();
                const cef = $('#cef').val();
                console.log(cef);
                if (grpid != null && cef !== "") {
                    $.ajax({
                        type: 'GET',
                        url: './inc/Ajax/ChangeStgGroup.php',
                        data: {
                            grpid: grpid,
                            cef: cef
                        },
                        success: function (data) {
                            $("#result").html(data)
                        }
                    })
                } else {
                    ev.preventDefault()
                    alert('Veuillez vérifier votre saisie et réessayer. ')
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
        <!-- Content Wrapper -->
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
                    <h4 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">Changer le groupe d'un stagiaire
                    </h4>

                    <a href="./logout.php" id="Déconnexion">
                        <i class="fas fa-sign-out-alt fa-lg fa-fw mr-2 text-gray-700" aria-hidden="true"></i>
                    </a>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->


                <div class="row">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-6 col-md-10 mb-12 mx-auto mr-3">
                        <div class="card shadow h-100 py-2 justify-content-center align-items-center"
                            style="border-left: .25rem solid #3453af!important;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">

                                    <div class="container">
                                        <table class="frm">
                                            <tr>
                                                <th><label for="CEF">CEF :</label></th>
                                                <td><input type="text" class="form-control mb-2" id="cef" name="cef"
                                                        style=" border-left: .25rem solid #3453af!important"
                                                        autocomplete="off" required>
                                                </td>
                                            </tr>
                                            <!-- Année scolaire -->
                                            <tr>
                                                <?php
                                                $anneescolaire = $db->Select("anneescolaire");
                                                ?>
                                                <th><label for="année-scolaire">Année scolaire :</label></th>
                                                <td>
                                                    <select class="form-select border-left-primary mb-2"
                                                        id="année-scolaire" aria-label="Default select example" style="
                                                            color: gray;
                                                            border-radius: 7px;
                                                            font-size: 16px;
                                                            outline: none;
                                                            border-left: .25rem solid #3453af!important;" required>
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
                                                </td>
                                            </tr>
                                            <!-- Année -->
                                            <tr>
                                                <th><label for="année-scolaire">Année :</label></th>
                                                <td>

                                                    <select class="form-select border-left-primary mb-2" id="année"
                                                        aria-label="Default select example" style="
                                                            color: gray;
                                                            border-radius: 7px;
                                                            font-size: 16px;
                                                            outline: none;
                                                            border-left: .25rem solid #3453af!important;" required>
                                                    </select>
                                                </td>
                                            </tr>
                                            <!-- Filliére -->
                                            <tr>
                                                <th><label for="année-scolaire">Filière :</label></th>
                                                <td>

                                                    <select class="form-select border-left-primary mb-2" id="filiére"
                                                        aria-label="Default select example" style="
                                                            color: gray;
                                                            border-radius: 7px;
                                                            font-size: 16px;
                                                            outline: none;
                                                            border-left: .25rem solid #3453af!important;" required>


                                                    </select>
                                                </td>
                                            </tr>
                                            <!-- Groupe -->
                                            <tr>
                                                <th><label for="année-scolaire">Groupe :</label></th>
                                                <td>

                                                    <select id="groupe" class="form-select border-left-primary"
                                                        aria-label="Default select example" style="
                                                            color: gray;
                                                            border-radius: 7px;
                                                            font-size: 16px;
                                                            outline: none;
                                                            border-left: .25rem solid #3453af!important;" required>
                                                    </select>
                                                </td>
                                            </tr>
                                            <!-- button -->
                                            <tr>
                                                <td>
                                                    <div class="row ml-5 mt-5 justify-content-center">
                                                        <button class="btn" name="valider" id="valider"
                                                            style="background-color: #3453af;color:white"><i
                                                                class="fas fa-check"></i> Valider</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        </d>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Footer --><!-- content -->
                <footer class="sticky-footer">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto fs-6">
                            <span>© Copyright | WFS205 |2022</span>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- End of Content Wrapper -->


        </div>

    </div>

    <!-- Footer -->

    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <input type="hidden" id="result">
</body>

</html>