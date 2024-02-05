<?php
session_start();
$con = require "includes/connection/spajanje.php";
include("includes/functions/funkcije.php");

$putanjaDoPocetna ='index.php';
$pathToAutomobili='automobili.php';
$putanjaDoInstruktora ='instruktori.php';

$pathToLogin="account/login.php";
$pathToRegister="account/register.php";
$pathToRacun="dashboard/";
$pathToLogout="account/logout.php";

// Dohvaćanje svih predmeta iz baze podataka
$sqlPredmeti = "SELECT * FROM predmeti";
$resultPredmeti = $con->query($sqlPredmeti);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pretraži Skripte</title>
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container mt-5 mb-4">
    <h1 class="text-center mb-4">Pretraži Skripte</h1>
    <!-- Search bar -->
    <form class="mb-4" method="post" action="">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Pretraži skripte..." name="searchTerm">
            <select class="form-select" id="selectedSubject" name="selectedSubject">
                <option value="">Odaberi predmet</option>
                <?php
                // Iterirajte kroz rezultat i prikažite opcije u select elementu
                while ($row = $resultPredmeti->fetch_assoc()) {
                    echo "<option value='".$row['predmet_id']."'>".$row['naziv_predmeta']."</option>";
                }
                ?>
            </select>
            <button class="btn btn-primary" type="submit">Pretraži</button>
        </div>
    </form>
    <!-- Cards for displaying scripts -->
    <div class="row">
        <?php
        // Pretraživanje skripti
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Dohvati parametre pretraživanja iz POST zahtjeva
            $searchTerm = $_POST["searchTerm"];
            $selectedSubject = $_POST["selectedSubject"];

            // SQL upit za pretraživanje skripti
            $sql = "SELECT * FROM skripte";
            if (!empty($searchTerm) && empty($selectedSubject)) {
                $sql .= " WHERE naziv_skripte OR opis_skripte LIKE '%$searchTerm%'";
            } elseif (!empty($searchTerm) && !empty($selectedSubject)) {
                $sql .= " WHERE naziv_skripte opis_skripte LIKE '%$searchTerm%' AND predmet_id = $selectedSubject";
            } elseif (empty($searchTerm) && !empty($selectedSubject)) {
                $sql .= " WHERE predmet_id = $selectedSubject";
            }

            // Izvršite SQL upit za pretraživanje skripti
            $result = $con->query($sql);

            // Prikaz rezultata
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Prikaz skripte (npr. koristeći kartice)
                    echo '
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body ">
                                <h5 class="card-title">' . $row["naziv_skripte"] . '</h5>
                                <p class="card-text">' . $row["opis_skripte"] . '</p>
                                <a href="' . $row["skripta_putanja"] . '" class="btn btn-primary" download>Preuzmi PDF</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo "<p class='col'>Nema rezultata.</p>";
            }
        } else {
            // Prikaz prvih 10 skripti ako korisnik nije još ništa pretraživao
            $sql = "SELECT * FROM skripte LIMIT 10";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Prikaz skripte (npr. koristeći kartice)
                    echo '
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body ">
                                <h5 class="card-title">' . $row["naziv_skripte"] . '</h5>
                                <p class="card-text">' . $row["opis_skripte"] . '</p>
                                <a href="' . $row["skripta_putanja"] . '" class="btn btn-primary" download>Preuzmi PDF</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo "<p class='col'>Nema dostupnih skripti.</p>";
            }
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>

</body>
</html>
