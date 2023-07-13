<?php
session_start();
if (empty($_SESSION) || $_SESSION['compteType'] != "directrice") {
  header('location:./login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Changer le mot de passe</title>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />
  <!-- jquery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
    integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!---- Notyf JS ---->
  <link rel="stylesheet" href="./vendor/notif/css/iziToast.min.css">
  <script src="./vendor/notif/js/iziToast.min.js" type="text/javascript"></script>
  <!---- Notyf JS ---->
  <!-- Ajax -->
  <script defer>
    $(document).ready(function () {
      $("#valider").on("click", function (e) {
        e.preventDefault();
        const oldpass = $('#oldpass').val();
        const newpass = $('#newpass').val();
        const confpass = $('#confpass').val();
        if (oldpass !== "" && newpass !== "" && confpass !== "") {
          $.get(
            './inc/Ajax/ChangePassword.php',
            { oldpass: oldpass, newpass: newpass, confpass: confpass },
            function (data) {
              $('#res').html(data)
            }
          );
        } else {
          alert('Please All input required');
        }
      });
    });
  </script>
</head>

<body id="page-top">
  <!-- Divider -->
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light bg-white topbar mb-5 static-top shadow">
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>
        <h5 class="mr-auto ml-md-3 my-2 my-md-0 mw-100 font-weight-bold">
          Changer le mot de passe
        </h5>
        <a href="./logout.php"><i class="fas fa-sign-out-alt fa-lg fa-fw text-gray-700"></i></a>
      </nav>
      <!-- End of Topbar -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <div class="d-flex justify-content-center align-items-center">
          <div class="card shadow py-5 w-50 d-flex justify-content-center align-items-center w-50 p-4 mt-7"
            style="border-left: 0.25rem solid #3453af !important">
            <div>
              <!-- CEF input -->
              <div class="form-group mt-6">
                <div class="form-row">
                  <label class="col-md-6 font-weight-bolder" for="nom">Mot de passe actuel :</label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" id="oldpass" name="Password"
                      style="border-left: 0.25rem solid #3453af !important" autocomplete="off" required />
                  </div>
                </div>
              </div>
              <!--  nom input -->
              <div class="form-group">
                <div class="form-row">
                  <label class="col-md-6 font-weight-bolder" for="nom">Nouveau mot de passe :</label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" id="newpass" name="nouveauPassword"
                      style="border-left: 0.25rem solid #3453af !important" autocomplete="off" required />
                  </div>
                </div>
              </div>
              <!-- prénom input -->
              <div class="form-group">
                <div class="form-row">
                  <label class="col-md-6 font-weight-bolder" for="nom">Confirmer le mot de passe :</label>
                  <div class="col-md-9">
                    <input id="confpass" name="ConfirmedPassword" type="password" class="form-control"
                      style="border-left: 0.25rem solid #3453af !important" autocomplete="off" required />
                  </div>
                </div>
              </div>

              <!-- Button Valider -->
              <div class="row mt-5 justify-content-center">
                <button class="btn btn" type="submit" onClick="validation()" name="valider" id="valider"
                  style="background-color: #3453af; color: white">
                  <i class="fas fa-check"></i> Valider
                </button>
              </div>
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
      <input type="hidden" id='res'>
    </div>
    <!---Fermeture div class content-->
  </div>
  <!---Fermeture div id="content-wrapper"-->

  <!---Javascript-->
  <script>
    function validation() {
      var actuel = document.getElementById("oldpass");
      var nouveau = document.getElementById("newpass");
      var confirmer = document.getElementById("confpass");
      if (nouveau.value == "" || confirmer.value == "") {
        alert("les champs ne sont pas remplis");
        nouveau.focus();
        return false;
      } else if (nouveau.value != confirmer.value) {
        alert("Ce ne sont pas les mêmes mots de passe!");
        nouveau.focus();
        return false;
      } else if (nouveau.value == confirmer.value) {
        return true;
      } else {
        nouveau.focus();
        return false;
      }
    }
  </script>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
</body>

</html>