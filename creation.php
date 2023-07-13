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

    <title>Création</title>

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
                <a class="nav-link" href="./ImporterModule.html">
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
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-5 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h4 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">Création des filières</h4>

                    <a href="./logout.php" id="Déconnexion">
                        <i class="fas fa-sign-out-alt fa-lg fa-fw mr-2 text-gray-700" aria-hidden="true"></i>
                    </a>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="row">
                    <!-- Earnings (Monthly) Card Example -->
                    <!-- <div class="col-xl-6 col-md-10 mb-12 mx-auto mr-3 ">
                        <div class="card shadow h-100 py-2 justify-content-center align-items-center m-4" style="border-left: .25rem solid #1b2f69!important;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <form method="POST" class="container">
                                        <table class="frm">
                                             Année scolaire -->
                    <!-- <tr>
                                                <th><label for="année-scolaire">Année scolaire :</label></th>
                                                <td> -->

                    <!-- <select class="form-select m-2" aria-label="Default select example" style="
                                                                    color: gray;
                                                                    border-radius: 7px;
                                                                    font-size: 16px;
                                                                    outline: none;
                                                                    border-left: .25rem solid #1b2f69!important;" required id="année-scolaire">
                                                        <option value="">Année scolaire</option>
                                                        <option value="">2021</option>
                                                        <option value="">2021</option>
                                                    </select>
                                                </td> -->
                    <!-- </tr> 
                                            Année -->
                    <!-- <tr>
                                                <th><label for="année-scolaire">Année :</label></th>
                                                <td>

                                                    <select class="form-select border-left-primary m-2" aria-label="Default select example" style="
                                                                    color: gray;
                                                                    border-radius: 7px;
                                                                    font-size: 16px;
                                                                    outline: none;
                                                                    border-left: .25rem solid #1b2f69!important;" required id="année">
                                                        <option value="">Année</option>
                                                        <option value="">2021</option>
                                                        <option value="">2022</option>
                                                    </select>
                                                </td>
                                            </tr> -->
                    <!-- <tr>
                                                <th><label for="Nombre_Filere">Nombre des filières :</label></th>
                                                <td><input id="nom" type="text" class="form-control m-2" id="cef" name="Nombre_Filere" style=" border-left: .25rem solid #1b2f69!important" autocomplete="off" required id="groupe">
                                                </td>
                                            </tr> -->
                    <!-- button -->
                    <!-- </table>
                                    </form>
                                    <div class="  mt-2  d-flex justify-content-center">
                                        <button class="btn btn " type="submit" name="valider" id="valider" style="background-color: #1b2f69;color:white" onclick="infos()"><i class="fas fa-check"></i> Valider</button>
                                    </div>

                                </div>
                                <div id="importGroup">
                                    <form id="form" class="form2">
                                        <div id="here">
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> -->
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                <main>
                    <div class="container">
                        <form action="./inc/infosCreaction.php" method="POST">
                            <div class="row">
                                <div class="col-25">
                                    <label for="année-scolaire">Année Scolaire :</label>
                                </div>
                                <div class="col-75">
                                    <select class="anneeScolaire" id="année-scolaire" name="anneeScolaire" required>
                                        <option value="-1" disabled>select annee scolaire</option>
                                        <option value="2023-2024">2023-2024</option>
                                        <option value="2024-2025">2024-2025</option>
                                        <option value="2025-2026">2025-2026</option>
                                        <option value="2026-2027">2026-2027</option>

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="année">Année :</label>
                                </div>
                                <div class="col-75">
                                    <td>
                                        <select class="annee" id="année" name="annee" required>
                                            <option value="-1" disabled>select anne</option>
                                            <option value="1ere Annee">1ere Annee</option>
                                            <option value="2eme Annee">2eme Annee</option>
                                        </select>
                                    </td>
                                    </tr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-25">
                                    <label for="groupe" disabled>Nombre:</label>
                                </div>
                                <div class="col-75">
                                    <input type="text" id="groupe" name="nombre" required />
                                </div>
                            </div>

                            <div class="box-submit">
                                <input type="button" value="OK" onclick="infos()" id="button" />
                            </div>
                            <div id="importGroup">
                                <div id="form" class="form2">
                                    <div id="here">
                                    </div>
                                    <input type="submit" name="valider" value="valider" onclick="myFunction()"
                                        id="btnValider" />
                                </div>
                        </form>
                    </div>




                </main>

                <footer class="sticky-footer">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto fs-6">
                            <span>© Copyright | WFS205 |2022</span>
                        </div>
                    </div>
                </footer> <!-- content -->
            </div> <!-- content wrapper -->
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        </div> <!--End wrapper -->
        <!-- <div id="snackbar">l'opération terminée avec succès</div> -->
        <input type="hidden" id="result"></input>
        <input type="hidden" id="success-delete"></input>
        <script>
            // Get the modal
            var modal = document.getElementById("myModal");
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            // When the user clicks on the button, open the modal
            function modalfn() {
                modal.style.display = "block";
            }
            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        <script>
            function myFunction() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'message',
                    showConfirmButton: false,
                    timer: 3000
                })
            }
        </script>
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

        <script>
            var Année_Scolaire = document.getElementById("année-scolaire");
            var Année = document.getElementById("année");
            var filiére = document.getElementById("filiére");
            var Nombre = document.getElementById("groupe");

            function checkSelect() {
                if (
                    Année_Scolaire.value == "" ||
                    Année.value == "" ||

                    Nombre.value == ""
                )
                    return false;
                else return true;
            }

            function infos() {

                if (checkSelect() == true) {

                    let div = document.getElementById("here");
                    div.innerHTML = "";
                    for (let i = 1; i <= parseInt(Nombre.value); i++) {
                        div.innerHTML += `
      <div>
          <label id='color' for='NG'> Nom Filiere :</label>
          <input type='text' name='NG' id='NG'>
        
        
      </div>
`;
                    }
                    document.getElementById("form").style.display = "block";
                    document.getElementById("valider").style.display = "block";
                }
            }

            function myFunction() {

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'message',
                    showConfirmButton: false,
                    timer: 3000
                })
            }
        </script>


</body>

</html>