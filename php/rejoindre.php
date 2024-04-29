<html>
    <head>
        <link rel="stylesheet" href="../css/validation.css">
        <title>Velorution TN</title>
        <link rel="icon" href="../images/icons/bicycle.png">
    </head>
<body>
<header class="head-title">
        <!--<h1>Velorution TN</h1>-->
        <a href="../index.html"><img src="../images/logo.png"></a>
    </header>
<?php

#connexion au base de données
$conn = mysqli_connect("localhost", "root", "");
if (!$conn) {
    die(mysqli_error() . "connexion echoué");
}
mysqli_select_db($conn, "velorution_tn") or die("eureur de connexion BD");

#récupérer les valeurs des champs
$nom_pren = $_POST["nom_pren"];
$date_naiss = $_POST["date_naiss"];
$gender = $_POST["gender"];
$num_tel = $_POST["num_tel"];
$email = $_POST["email"];
$ville = $_POST["ville"];
echo $gender;
#requete pour vérifier s'il existe une demande avec l'email fourni
$req1 = "SELECT * FROM demande WHERE email = '$email'";
$res1 = mysqli_query($conn, $req1);
if (!$res1) {
    die(mysqli_error($conn));
}
if (mysqli_num_rows($res1)==0){
    $req_insert = "INSERT INTO demande (nom_prenom,date_naiss,num_tel,ville,gender,email) VALUES('$nom_pren','$date_naiss','$num_tel','$ville','$gender','$email')";
    $res_insert = mysqli_query($conn,$req_insert);
    if($res_insert){
        ?>
        <div class="result_container">
            <div><img src="../images/icons/check.png"></div>
            <div><p>Demande enregistré avec sucées , vous serez notifié le plus tot possible</p></div>
        </div>
    <?php
    }
    else{
        die(mysqli_error($conn));
    }
}
else{
    ?>
        <div class="result_container">
            <div><img src="../images/icons/warning.png"></div>
            <div><p>Demande avec cette email existe déja</p></div>
        </div>
    <?php
}

# Free result set
mysqli_free_result($res1);

# Close connection
mysqli_close($conn);

?>
    <!-- footer -->

    <footer id="footer-rejoindre">
        <div class="container">
            <p>&copy; 2024 Velorution TN</p>
        </div>
        <div class="social-media">
            <a href=""><img src="../images/icons/facebook.png" alt=""></a>
            <a href=""><img src="../images/icons/instagram.png" alt=""></a>
            <a href=""><img src="../images/icons/youtube.png" alt=""></a>
            <a href=""><img src="../images/icons/twitter.png" alt=""></a>
        </div>
    </footer>
</body>
</html>