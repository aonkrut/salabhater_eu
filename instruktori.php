<?php

$con = require "includes/connection/spajanje.php";
include("includes/functions/funkcije.php");
session_start();
$putanjaDoPocetna ='index.php';
$pathToAutomobili='automobili.php';
$putanjaDoInstruktora ='instruktori.php';

$pathToLogin="account/login.php";
$pathToRegister="account/register.php";
$pathToRacun="dashboard/";
$pathToLogout="account/logout.php";


$sqlSviInstruktori = "SELECT korisnik.korisnik_id, instruktori.instruktor_id, predmeti.predmet_id, ime,prezime,email,adresa,naziv_grada, status_naziv, naziv_predmeta FROM korisnik, statuskorisnika, instruktori,instruktorovipredmeti,predmeti,gradovi WHERE korisnik.korisnik_id=instruktori.korisnik_id AND instruktori.instruktor_id=instruktorovipredmeti.instruktor_id AND instruktorovipredmeti.predmet_id=predmeti.predmet_id AND korisnik.status_korisnika=statuskorisnika.status_id AND korisnik.mjesto=gradovi.grad_id";
$resultSviInstruktori = $con->query($sqlSviInstruktori);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruktori</title>

    
     <!-- Favicons -->
     <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Bootstrap CSS include -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">


</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="main-body">
        <div class="row gutters-sm">
            <?php while($red = $resultSviInstruktori->fetch_assoc()): ?>
            <div class="col-md-4 mb-5 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="100">
                            <div class="mt-3">
                                <h4> <?php echo $red["ime"]. " " . $red["prezime"]?></h4>
                                <?php echo $red['naziv_predmeta'];?>
                                <p class="text-secondary mb-1">
                                <?php echo $red['status_naziv']; ?> </p>
                                <p class="text-muted font-size-sm"><?php echo $red["naziv_grada"]; ?></p>
                                <a class="btn btn-primary" href="profil?instruktor_id=<?php echo $red['instruktor_id']?>">Pogledaj profil</a>
                                
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>