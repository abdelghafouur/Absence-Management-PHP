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
    // get Absence 
    $grp = $_GET["groupe"];
    $absence = $db->Select("absence", "*", "idGroupe = $grp  and justifier ='no'");

    // get group name
    $group = $db->Select("groupe", "nomGroupe", "idGroupe = $grp")[0]->nomGroupe;
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

    <title>Liste des absences par groupe</title>

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
            $("#back_btn").click(function (ev) {
                ev.preventDefault()
                window.history.back();
            });
            let errorgenral = 1
            const countrow = parseInt($('#trcount').val())
            $('#validee').click(function (ev) {
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
            });
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


            // ajax for Delete Ansence
            for (i = 0; i <= countrow; i++) {
                $("#tr-" + i + " button").on('click', function () {
                    const idAbsence = $(this).val()
                    iziToast.question({
                        timeout: 20000,
                        close: false,
                        overlay: true,
                        displayMode: 'once',
                        id: 'question',
                        zindex: 999,
                        title: 'Etes-vous sûr?',
                        message: "Vous ne pourrez pas revenir en arrière !",
                        position: 'center',
                        buttons: [
                            ['<button><b>YES</b></button>', function (instance, toast) {
                                if (idAbsence) {
                                    $.post({
                                        url: './inc/Ajax/DeleteAbsence.php',
                                        data: { idAbsence: idAbsence },
                                        success: function (data) {
                                            $("#success-delete").html(data)
                                        }
                                    });
                                }
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            }, true],
                            ['<button>NO</button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            }],
                        ],
                        onClosing: function (instance, toast, closedBy) {
                            console.info('Closing | closedBy: ' + closedBy);
                        },
                        onClosed: function (instance, toast, closedBy) {
                            console.info('Closed | closedBy: ' + closedBy);
                        }
                    });
                })
            };
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
                    <h4 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">Liste des absences par groupe</h4>
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
                                <button class="btn btn" type="submit" name="AjaxValider" id="valider"
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
                    } elseif (isset($_GET["AjaxValider"]) && empty($absence)) {
                        ?>
                        <h1 class="text-center mt-5"> Aucune absence pour ce groupe

                        </h1>
                        <?php
                    } else {
                        ?>
                        <div class="card shadow mt-5">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary" id="bienvenue">Groupe
                                    <?= $group ?>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
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
                                                    <th>Date</th>
                                                    <th>Module</th>
                                                    <th>Heure début</th>
                                                    <th>Heure Fin</th>
                                                    <th>Justifier</th>
                                                    <th>Nature de justification</th>
                                                    <th>Supprimer l'absence</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $c = 0;
                                                foreach ($absence as $key => $value) {
                                                    $stg = $db->Select('stagiaire', "*", "CEF = $value->CEF")[0];
                                                    $formateur = $db->Select('formateur', "concat(nomFormateur,' ',PrenomFormateur) as fullname ", "matricule = '$value->matricule'")[0]->fullname;
                                                    $module = $db->Select('module', "nomModule", "idModule = $value->moduleAbsence")[0]->nomModule;
                                                    pprint($formateur);
                                                    ?>

                                                    <tr id='tr-<?= $c++ ?>'>
                                                        <td>
                                                            <?= $value->CEF ?>
                                                        </td>
                                                        <td>
                                                            <?= $stg->nomStagiaire ?>
                                                        </td>
                                                        <td>
                                                            <?= $stg->prenomStagiaire ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->type ?>
                                                        </td>
                                                        <td>
                                                            <?= $formateur ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->dateAbsence ?>
                                                        </td>
                                                        <td>
                                                            <?= $module ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->heureDebutAbsence ?>
                                                        </td>
                                                        <td>
                                                            <?= $value->heureDebutAbsence ?>
                                                        </td>

                                                        <td>
                                                            <input type="checkbox" class="btn1"
                                                                name="check-btn-<?= $value->CEF ?>" id="justifier"
                                                                value="justifier" onclick="Enable(this)">
                                                        </td>
                                                        <td>
                                                            <input disabled type="text" name="justif-<?= $value->CEF ?>"
                                                                id="justification" name="justification" class="commentaire">
                                                        </td>
                                                        <td> <button id="" type="button" class="btn  btn-circle"
                                                                value="<?= $value->idAbsence ?>">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    <input type="hidden" name="idAbs-<?= $value->CEF ?>"
                                                        value="<?= $value->idAbsence ?>" />
                                                </tbody>
                                                <?php
                                                }
                                                ?>
                                            <input type="hidden" id="trcount" value="<?= $c ?>" />
                                        </table>
                                        <input class="btn btn-success float-left  mb-5" type="submit" value="valider"
                                            id="validee" class='button' name="sent-verf" />
                                    </form>
                                </div> <!-- table-responsive -->

                                <!-- End of table -->
                                <?php
                    }
                    ?>
                        </div>
                        <!-- container-fluid-->
                    </div>
                    <footer class="sticky-footer">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto fs-6">
                                <span>© Copyright | WFS205 |2022</span>
                            </div>
                        </div>
                    </footer> <!-- content -->
                </div>

            </div>
            <!-- content wrapper -->
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
        <input type="hidden" id="success-delete">

</body>

</html>