<?php
include_once('./inc/DataBase.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate Form Data
    $user = Validate($_POST["matricule"]);
    $password = Validate($_POST["password"]);
    // fetching the data
    $result = $db->Select("compte", "*", "user = '$user'");
    $hashed_password = $result[0]->password;
    if (!empty($result) && (password_verify($password, $hashed_password))) {
        // redirection to main pages
        $_SESSION['LoginUser'] = $user;
        switch ($result[0]->compteType) {
            case 'stagiaire':
                $_SESSION['compteType'] = $result[0]->compteType;
                header('location:./responsable.php');
                exit();
            case 'directrice':
                $_SESSION['compteType'] = $result[0]->compteType;
                header('location:./AccueilDirectrice.php');
                exit();
            case 'serveillant':
                $_SESSION['compteType'] = $result[0]->compteType;
                header('location:./Accueil-serveillant.php');
                exit();
            case 'superAdmin':
                $_SESSION['compteType'] = $result[0]->compteType;
                header('location:./creation.php');
                exit();
        }
    } else {
        header('location:./login.php?error=Login Or Password incorrect');
    }
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
    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .img-fluid {
            position: relative;
            top: 20%;
            left: 10%;
        }
    </style>

</head>

<body class="bg-gradient-primary">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block ">
                                <img src="img/login.jpg" class="img-fluid" alt="login" height="500px" width="400px">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenue!</h1>
                                    </div>
                                    <form method="post" action="./login.php" class="user needs-validation" id="form">

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="matricule"
                                                aria-describedby="emailHelp" placeholder="login" name="matricule">
                                            <!-- message d'erreur pour le login -->
                                            <div class="invalid-feedback blockquote" id="errorMatricule">
                                                Entrez votre login !
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password"
                                                placeholder="Mot de passe" name="password">
                                            <!-- message d'erreur pour le mot de passe -->
                                            <div class="invalid-feedback blockquote" id="errorPassword">
                                                Entrez votre mot de passe !
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit " class="btn btn-primary btn-user btn-block "
                                            id="btn">Login</button>
                                    </form>
                                    <hr>
                                    <!-- <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- script pour la verification du formulaire-->
    <script>

        const loginForm = document.getElementById("form");
        const errorMatricule = document.getElementById("errorMatricule")
        const errorPassword = document.getElementById("errorPassword")
        const submitButton = document.getElementById("btn")

        loginForm.addEventListener("submit", (e) => {

            const matricule = document.getElementById("matricule").value;
            const password = document.getElementById("password").value;
            if (matricule === "") {
                e.preventDefault();
                errorMatricule.classList.add("d-block");

            } else {

                errorMatricule.classList.remove("d-block");


            }
            if (password === "") {
                e.preventDefault();
                errorPassword.classList.add("d-block");
            }
            else {
                errorPassword.classList.remove("d-block");

            }
        })
    </script>
    <?php
    if (!empty($_GET['error'])) {
        ?>
        <script>
            swal("Oops", "Login Or Password incorrect!", "error")
        </script>
        <?php
    }
    ?>
</body>

</html>