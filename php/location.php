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
$num_tel = $_POST["num_tel"];
$email = $_POST["email"];
$type_velo = $_POST["typeV"];
$couleur_velo = $_POST["colV"];
$date_loc = $_POST["date_loc"];
$heure_loc = $_POST["heure_loc"];
$date_ret = $_POST["date_ret"];
$heure_ret = $_POST["heure_ret"];
$methode_pay = $_POST["paiement"];
$montant = $_POST["prix_total"];
echo $montant;
$id_client = 0;
$id_velo = 0;

function get_client_id($conn,$email){
    $req_get_id_client = "SELECT * FROM client WHERE email='$email'";
    $res_get_id_client = mysqli_query($conn,$req_get_id_client);
    if($req_get_id_client && mysqli_num_rows($res_get_id_client)>0){
        $client = mysqli_fetch_assoc($res_get_id_client);
        $id_client = $client["id_client"];
        return $id_client;
    }
    return false;
}

#vérifier disponiblité de vélo désiré
$req_velo_dispo = "SELECT * FROM velo WHERE type='$type_velo' and couleur='$couleur_velo' and etat='disponible' LIMIT 1";
$res_velo_dispo = mysqli_query($conn,$req_velo_dispo);
if($res_velo_dispo){
    if(mysqli_num_rows($res_velo_dispo)>0){
        #vérifier si client existe déja
        if(get_client_id($conn,$email)){
            $id_client = get_client_id($conn,$email);
        }
        else{
            #insérer client dans la table client
            $req_insert_client = "INSERT INTO client(nom_prenom,date_naiss,num_tel,email) VALUES('$nom_pren','$date_naiss','$num_tel','$email')";
            $res_insert_client = mysqli_query($conn,$req_insert_client);
            if(!$res_insert_client){
                echo "client n'est pas insérer";
                die(mysqli_error($conn));
            }
            $id_client = get_client_id($conn,$email);
        }

        //chercher id velo louée
        $velo = mysqli_fetch_assoc($res_velo_dispo);
        $id_velo = $velo['id_velo'];
        #mise a jour l'etat de vélo
        $req_maj_etat_velo = "UPDATE velo SET etat='indisponible' WHERE id_velo='$id_velo' LIMIT 1";
        $res_maj_etat_velo = mysqli_query($conn,$req_maj_etat_velo);
        if($req_maj_etat_velo){
            #ajouter au table location
            $req_insert_loc = "INSERT INTO location(id_client,date_location,heure_location,date_retour,heure_retour,id_velo,methode_paiement,montant)
                                            VALUES($id_client,'$date_loc','$heure_loc','$date_ret','$heure_ret',$id_velo,'$methode_pay','$montant')";
            $res_insert_loc = mysqli_query($conn,$req_insert_loc);
            if($res_insert_loc){
                ?>
                <div class="dispo_result_container">
                    <div><img src="../images/icons/check.png"></div>
                    <div>
                        <p>vélo disponible<br>vous pouvez la recevoir le<span id="date_loc"> <?php echo $date_loc ?>  <?php echo $heure_loc ?></span> depuis nos locals</p>
                        <p>montant : <span id="montant"><?php echo $montant ?> TND</span></p>
                    </div>
                </div>
                <div id="carte">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7874.141992905928!2d10.169715170357241!3d36.835749269732574!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd33444ce2ee47%3A0x8dc7ffce4cd47add!2sDar%20Bisklette%20-%20(V%C3%A9lorution%20Tunisie)!5e0!3m2!1sfr!2stn!4v1714342898487!5m2!1sfr!2stn" width="500" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <?php
            }
            else{
                die(mysqli_error($conn));//erreur lié insertion location
            }
        }
        else{
            die(mysqli_error($conn));//erreur lié maj etat velo
        }
    }
    else{
        ?>
        <div class="indispo_result_container">
            <div><img src="../images/icons/warning.png"></div>
            <div><p>velo désiré indisponible pour le moment</p></div>
        </div>
        <?php
    }
}
else{
    die(mysqli_error($conn));//erreur lié recherche velo
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