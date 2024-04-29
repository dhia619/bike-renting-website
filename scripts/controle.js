function validEmail(email){
	const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	if(pattern.test(email)){
        return true;
    }
    else{
        alert("adresse email invalide");
        return false;
    }
}

function validNomPrenom(x){
	const pattern = /^[A-Za-z]+(?:\s[A-Za-z]+)+$/;
	return pattern.test(x);
}

function numtelValide(n){
    const pattern = /^(9|5|4|2)\d{7}$/;
    return pattern.test(n);
}

//controle de saisie pour le formulaire de rejoindre
function validInput(){
    
    //récuperer les valeurs des champs
    let email = document.getElementsByName("email")[0].value;
    let nompren = document.getElementsByName("nom_pren")[0].value;
    let date_naiss = document.getElementsByName("date_naiss")[0].value;
    let num_tel = document.getElementsByName("num_tel")[0].value;
    let gender = document.getElementsByName("gender");

    //vérifier la validité des champs
    if(!validNomPrenom(nompren)){
		alert("Saisir nom et prénom");
	}
    else if(date_naiss==""){
        alert("entrer votre date de naissance");
    }
    else if(new Date(date_naiss) > new Date()){
        alert("date naissance est au futur ?!");
    }
    else if(!gender[0].checked && !gender[1].checked){
        alert("Vous devez précisez votre sexe");
    }
    else if(!numtelValide(num_tel)){
        alert("numéro de téléphone doit étre 8 chiffres et commence par (9,5,4,2)");
    }
    else if(!validEmail(email)){
        //alert("Adresse email non valide");
    }
    else{
        return true;
    }
    return false;

}