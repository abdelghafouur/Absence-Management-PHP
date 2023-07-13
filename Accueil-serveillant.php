<?php
include_once('./inc/DataBase.php');
session_start();
if (empty($_SESSION) or $_SESSION['compteType'] != "serveillant") {
    header('location:./login.php');
}

// vars 
$cureDate = date('Y-m-d');
$absence = 'absence';
$retard = 'retard';
// nbrAbs CureDate
$nbrAbs = $db->Query("SELECT Get_CountAbs_Date('$cureDate','$absence') AS nbr")[0]->nbr;
// nbrRet CureDate
$nbrRet = $db->Query("SELECT Get_CountAbs_Date('$cureDate','$retard') AS nbr")[0]->nbr;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Accueil</title>

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
    <!---- Notyf JS ---->
    <link rel="stylesheet" href="./vendor/notif/css/iziToast.min.css">
    <script src="./vendor/notif/js/iziToast.min.js" type="text/javascript"></script>
    <!---- Notyf JS ---->
    <!-- Ajax -->
    <script>
        $(document).ready(function () {
            // Ajax for Modal
            $('#calendar').on('change', function () {
                let date = $(this).val()
                $.ajax({
                    type: 'GET',
                    url: './inc/Ajax/AjaxCalendar.php',
                    data: { date: date },
                    dataType: 'json',
                    success: function (data) {
                        $("#date-ver").val(date)
                        newRet = data['ret']
                        newAbs = data['abs']
                        newData = [newRet, newAbs]
                        myChart.data.datasets[0].data = newData
                        myChart.update();
                    }
                });
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
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-5 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h4 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">Accueil</h4>

                    <a href="./logout.php" id="Déconnexion">
                        <i class="fas fa-sign-out-alt fa-lg fa-fw mr-2 text-gray-700" aria-hidden="true"></i>
                    </a>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <hr>
                    <!-- Donut Chart -->
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-2 ">
                                <tr>
                                    <th><label for="Date">Date </label></th>
                                    <td>
                                        <input type="date" id="calendar" class="form-select border-left-primary"
                                            aria-label="Default select example" style="
                                        color: gray;
                                        border-radius: 7px;
                                        font-size: 16px;
                                        outline: none;
                                        border-left: .25rem solid #3453af!important;" name="Date" id="Date" required>
                                    </td>
                                </tr>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4">
                                    <canvas id="myChart"></canvas>
                                </div>
                                <hr>
                                <form action="./Absence_par_date.php" method="GET">
                                    <input type="hidden" id="date-ver" name="date-sent" value=<?= $cureDate ?>>
                                    <div class="row ">
                                        <div class="col-sm-12 col-md-6">
                                            <input class="btn btn-default" type="submit" value="absence" name="absence"
                                                style="background-color: #1b2f69;color:white" />
                                        </div>
                                        <div class="col-sm-12 col-md-6 text-right">
                                            <input class="btn btn-default" type="submit" value="retard" name="retard"
                                                style="background-color: #1b2f69;color:white" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
        </div>
        <input type="hidden" id="nbrAbs" value=<?= $nbrAbs ?>>
        <input type="hidden" id="nbrRet" value=<?= $nbrRet ?>>
        <input type="hidden" id="date-ver" value=<?= $cureDate ?>>

    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    </div> <!--End wrapper -->
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        // chart
        let nbrAbs = document.getElementById('nbrAbs').value;
        let nbrRet = document.getElementById('nbrRet').value;
        let myChart = new Chart("myChart", {
            type: "pie",
            data: {
                labels: ["Retared", "Absence"],
                datasets: [
                    {
                        data: [nbrRet, nbrAbs],
                        backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
                        hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 2,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true,
                },
                cutoutPercentage: 80,
            },
            plugins: [
                {
                    id: 'placeholder',
                    afterDraw: (chart) => {
                        if (chart.data.datasets[0].data[0] == 0 && chart.data.datasets[0].data[1] == 0) {
                            const { ctx, chartArea } = chart;
                            ctx.save();
                            ctx.font = "1.2em bolder";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillText("Aucune absence ou retard ce jour", (chartArea.left + chartArea.right) / 2, (chartArea.top + chartArea.bottom) / 2);
                            ctx.restore();
                        }
                    }
                }
            ]
        });
    </script>
</body>

</html>