<?php
session_start();
include_once("../DataBase.php");
if (empty($_SESSION) && ($_SESSION['compteType'] !== 'stagiaire' || $_SESSION['compteType'] !== 'directrice' || $_SESSION['compteType'] !== 'serveillant' || $_SESSION['compteType'] !== 'superAdmin')) {
    header('location:../../login.php');
    exit();
}
// get all inc params needed 
$user = $_SESSION['LoginUser'];
pprint($user);
$oldpass = Validate($_GET['oldpass']);
$newpass = Validate($_GET['newpass']);
$confpass = Validate($_GET['confpass']);

// check password is correct  
$query = $db->Select("compte", "*", "user = '$user'");
$hashed_password = $query[0]->password;
$checkres = password_verify($oldpass, $hashed_password);

if (!$checkres) {

    echo "
<script>
    iziToast.error({

        title: 'Attention',
        message: 'le mot de passe actuel est incorrect!',
    });
</script>
";
    exit();
}

if ($newpass !== $confpass) {
    echo "
    <script>
        iziToast.warning({
            title: 'Attention',
            message: 'Vous avez entré deux mots de passe différents!',
        });
    </script>
    ";
    exit();
}

$password = password_hash($newpass, PASSWORD_DEFAULT);
$query = $db->Update("compte", "password = '$password'", "user = '$user'");
echo "
<script>
    iziToast.success({
        title: 'OK',
        message: 'le mot de passe a été bien changer!',
    });
    setTimeout(() => {
        location.reload()
    }, 1500);
</script>
";
exit();
?>