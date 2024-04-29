<html>
    <head>
        <link rel="stylesheet" href="../css/validation.css">
        <title>Velorution TN</title>
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
    die(mysqli_error()."connexion echoué");
}
mysqli_select_db($conn, "velorution_tn") or die("eureur de connexion BD");

#récupérer les valeurs des champs
$email = $_POST["email"];

#requete pour vérifier s'il existe une demande avec l'email fourni
$req1 = "SELECT * FROM newsletter WHERE email = '$email'";
$res1 = mysqli_query($conn, $req1);
if (!$res1) {
    die(mysqli_error($conn));
}
else if(mysqli_num_rows($res1)>0){
    ?>
        <div class="result_container">
            <div><img src="../images/icons/warning.png"></div>
            <div><p>Vous etes déja abonné</p></div>
            <link rel="icon" href="../images/icons/bicycle.png">
        </div>
    <?php
}
else if (mysqli_num_rows($res1)==0){
    $req_insert = "INSERT INTO newsletter (email) VALUES('$email')";
    $res_insert = mysqli_query($conn,$req_insert);
    if($res_insert){
    ?>
        <div class="result_container">
            <div><img src="../images/icons/check.png"></div>
            <div><p>vous etes inscrits avec succées a notre newsletter</p></div>
        </div>
    <?php
    }
    else{
        die(mysqli_error($conn));
    }
}
?>
    <!-- footer -->

    <footer>
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