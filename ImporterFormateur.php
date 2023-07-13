<?php
include_once('./inc/DataBase.php');
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] !== "superAdmin") {
    header('location:./login.php');
}
?>
<?php
$formateur = $db->Select('formateur', "*");
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Importer Formateur</title>

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
            // ajax for Delete Formateur

            $(".send").on("click", function () {
                const matricule = $(this).val()
                alert(matricule);
                if (matricule) {
                    $.get({
                        url: './inc/Ajax/DeleteFormateur.php ',
                        data: { matricule: matricule },
                        success: function (data) {
                            $("#success-delete").html(data)
                        }
                    });
                }
            })

        })
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
                    <h4 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">Formateurs</h4>
                    <a href="./logout.php" id="Déconnexion">
                        <i class="fas fa-sign-out-alt fa-lg fa-fw mr-2 text-gray-700" aria-hidden="true"></i>
                    </a>
                </nav>
                <div class="row">
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
                                <a href="./CSV_Files_Examples/Formateur.xlsx" download='Formateur.xlsx'>
                                    <button class="btn" type="button" name="AjaxTelecharger" value="Telecharger" ;
                                        id="Telecharger" style="background-color: #1b2f69;color:white"><i
                                            class="fa fa-arrow-circle-down"></i> Télécharger</button></a>
                                <div class="ml-4">
                                    <input type="hidden" name="table" value="Formateur">
                                    <button class="btn mr-2 " style="background-color: #1b2f69;color:white"
                                        type="submit" name="AjaxValider" id="valider" onclick=" return vk()"><i
                                            class="fas fa-check"></i>
                                        Valider</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table -->
                <?php
                if (empty($formateur)) {
                    echo "<div class='first-msg'> Formateur inexistant </div>";
                } else {
                    ?>
                    <div class="card shadow mt-5 m-3">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" id="bienvenue">La list du Formateurs</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" width="100%" cellspacing="0"
                                    style="text-align:center;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Matricule</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Supprimer</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($formateur as $key => $value) {

                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $value->Matricule ?>
                                                </td>
                                                <td>
                                                    <?= $value->nomFormateur ?>
                                                </td>
                                                <td>
                                                    <?= $value->prenomFormateur ?>
                                                </td>

                                                <td>
                                                    <div class="form-check form-switch">

                                                        <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                                        <input class="form-check-input send" type="checkbox" role="switch"
                                                            id="flexSwitchCheckDefault" value=<?= $value->Matricule ?>>

                                                    </div>
                                                </td>

                                            </tr>
                                        </tbody>
                                    <?php } ?>

                                </table>
                            </div> <!-- table-responsive -->
                        </div> <!-- table-responsive -->
                    </div> <!-- card-body -->
                </div> <!-- card shadow -->
            <?php } ?>
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto fs-6">
                        <span>© Copyright | WFS205 |2022</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
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
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="success-delete"></input>
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