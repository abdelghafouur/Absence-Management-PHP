<?php
include_once('./inc/DataBase.php');
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] !== "superAdmin") {
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

    <title>Importer Stagiaire</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
            style="background-image:linear-gradient(#1b2f69 10%,#1b2f69 100%)">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./creation.php">
                <img src="img/Ofpptlogo.png " class="w-50 p-3">
                <div class="sidebar-brand-text mx-3">OFPPT</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="./creation.php">
                    <i class="fa fa-plus"></i>
                    <span>Création des filières</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./ImporterModule.php">
                    <i class="fa fa-book"></i>
                    <span>Modules</span></a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="./ImporterStagiaire.php">
                    <i class="fa fa-users"></i>
                    <span>Stagiaires</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./ImporterFormateur.php">
                    <i class="fa fa-user-plus"></i>
                    <span>Formateurs</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./userManager.html">
                    <i class="fa fa-user-plus"></i>
                    <span>Gestionnaire d'utilisateurs</span></a>
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
        <div id="content-wrapper" class="d-flex flex-column justify-content-between">

            <!-- Main Content -->
            <div id="content mb-5 ">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-5 static-top shadow">
                    <h4 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">Stagiaires</h4>
                    <a href="./logout.php" id="Déconnexion">
                        <i class="fas fa-sign-out-alt fa-lg fa-fw mr-2 text-gray-700" aria-hidden="true"></i>
                    </a>
                </nav>
                <form method="POST" action="./inc/Main.php" enctype="multipart/form-data">
                    <div class="container">
                        <div class=" d-flex justify-content-center align-items-center">
                            <div class="  mb-1 mt-5 ">
                                <select class="form-select" name="annee-Scolaire" aria-label="Default select example"
                                    style="
                                                        color: gray;
                                                        border-radius: 7px;
                                                        font-size: 16px;
                                                        outline: none;
                                                        border-left: .25rem solid #1b2f69!important;" required>

                                    <option value="" selected disabled>Année scolaire</option>
                                    <?php
                                    $anneescolaire = $db->Select("anneescolaire");
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
                        <?php
                        if (!empty($_GET['msg']) && ($_GET['status'] == "done")) {
                            echo '<h2 style="text-align: center;color : green;margin-top:2%">' . $_GET['msg'] . '</h2>';
                        }
                        if (!empty($_GET['msg']) && ($_GET['status'] == "error")) {
                            echo '<h2 style="text-align: center;color : red;margin-top:2%">' . $_GET['msg'] . '</h2>';
                        }
                        ?>
                        <div class="container-fluid">
                            <div class="row align-items-center justify-content-center ">
                                <div class=" col-4  mr-2 mb-2 ml-3">
                                    <div>
                                        <input class="form-control " type="file" name="file" id="file">
                                        <div><span id="lbimport"></span></div>
                                    </div>
                                </div>
                                <div class="col-md-auto mb-2 ml-3 d-flex p-3">
                                    <a href="./CSV_Files_Examples/Stagiaire.xlsx" download='Stagiaire.xlsx'>
                                        <button class="btn" type="button" name="AjaxTelecharger" value="Telecharger" ;
                                            id="Telecharger" style="background-color: #1b2f69;color:white"><i
                                                class="fa fa-arrow-circle-down"></i> Télécharger</button></a>
                                    <div class="ml-4">
                                        <input type="hidden" name="table" value="Stagiaire">
                                        <button class="btn mr-2 " style="background-color: #1b2f69;color:white"
                                            type="submit" name="submit" onclick=" return vk()"><i
                                                class="fas fa-check"></i>
                                            Valider</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
            <!-- /.container-fluid -->
            <!-- Footer -->
            <footer class="pt-4 my-md-5 pt-md-5 border-top mt-5">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto fs-6">
                        <span>© Copyright | WFS205 |2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>

            </div>
        </div>
    </div>
    </div>
</body>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>
<script src="js/demo/chart-bar-demo.js"></script>

<!--javascript-->
<script>
    var file = document.getElementById('file')
    var lbimport = document.getElementById('lbimport')
    function vk() {
        var etat;
        if (file.value == '') {
            etat = false
            lbimport.innerHTML = "Veuillez vérifier votre fichier d'importation "
        }
        else {
            etat = true
        }
        return etat
    }
</script>

</body>

</html>