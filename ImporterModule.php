<?php
include_once('./inc/DataBase.php');
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] !== "superAdmin") {
    header('location:./login.php');
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["AjaxValider"])) {

    $_SESSION["anneeScolaire"] = $_GET["annee-Scolaire"];
    $_SESSION["annee"] = $_GET["annee"];
    $_SESSION["filiere"] = $_GET["filiere"];
    // get filiere name
    $idf = $_GET["filiere"];
    $filiereName = $db->Select('filiere', "nomFiliere", "idFiliere = $idf")[0]->nomFiliere;
    // get all filiere
    $Modules = $db->Select('module', "nomModule", "idFiliere = $idf");
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

    <title>Importer Modules</title>

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
        });
    </script>


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
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-5 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h4 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">Modules</h4>
                    <a href="./logout.php" id="Déconnexion">
                        <i class="fas fa-sign-out-alt fa-lg fa-fw mr-2 text-gray-700" aria-hidden="true"></i>
                    </a>
                </nav>
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
                                <select id="année" name="annee" class="form-select" aria-label="Default select example"
                                    style=" 
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
                        <!-- Button Valider -->
                        <div class="col-xl-2 col-md-6 mb-4 ">
                            <button class="btn btn" type="submit" name="AjaxValider" id="valider"
                                style="background-color: #1b2f69;color:white"><i class="fas fa-check"></i>
                                Valider</button>
                        </div>
                    </div>
                </form>
                <!--form file -->
                <?php
                if (!empty($_GET['msg']) && ($_GET['status'] == "done")) {
                    echo '<h2 style="text-align: center;color : green;margin-top:2%">' . $_GET['msg'] . '</h2>';
                }
                if (!empty($_GET['msg']) && ($_GET['status'] == "error")) {
                    echo '<h2 style="text-align: center;color : red;margin-top:2%">' . $_GET['msg'] . '</h2>';
                }
                ?>
                <form method="POST" action="./inc/Main.php" enctype="multipart/form-data">
                    <div class="row align-items-center justify-content-center ">
                        <div class=" col-4  mr-2 mb-2 ml-3">
                            <div>
                                <input class="form-control " type="file" name="file" id="file">
                                <div><span id="lbimport"></span></div>
                            </div>
                        </div>
                        <div class="col-md-auto mb-2 ml-3 d-flex p-3">
                            <a href="./CSV_Files_Examples/Module.xlsx" download='Module.xlsx'>
                                <button class="btn" type="button" name="AjaxTelecharger" value="Telecharger" ;
                                    id="Telecharger" style="background-color: #1b2f69;color:white"><i
                                        class="fa fa-arrow-circle-down"></i> Télécharger</button></a>
                            <div class="ml-4">
                                <input type="hidden" name="table" value="Module">
                                <button class="btn mr-2 " style="background-color: #1b2f69;color:white" type="submit"
                                    name="AjaxValider" id="valider" onclick=" return vk()"><i class="fas fa-check"></i>
                                    Valider</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Table -->
                <?php
                if (!isset($_GET["AjaxValider"])) {
                    ?>
                    <h1 class="text-center mt-5"><span>&#8593;</span> - Veuillez sélectionner un filière -
                        <span>&#8593;</span>
                    </h1>
                    <?php
                } elseif (isset($_GET["AjaxValider"]) && empty($Modules)) {
                    ?>
                    <h1 class="text-center mt-5">Aucun module attribué à cette filière, veuillez selectionner une autre
                    </h1>
                    <?php
                } else {
                    ?>
                    <div class="card shadow mt-5 m-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h2 class='fname'>Filière :
                                    <?= $filiereName ?>
                                </h2>
                                <table class="table table-bordered table-hover" width="100%" cellspacing="0"
                                    style="text-align:center;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom module</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($Modules as $key => $value) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $value->nomModule ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div> <!-- table-responsive -->
                            <!-- Modal content -->

                            </table>
                        </div> <!-- table-responsive -->
                    </div>
                    <div class="text-center">
                        <button class="btn btn" type="button" name="AjaxValider" value="Valider" id="valider"
                            style="background-color: #1b2f69;color:white"> Insérer Formateur</button>
                    </div> <!-- card-body -->
                </div> <!-- card shadow -->
            <?php } ?>
            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto fs-6">
                        <span>© Copyright | WFS205 |2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>


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